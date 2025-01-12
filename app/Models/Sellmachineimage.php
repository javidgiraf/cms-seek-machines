<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sellmachine;

class Sellmachineimage extends Model
{
    use HasFactory;

    protected $table = 'sell_machines_images';
    public $timestamps = false;

    protected $fillable = [
        'sell_machine_id',
        'image_url',
        'status'
    ];

    public function sell_machines()
    {
        return $this->belongsTo(Sellmachine::class, 'sell_machine_id', 'id');
    }
}
