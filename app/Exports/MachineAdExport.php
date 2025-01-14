<?php

namespace App\Exports;

use App\Models\Sellmachine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class MachineAdExport implements FromCollection, WithHeadings, WithMapping, WithDrawings
{
  protected $sellMachines;

  public function __construct($sellMachines)
  {
    $this->sellMachines = $sellMachines;
  }

  public function collection()
  {
    return $this->sellMachines;
  }

  public function headings(): array
  {
    return [
      'Image',
      'Title',
      'Item Code',
      'Model No',
      'Company',
      'Customer',
      'Verified Status',
      'Posted On',
    ];
  }

  public function map($sellMachine): array
  {
    return [
      '',
      $sellMachine->title,
     !empty($sellMachine->item_code) ? $sellMachine->item_code : '', 
      !empty($sellMachine->modelno) ? $sellMachine->modelno : '',  
      optional($sellMachine->user->customer)->company,
      $sellMachine->user->name,
      $sellMachine->isverified === 1 ? 'Verified' : 'Unverified',
      $sellMachine->created_at->format('d-m-Y'),
    ];
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
