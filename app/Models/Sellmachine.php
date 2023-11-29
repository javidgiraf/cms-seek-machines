<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;

class Sellmachine extends Model
{
    protected $table = 'sell_machines';
    use HasFactory;
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
        'yearof',
        'modelno',
        'usage',
        'location',
        // 'price_visible',
        // 'price',
        // 'currency',
        'status'
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
}
