<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'pricing',
        'no_of_month',
        'discount',
        'view_limit',
        'is_premium',
        'min_premium_amount',
        'max_premium_amount',
        'status'
    ];

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
