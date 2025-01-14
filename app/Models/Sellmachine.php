<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\MachineCatalog;
use App\Models\Sellmachineimage;
use App\Models\BoostAd;

class Sellmachine extends Model
{
    protected $table = 'sell_machines';

    use HasFactory;
    protected $casts = [
           'created_at' => 'datetime',
           

       ];
    protected $fillable = [
        'title',
        'slug',
        'description',
        'item_code',
        'user_id',
        'category_id',
        'default_image',
        'brand_id',
        'country_id',
        'is_capital',
        'expected_price',
        'yearof',
        'modelno',
        'usage',
        'location',
        'meta_title',
        'keywords',
        'meta_descriptions',
        'isverified',
        'verify_submitted_on',
        'status',
        'serialno',
        'available_country'
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function report()
    {
        return $this->hasOne(VerificationReason::class, 'sell_machine_id', 'id');
    }
    public function machine_catalog()
    {
        return $this->hasOne(MachineCatalog::class, 'sell_machine_id', 'id');
    }
    public function sell_machines_image()
    {
        return $this->hasMany(Sellmachineimage::class, 'sell_machine_id', 'id');
    }
    public function boostad()
    {
        return $this->hasMany(BoostAd::class, 'sell_machine_id', 'id');
    }
    public function subscribeVisits()
   {
       return $this->hasMany(SubscribeVisit::class, 'sell_machine_id');
   }
   public function avail_country()
   {
       return $this->belongsTo(Country::class, 'available_country', 'id');
   }
}
