<?php

namespace App\Exports;

use App\Models\Sellmachine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MachineListExport implements FromCollection, WithHeadings, WithDrawings
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
      'Image',
      'Title',
      'Item Code',
      'Model No',
      'Company/Customer',
      'Status',
      'Posted On',
    ];
  }

  public function transformSellMachines()
  {
    return $this->sellMachines->map(function ($sellMachine) {
      return [
        '',
        $sellMachine->title,
        $sellMachine->item_code,
        $sellMachine->modelno,
        optional($sellMachine->user->customer)->company . ' / ' . $sellMachine->user->name,
         'Status' => $this->getStatusLabel($sellMachine->status),
        'Posted On' => $sellMachine->created_at->format('d-m-Y'),
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

public function drawings()
{
    $drawings = [];

    foreach ($this->sellMachines as $key => $sellMachine) {
        // Initialize an empty path for the drawing
        $imagePath = null;

        if ($sellMachine->default_image) {
            // Construct the full image path
            $imagePath = config('app.image_root_url') . $sellMachine->default_image;

            // Check if the image file exists
            if (@getimagesize($imagePath)) {
                $drawing = new Drawing();
                $drawing->setName($sellMachine->title);
                $drawing->setDescription($sellMachine->title);
                $drawing->setPath($imagePath);
                $drawing->setHeight(75);
                $drawing->setWidth(75);
                $drawing->setCoordinates('A' . ($key + 2));
                $drawing->setResizeProportional(false);
                $drawings[] = $drawing;
            }
        }

        // Log missing image case for debugging (optional)
        if (empty($imagePath)) {
            \Log::warning("Image not found for: " . $sellMachine->title);
        }
    }

    return $drawings;
}



  public function registerEvents(): array
  {
    return [
      AfterSheet::class => function(AfterSheet $event) {
        $sheet = $event->sheet;
        $sheet->getColumnDimension('A')->setWidth(75);
        foreach ($this->sellMachines as $key => $sellMachine) {
          $sheet->getRowDimension($key + 2)->setRowHeight(75);
        }
      },
    ];
  }
}
