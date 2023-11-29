<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BoostAd;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'boost_ad_id',
        'title',
        'description',
        'label',
        'image_url',
        'link_to',
        'status'
    ];
    public function boostad()
    {
        return $this->belongsTo(BoostAd::class, 'boost_ad_id', 'id');
    }
}
