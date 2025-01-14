<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BoostAdPackage;
use App\Models\BoostAd;
use App\Exports\BoostAdPackageExport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

class HotDealReport extends Component
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

    $sql = BoostAdPackage::withCount(['boostAds' => function ($query) {

      if ($this->startDate && $this->endDate) {
        $query->where('start_date', '>=', $this->startDate)
        ->where('end_date', '<=', $this->endDate);
      }
    }])->withSum(['boostAds' => function ($query) {
      if ($this->startDate && $this->endDate) {
        $query->where('start_date', '>=', $this->startDate)
        ->where('end_date', '<=', $this->endDate);
      }
    }], 'total_amount');


    if (!empty($this->keyword)) {
      $sql->where('boost_ad_packages.title', 'like', '%' . $this->keyword . '%');
    }
      $sql->having('boost_ads_count', '>', 0);

    if ($this->startDate && $this->endDate) {
      $sql->whereHas('boostAds', function ($query) {
        $query->where('start_date', '>=', $this->startDate)
        ->where('end_date', '<=', $this->endDate);
      });
    }

    return $sql->paginate($this->perPage);
  }

  public function render()
  {
    $packages = $this->filteredQuery();


    return view('livewire.hot-deal-report', ['packages' => $packages]);
  }

  public function downloadExcel()
  {

      $query = BoostAd::with('package');

      if ($this->startDate && $this->endDate) {
          $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                ->orWhereBetween('end_date', [$this->startDate, $this->endDate]);
      }

      if (!empty($this->keyword)) {
          $query->whereHas('boostAdPackage', function ($q) {
              $q->where('title', 'like', '%' . $this->keyword . '%');
          });
      }

      $ads = $query->get();

      return Excel::download(new BoostAdPackageExport($ads), 'boost_ads.xlsx');
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
