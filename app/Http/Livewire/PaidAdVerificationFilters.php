<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sellmachine;
use App\Services\BannerService;

class PaidAdVerificationFilters extends Component
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

            $sql = Sellmachine::select('sell_machines.*')
                ->join('users', 'users.id', '=', 'sell_machines.user_id')
                ->where(function ($query) use ($keyword) {
                    $query->where('sell_machines.title', 'like', '%' . $keyword . '%')
                        ->orWhere('sell_machines.item_code', 'like', '%' . $keyword . '%')
                        ->orWhere('sell_machines.modelno', 'like', '%' . $keyword . '%')
                        ->orWhere('users.name', 'like', '%' . $keyword . '%');
                });

            if ($this->status != "") {
                $sql->where('sell_machines.isverified', $this->status);
            }
            $sellMachines = $sql->whereNotNull('verify_submitted_on')
                ->orderby('sell_machines.title', 'asc')
                ->paginate(25);

        } else {

            if ($this->status != "") {

                $sellMachines = Sellmachine::select('sell_machines.*')->join('users', 'users.id', '=', 'sell_machines.user_id')
                    ->where('sell_machines.isverified', $this->status)
                    ->whereNotNull('verify_submitted_on')
                    ->orderby('sell_machines.title', 'asc')
                    ->paginate(25);
            } else {
                $sellMachines = Sellmachine::select('sell_machines.*')
                    ->join('users', 'users.id', '=', 'sell_machines.user_id')
                    ->whereNotNull('verify_submitted_on')
                    ->orderby('sell_machines.title', 'asc')
                    ->paginate(25);
            }
        }
        return view('livewire.paid-ad-verification-filters', compact('sellMachines'));
    }
}
