<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BoostAd;
use Livewire\WithPagination;

class HotDealDetails extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';
    public $keyword;
    public $startDate;
    public $endDate;
    public $packageId; // Corrected this property
    public $perPage = 10;
    protected $listeners = ['dateRangePicker' => 'updateDateRange'];

    public function mount()
    {
        // Get the packageId from the query string
        $this->packageId = request()->query('packageId');
        $this->startDate = request()->query('startDate', null);
        $this->endDate = request()->query('endDate', null);


    }

    public function filteredQuery()
  {
      // Start the query on BoostAd model
      $query = BoostAd::where('package_id', $this->packageId);

      // Apply date filtering if both startDate and endDate are provided
      if ($this->startDate && $this->endDate) {
          $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                ->orWhereBetween('end_date', [$this->startDate, $this->endDate]);
      }

      // Optionally, if you have a keyword search
      if ($this->keyword) {
          $query->where(function ($q) {
              $q->where('total_amount', 'like', "%{$this->keyword}%")
                ->orWhereHas('sellmachine', function ($query) {
                    $query->where('title', 'like', "%{$this->keyword}%");
                });
          });
      }

      return $query->paginate($this->perPage);
  }


    public function render()
    {
        $packages = $this->filteredQuery();
    

        return view('livewire.hot-deal-details', ['packages' => $packages]);
    }

    public function updateDateRange($dateRange)
    {
        $this->startDate = $dateRange['startDate'];
        $this->endDate = $dateRange['endDate'];

        $this->emit('updateBrowserHistory', ['start_date' => $this->startDate, 'end_date' => $this->endDate]);
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
