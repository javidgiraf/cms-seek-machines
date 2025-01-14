<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sellmachine;
//use Livewire\WithPagination;

class SellingMachineAdFilters extends Component
{
    //  use WithPagination;
    protected $paginationTheme = 'bootstrap';

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

            $sql = Sellmachine::with('machine_catalog')
                ->with('sell_machines_image')
                ->select('sell_machines.*')
                ->join('users', 'users.id', '=', 'sell_machines.user_id')
                ->where(function ($query) use ($keyword) {
                    $query->where('sell_machines.title', 'like', '%' . $keyword . '%')
                        ->orWhere('sell_machines.item_code', 'like', '%' . $keyword . '%')
                        ->orWhere('sell_machines.modelno', 'like', '%' . $keyword . '%')
                        ->orWhere('users.name', 'like', '%' . $keyword . '%');
                });

            if ($this->status != "") {
                $sql->where('sell_machines.status', $this->status);
            }
            $sellMachines = $sql->orderby('sell_machines.id', 'desc')
                ->paginate(25);
        } else {

            if ($this->status != "") {

                $sellMachines = Sellmachine::with('machine_catalog')
                    ->with('sell_machines_image')
                    ->select('sell_machines.*')
                    ->join('users', 'users.id', '=', 'sell_machines.user_id')
                    ->where('sell_machines.status', $this->status)
                    ->orderby('sell_machines.id', 'desc')
                    ->paginate(25);
            } else {
                $sellMachines = Sellmachine::with('machine_catalog')
                    ->with('sell_machines_image')
                    ->select('sell_machines.*')
                    ->join('users', 'users.id', '=', 'sell_machines.user_id')
                    ->orderby('sell_machines.id', 'desc')
                    ->paginate(25);
            }
        }

        return view('livewire.selling-machine-ad-filters', compact('sellMachines'));
    }
}
