<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Banner;
use App\Models\Sellmachine;

class BoostAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'sell_machine_id',
        'days',
        'start_date',
        'end_date',
        'total_amount',
        'ad_type',
        'status'
    ];

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = ($value) ? date("Y-m-d", strtotime($value)) : null;
    }
    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = ($value) ? date("Y-m-d", strtotime($value)) : null;
    }
    public function setTotalAmountAttribute($value)
    {
        $b = str_replace(',', '', $value);
        return $this->attributes['total_amount'] = ($value) ? (float)$b : 0;
    }
    public function banner()
    {
        return $this->hasOne(Banner::class);
    }
    public function sellmachine()
  {
      return $this->belongsTo(Sellmachine::class, 'sell_machine_id'); 
  }

    public function package()
  {
      return $this->belongsTo(BoostAdPackage::class, 'package_id');
  }
    public function boostedDate()
  {
      return $this->hasMany(BoostadDate::class, 'boost_ad_id');
  }
}
