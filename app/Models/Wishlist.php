<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SellMachine;
// use App\Models\User;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sell_machine_id',
        'status'
    ];

    public function sellmachines()
    {
        return $this->belongsTo(SellMachine::class);
    }
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
