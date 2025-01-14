<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekAgent extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'designation',
        'phone',
        'image_url',
        'status',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
