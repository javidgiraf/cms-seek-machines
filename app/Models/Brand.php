<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SellMachine;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'manufacturer',
        'short_code',
        'logo_url',
        'ispopular',
        'status'
    ];
    public function sellmachine()
    {
        return $this->hasMany(SellMachine::class);
    }
}
