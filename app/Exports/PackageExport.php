<?php

namespace App\Exports;

use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PackageExport implements FromCollection, WithHeadings
{
    protected $subscriptions;

    public function __construct($subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }

    public function collection()
    {
        return $this->transformSubscriptions();
    }

    public function headings(): array
    {
        return [
           
            'Membership Plan',
            'User',
            'Amount(USD)',
            'Status',
            'Start Date',
            'End Date',
        ];
    }

    protected function transformSubscriptions()
  {
      return $this->subscriptions->map(function ($subscription) {
          return [
             
              'Plan ' => $subscription->membership->title,
              'User' => optional($subscription->user)->name ?? 'N/A',
              'Amount' => $subscription->total_amount ?? 'N/A',
              'Status' => $this->getStatusLabel($subscription->status),
              'Start Date' => \Carbon\Carbon::parse($subscription->start_at)->format('d-m-Y'),
              'End Date' => \Carbon\Carbon::parse($subscription->expires_at)->format('d-m-Y'),
          ];
      });
  }


    protected function getStatusLabel($status)
    {
        switch ($status) {
            case 1:
                return 'Active';
            case 0:
                return 'Inactive';
            default:
                return 'Unknown';
        }
    }
}
