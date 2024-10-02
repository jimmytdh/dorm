<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $fillable = [
        'id',
        'username',
        'password',
        'fname',
        'lname',
        'section_id',
        'division_id',
        'avatar',
        'email',
        'role',
    ];

    public function isAdmin(){
        return $this->role === 'admin';
    }

    public function payment(){
        return $this->hasMany(Payment::class);
    }

}
