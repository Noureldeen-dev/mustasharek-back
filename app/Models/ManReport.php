<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManReport extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function deliveryMan()
    {
        return $this->belongsTo('App\Models\deliveryMan', 'man_id');

    }
}
