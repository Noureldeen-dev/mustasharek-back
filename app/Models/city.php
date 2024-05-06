<?php

namespace App\Models;

use App\Models\DeliveryArea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class city extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function cityRel()
    {
        return $this->hasMany(DeliveryArea::class, 'city');
    }
}
