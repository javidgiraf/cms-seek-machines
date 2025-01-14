<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscribeVisit extends Model
{
  use HasFactory;

  protected $fillable = [
      'subscription_id ',
      'sell_machine_id',
      'visited_at',
      'visited_ip',
  ];
  public function subscription()
   {
       return $this->belongsTo(Subscription::class);
   }

   public function sellMachine()
      {
          return $this->belongsTo(Sellmachine::class, 'sell_machine_id');
      }
}
