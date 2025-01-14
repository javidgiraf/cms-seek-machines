<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoostadDate extends Model
{
    use HasFactory;
    protected $fillable = [
        'boost_ad_id',
        'reserved_date',
        'status',

    ];
}
