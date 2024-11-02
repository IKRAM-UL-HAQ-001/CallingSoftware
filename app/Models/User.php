<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    public function phone(){
        return $this->hasMany(PhoneNumber::class);
    }
    public function exchange(){
        return $this->belongsTo(Exchange::class);
    }
}
