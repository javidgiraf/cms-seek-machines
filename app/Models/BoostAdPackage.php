<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoostAdPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'pricing',
        'no_of_days',
        'discount',
        'status',
    ];
    public function boostAds()
   {
       return $this->hasMany(BoostAd::class, 'package_id');
   }
}
