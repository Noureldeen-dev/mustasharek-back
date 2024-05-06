<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function userRel()
    {
        return $this->belongsTo('App\Models\user', 'user');
    }
    public function productRel()
    {
        return $this->belongsTo('App\Models\product', 'product');
    }
    public function manRel()
    {
        return $this->belongsTo('App\Models\deliveryMan', 'delivery');
    }

    public function products()
    {
        return $this->belongsToMany(product::class)->withPivot(['quantity','price','total',])->as('orderd');
    }



}
