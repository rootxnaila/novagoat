<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; 

class User extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
    //relasi itung kinerja employee
    public function logBerat()
    {
        return $this->hasMany(LogBerat::class, 'id_user', 'id_user');
    }

    public function jadwalMedis()
    {
        return $this->hasMany(JadwalMedis::class, 'id_user', 'id_user');
    }
}