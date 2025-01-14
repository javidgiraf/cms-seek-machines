<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SellMachine;
use App\Models\User;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sell_machine_id',
        'company',
        'contact_name',
        'email',
        'phone',
        'location',
        'message',
        'status'
    ];

    public function sellmachine()
  {
      return $this->belongsTo(SellMachine::class, 'sell_machine_id', 'id');
  }
  public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

}
