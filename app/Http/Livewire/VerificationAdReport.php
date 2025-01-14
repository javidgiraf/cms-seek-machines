<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Include this for pagination
use App\Models\Sellmachine;
use App\Exports\VerifiedAdExport;
use Maatwebsite\Excel\Facades\Excel;

class VerificationAdReport extends Component
{
    use WithPagination; // Use pagination

    public $paginationTheme = 'bootstrap';
    public $keyword;
    public $startDate;
    public $endDate;
    public $perPage = 10;
    protected $listeners = ['dateRangePicker' => 'updateDateRange'];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when searching
    }

    public function mount($isverified = null, $startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $isverified;
    }

    public function render()
    {
        $sellMachines = $this->filteredQuery()->paginate(25); // Use paginate directly

        return view('livewire.verification-ad-report', compact('sellMachines'));
    }

    public function downloadExcel()
    {
        $sellMachines = $this->filteredQuery()->get();
        return Excel::download(new VerifiedAdExport($sellMachines), 'verified-report.xlsx');
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
        $this->resetPage(); // Reset pagination when keyword changes
    }

    public function updatedStartDate()
    {
        $this->resetPage(); // Reset pagination when start date changes
    }

    public function updatedEndDate()
    {
        $this->resetPage(); // Reset pagination when end date changes
    }

    public function filteredQuery()
    {
        $threeMonthsAgo = now()->subMonths(3);

        $query = Sellmachine::with('machine_catalog', 'sell_machines_image')
            ->join('users', 'users.id', '=', 'sell_machines.user_id')
            ->leftJoin('verification_reasons', 'verification_reasons.sell_machine_id', '=', 'sell_machines.id')
            ->where('sell_machines.isverified', 1);

        if (!empty($this->keyword)) {
            $keyword = $this->keyword;

            $query->where(function ($query) use ($keyword) {
                $query->where('sell_machines.title', 'like', '%' . $keyword . '%')
                    ->orWhere('sell_machines.item_code', 'like', '%' . $keyword . '%')
                    ->orWhere('sell_machines.modelno', 'like', '%' . $keyword . '%')
                    ->orWhere('users.name', 'like', '%' . $keyword . '%');
            });
        }


        if ($this->startDate && $this->endDate) {
          $query->whereBetween('verification_reasons.verified_on', [$this->startDate, $this->endDate]);

        }

        return $query->orderby('sell_machines.id', 'desc');
    }
}
