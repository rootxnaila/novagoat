<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalMedis extends Model
{
    protected $table = 'jadwal_medis'; 
    protected $primaryKey = 'id_jadwal'; 
    public $timestamps = false; 
}
