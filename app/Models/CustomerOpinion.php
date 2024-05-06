<?php

namespace App\Models;

use App\Models\User;
use App\Models\product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerOpinion extends Model
{
    use HasFactory;

    public function userRel()
    {
        return $this->belongsTo(User::class, 'user');
    }


    public function productRel()
    {
        return $this->belongsTo(product::class, 'product');
    }
}
