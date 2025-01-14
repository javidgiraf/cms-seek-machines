<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSubscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'subscription_id',
    ];

    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'id', 'subscription_id');
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
}
