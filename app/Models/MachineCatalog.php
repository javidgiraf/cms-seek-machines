<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sellmachine;

class MachineCatalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sell_machine_id',
        'file_path',
        'file_type',
        'status'
    ];

    public function sell_machines()
    {
        return $this->belongsTo(Sellmachine::class, 'sell_machine_id', 'id');
    }
}
