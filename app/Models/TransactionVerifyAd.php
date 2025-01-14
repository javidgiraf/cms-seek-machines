<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionVerifyAd extends Model
{
    use HasFactory;
    protected $table = 'transaction_verifyads';
    protected $fillable = [
        'transaction_id',
        'sell_machine_id',
    ];

    public function sell_machine()
    {
        return $this->hasOne(Sellmachine::class, 'id', 'sell_machine_id');
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
}
