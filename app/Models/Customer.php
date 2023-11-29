<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Country;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company',
        'phone',
        'image_url',
        'country_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
