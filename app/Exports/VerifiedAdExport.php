<?php

namespace App\Exports;

use App\Models\Sellmachine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VerifiedAdExport implements FromCollection, WithHeadings
{
    protected $sellMachines;

    public function __construct($sellMachines)
    {
        $this->sellMachines = $sellMachines; // Store the sell machines collection
    }

    public function collection()
    {
        return $this->transformSellMachines(); // Return the transformed data
    }

    public function headings(): array
    {
        return [
            'Title',
            'Item Code',
            'Model No',
            'Industry',
            'Customer',
            'Year',
            'Origin',
            'Ad Status',
            'Verified On',
        ];
    }

    // Transform the collection to the desired format
    public function transformSellMachines()
    {
        return $this->sellMachines->map(function ($sellMachine) {
            return [
                'Title' => $sellMachine->title,
                'Item Code' => $sellMachine->item_code,
                'Model No' => $sellMachine->modelno,
                'Industry' => optional($sellMachine->category)->name, // Use optional to prevent errors
                'Customer' => optional($sellMachine->user->customer)->company . ' / ' . $sellMachine->user->name,
                'Year' => $sellMachine->yearof,
                'Origin' => optional($sellMachine->country)->name, // Use optional to prevent errors
                'Ad Status' => $this->getStatusLabel($sellMachine->status),
                'Posted On' => $sellMachine->verified_on ? $sellMachine->verified_on->format('d-m-Y') : 'N/A',

            ];
        });
    }

    // Get the label for the status
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
