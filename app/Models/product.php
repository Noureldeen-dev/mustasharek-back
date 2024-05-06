<?php

namespace App\Models;

use App\Models\section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sectionRel()
    {
        return $this->belongsTo(section::class, 'section');
    }


    public function colorsRel()
    {
        return $this->hasMany(color::class,  'product');
    }
}
