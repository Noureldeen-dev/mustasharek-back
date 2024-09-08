<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation  extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function consultationcat()
    {
        return $this->belongsTo(ConsultationsCategories::class, 'consultations_id', 'id');
    }
    public function replies()
{
    return $this->hasMany(replies_consultations::class);
}

}