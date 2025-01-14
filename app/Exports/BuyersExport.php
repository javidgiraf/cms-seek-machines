<?php

namespace App\Exports;

use App\Models\Sellmachine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BuyersExport implements FromCollection, WithHeadings
{
    protected $sellMachines;

    public function __construct($sellMachines)
    {
        $this->sellMachines = $sellMachines;
    }

    public function collection()
    {
        return $this->transformSellMachines();
    }

    public function headings(): array
    {
        return [
             'Item Code',
             'Model No',
            'Machine Title',
            'Industry',
            'Visitors Count'
        ];
    }

    // Transform the collection to the desired format
    public function transformSellMachines()
    {
        return $this->sellMachines->map(function ($sellMachine) {
            return [
                'Item Code' => $sellMachine->item_code,
                 'Model No' => $sellMachine->modelno,
                'Machine Title' => \Str::limit($sellMachine->title, 40, '...'),
                 'Industry' => optional($sellMachine->category)->name, // Prevent errors using optional
                 'Visitors Count' => $sellMachine->subscribe_visits_count,
                
            ];
        });
    }

   
    protected function getStatusLabel($status)
    {
        switch ($status) {
            case 1:
                return 'Active';
            case 2:
                return 'Pending';
            default:
                return 'Inactive';
        }
    }
}
