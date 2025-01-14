<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sellmachine;
use App\Exports\MachineListExport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

class MachineReport extends Component
{
  use WithPagination;

  public $paginationTheme = 'bootstrap';
  public $keyword;
  public $startDate;
  public $endDate;
  public $status;
  public $perPage = 10;
  protected $listeners = ['dateRangePicker' => 'updateDateRange'];


  public function mount($startDate = null, $endDate = null,$status=null)
  {
      $this->startDate = $startDate;
      $this->endDate = $endDate;
      $this->status = $status;
  }


  public function filteredQuery()
  {
    $sql = Sellmachine::with('machine_catalog')
    ->with('sell_machines_image')
    ->select('sell_machines.*')
    ->join('users', 'users.id', '=', 'sell_machines.user_id');


    if (!empty($this->keyword)) {
      $keyword = $this->keyword;
      $sql->where(function ($query) use ($keyword) {
        $query->where('sell_machines.title', 'like', '%' . $keyword . '%')
        ->orWhere('sell_machines.item_code', 'like', '%' . $keyword . '%')
        ->orWhere('sell_machines.modelno', 'like', '%' . $keyword . '%')
        ->orWhere('users.name', 'like', '%' . $keyword . '%');
      });
    }
    if ($this->status !== null) {

       $sql->where('status', $this->status);
   }

    if ($this->startDate && $this->endDate) {
      $sql->whereBetween('sell_machines.created_at', [$this->startDate, $this->endDate]);
    }

    return $sql;
  }


  public function render()
  {
    $sellMachines = $this->filteredQuery()->orderBy('sell_machines.id', 'desc')->paginate($this->perPage);

    return view('livewire.machine-report', ['sellMachines' => $sellMachines]);
  }


  public function downloadExcel()
  {

    $sellMachines = $this->filteredQuery()->orderby('sell_machines.id', 'desc')->get();

    return Excel::download(new MachineListExport($sellMachines), 'machines.xlsx');
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
