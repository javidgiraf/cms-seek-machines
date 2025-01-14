<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Banner;
use DB;
use APP;
use Livewire\WithPagination;
use App\Services\BannerService;

class BoostAdFilters extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $keyword;


    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $banners = Banner::all();

        return view('livewire.boosted-ad-filters', compact('banners'));
    }
    public function resetFilters()
    {

        $this->reset(['category', 'brand', 'keyword',  'sortby', 'search']);
        // Will reset both the search AND the isActive property.

        //$this->resetExcept('search');
        // Will only reset the isActive property (any property but the search property).

        $this->resetPage();
    }
}
