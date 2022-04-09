<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateurs extends Authenticatable 
{
    use HasFactory, SoftDeletes;  

    protected $fillable = ['name', 'email', 'password', 'role'];

    public function isAdmin () {
        return $this->role === 'ROLE_ADMIN';
    }

    public function isUser () {
        return $this->role === 'ROLE_USER';
    }


}
