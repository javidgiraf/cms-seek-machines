<?php
namespace App\Exports;

use App\Models\BoostAdPackage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BoostAdPackageExport implements FromCollection, WithHeadings
{
    protected $packages;

    public function __construct(iterable $packages)
    {
        $this->packages = $packages;
    }

    public function collection()
    {
        return $this->transformPackages();
    }

    public function headings(): array
    {
        return [
            'Machine',
            'Package',
            'Start Date',
            'End Date',
            'Amount(USD)',
        ];
    }

    protected function transformpackages()
  {

      return $this->packages->map(function ($boostAd) {
          return [
              'Machine' => $boostAd->sellmachine->title,
              'Package Title' => $boostAd->package->title,
              'Start Date' => $boostAd->start_date,
              'End Date' => $boostAd->end_date,
              'Amount' => $boostAd->total_amount,
          ];
      });
  }



}
