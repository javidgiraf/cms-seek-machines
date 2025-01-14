<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sellmachine;
use Illuminate\Auth\Events\Verified;

class VerificationReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'sell_machine_id',
        'description',
        'inspection_file',
        'verified_on',
        'agent_id'
    ];
    public function setVerifiedOnAttribute($value)
    {
        $this->attributes['verified_on'] = ($value) ? date("Y-m-d", strtotime($value)) : null;
    }
    public function sellmachine()
    {
        return $this->belongsTo(Sellmachine::class);
    }
}
