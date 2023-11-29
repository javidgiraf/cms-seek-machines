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
        'status'
    ];

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }
}
