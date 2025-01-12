<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SellMachine;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_code',
        'parent_id',
        'icon_url',
        'meta_title',
        'keywords',
        'meta_descriptions',
        'status'
    ];
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function childs()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->with('childs')->orderBy('id', 'DESC');
    }

    public function sellmachine()
    {
        return $this->hasMany(SellMachine::class);
    }
}
