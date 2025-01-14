<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sellmachine; // Ensure you import the Sellmachine model
use Livewire\WithPagination;
use App\Exports\BuyersExport;
use Maatwebsite\Excel\Facades\Excel;

class BuyersReport extends Component
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
    // Initialize the query for Sellmachine with the count of subscribe visits
    $query = Sellmachine::withCount(['subscribeVisits' => function ($query) {
      // Filter subscribe visits based on the visited_at date range
      if ($this->startDate && $this->endDate) {
        $query->whereBetween('visited_at', [$this->startDate, $this->endDate]);
      }
    }]);

    // Optionally, apply keyword filtering if needed
    if ($this->keyword) {
      $query->where('title', 'like', '%' . $this->keyword . '%'); // Adjust the field to your needs
    }

    // Filter to only include machines that have visitors
    $query->having('subscribe_visits_count', '>', 0); // This ensures only machines with visitors are included

    // Return the paginated result
    return $query->orderBy('id', 'desc')->paginate($this->perPage);
  }

  public function render()
  {
    $sellMachines = $this->filteredQuery(); // Removed the extra space here

    return view('livewire.buyers-report', ['sellMachines' => $sellMachines]); // Corrected variable name
  }
  public function exportQuery()
  {

    $query = Sellmachine::withCount(['subscribeVisits' => function ($query) {

      if ($this->startDate && $this->endDate) {
        $query->whereBetween('visited_at', [$this->startDate, $this->endDate]);
      }
    }]);

    if ($this->keyword) {
      $query->where('title', 'like', '%' . $this->keyword . '%');
    }

    $query->having('subscribe_visits_count', '>', 0);
    return $query;
  }

  public function downloadExcel()
  {
    $sellMachines = $this->exportQuery()->orderBy('id', 'desc')->get();

    return Excel::download(new BuyersExport($sellMachines), 'machine-ad-paid-visitors-report.xlsx');
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
