<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'payment_method',
        'total_amount',
        'currency',
        'paid_on',
        'reference_id',
        'payment_status', // pending, cancelled, failed, complete
        'note',
        'status'
    ];
}
