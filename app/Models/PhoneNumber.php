<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    public function import(User $user)
    {
        return $user->role=="admin";
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function exchange(){
        return $this->belongsTo(Exchange::class);
    }
}
