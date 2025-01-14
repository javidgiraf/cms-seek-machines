<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscription;
use App\Exports\MachineAdExport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

class PackageDetailReport extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';
    public $keyword;
    public $startDate;
    public $endDate;
    public $plan_id; // Add this property
    public $perPage = 10;

    protected $listeners = ['dateRangePicker' => 'updateDateRange'];

    public function mount($plan_id = null, $startDate = null, $endDate = null)
    {
        $this->plan_id = $plan_id; // Set the plan_id here
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function filteredQuery()
    {
        $subscriptions = Subscription::with('membership')
            ->leftJoin('transaction_subscriptions as trans_sub', 'subscriptions.id', '=', 'trans_sub.subscription_id')
            ->leftJoin('transactions', 'trans_sub.transaction_id', '=', 'transactions.id')
            ->where('plan_id', $this->plan_id) // Ensure to use the subscriptions table for plan_id
            ->select('subscriptions.*', 'transactions.total_amount as total_amount');

        // Apply date filtering if dates are set
        if ($this->startDate && $this->endDate) {
            $subscriptions->whereBetween('subscriptions.start_at', [$this->startDate, $this->endDate]);
        }

        return $subscriptions->orderBy('subscriptions.id', 'desc')->paginate($this->perPage);
    }

    public function render()
    {
        $subscriptions = $this->filteredQuery(); // No need for additional ordering and pagination here

        return view('livewire.package-detail-report', ['subscriptions' => $subscriptions]);
    }

    public function downloadExcel()
    {
        $packages = $this->filteredQuery()->orderby('subscriptions.id', 'desc')->get();

        return Excel::download(new MachineAdExport($packages), 'package-report.xlsx');
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
