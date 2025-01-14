<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionAd extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'ad_id',
    ];

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
    public function boostad()
    {
        return $this->hasOne(BoostAd::class, 'id', 'ad_id');
    }
}
