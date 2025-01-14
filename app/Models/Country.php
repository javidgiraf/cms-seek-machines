<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\SellMachine;

class Country extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'allow_signup',
        'status',
        'flag'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function sellmachine()
    {
        return $this->hasMany(SellMachine::class);
    }
}
