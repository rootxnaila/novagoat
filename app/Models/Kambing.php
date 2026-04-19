<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kambing extends Model
{
    protected $table = 'kambing'; 
    protected $primaryKey = 'id_kambing';
    protected $fillable = [
        'nama',
        'jenis',
        'berat_awal',
        'status_kondisi',
        'gambar'
    ];
}
