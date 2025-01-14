<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellMachineAgent extends Model
{
    use HasFactory;
    protected $fillable = [
        'sell_machine_id',
        'sales_percent',
        'agent_id',
        'status'
    ];
}
