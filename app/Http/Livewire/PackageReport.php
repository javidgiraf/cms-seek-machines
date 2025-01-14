<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscription;
use App\Exports\PackageExport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

class PackageReport extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';
    public $keyword;
    public $startDate;
    public $endDate;
    public $perPage = 10;

    protected $listeners = ['dateRangePicker' => 'updateDateRange'];

    public function mount($startDate = null, $endDate = null)
    {

            $this->startDate = $startDate;
            $this->endDate = $endDate;

    }

  public function filteredQuery()
{
    $query = Subscription::with('membership')
        ->select('plan_id') // Select the plan_id
        ->selectRaw('COUNT(plan_id) as plan_count') // Count the number of plans
        ->leftJoin('transaction_subscriptions as trans_sub', 'subscriptions.id', '=', 'trans_sub.subscription_id')
        ->leftJoin('transactions', 'trans_sub.transaction_id', '=', 'transactions.id')
        ->selectRaw('SUM(sm_transactions.total_amount) as total_amount') // Sum the total amount
        ->groupBy('plan_id') // Group by plan_id
        ->orderByRaw('plan_count ASC'); // Order by plan_count

    // Apply date range filter if provided
    if ($this->startDate && $this->endDate) {
        $query->whereBetween('subscriptions.start_at', [$this->startDate, $this->endDate]);
    }

    // Order by an aggregated field (plan_count, total_amount) or one of the grouped columns
    return $query->orderBy('plan_count', 'desc')->paginate($this->perPage);
}



    public function render()
  {
      $packages = $this->filteredQuery();

      return view('livewire.package-report', ['packages' => $packages]);
  }

  public function downloadExcel()
  {

    $packages = Subscription::with('membership')
        ->leftJoin('transaction_subscriptions as trans_sub', 'subscriptions.id', '=', 'trans_sub.subscription_id')
        ->leftJoin('transactions', 'trans_sub.transaction_id', '=', 'transactions.id')

        ->select('subscriptions.*', 'transactions.total_amount as total_amount');

      // Apply date range filter if provided
      if ($this->startDate && $this->endDate) {
          $packages->whereBetween('subscriptions.start_at', [$this->startDate, $this->endDate]);
      }

      $packages = $packages->orderBy('start_at', 'ASC')->get(); // Get all results for download

      return Excel::download(new PackageExport($packages), 'package-report.xlsx');
  }

    public function updateDateRange($dateRange)
    {
        $this->startDate = $dateRange['startDate'];
        $this->endDate = $dateRange['endDate'];

        $this->emit('updateBrowserHistory', [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);
    }

    public function updatedKeyword()
    {
        $this->resetPage();
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }
}
