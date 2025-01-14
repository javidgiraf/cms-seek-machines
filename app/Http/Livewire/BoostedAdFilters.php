<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Banner;
use DB;

class BoostedAdFilters extends Component
{
    public $keyword;
    public $status;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($status)
    {
        // Assign the passed data to the component property
        $this->status = $status;
    }

    public function render()
    {
        if (!empty($this->keyword)) {

            $keyword = $this->keyword;


            $sql = Banner::select('banners.*')->join('boost_ads', 'boost_ads.id', '=', 'banners.boost_ad_id')
                ->where(function ($query) use ($keyword) {
                    $query->where('banners.title', 'like', '%' . $keyword . '%');
                });

            if ($this->status != "") {
                $sql->where('boost_ads.status', $this->status);
            }
            $banners = $sql->orderby('banners.title', 'asc')
                ->paginate(25);
        } else {

            if ($this->status != "") {

                $banners = Banner::select('banners.*')
                    ->join('boost_ads', 'boost_ads.id', '=', 'banners.boost_ad_id')
                    ->where('boost_ads.status', $this->status)
                    ->orderby('banners.title', 'asc')
                    ->paginate(25);
            } else {
                $banners = Banner::select('banners.*')
                    ->join('boost_ads', 'boost_ads.id', '=', 'banners.boost_ad_id')
                    ->orderby('banners.title', 'asc')
                    ->paginate(25);
            }
        }

        return view('livewire.boosted-ad-filters', compact('banners'));
    }
}
