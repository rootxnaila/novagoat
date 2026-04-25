<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kambing; 

class JadwalMedis extends Model
{
    protected $table = 'jadwal_medis'; 
    protected $primaryKey = 'id_jadwal'; 
    public $timestamps = false; 

    protected $fillable = [
        'id_kambing', 
        'jenis_tindakan', 
        'tanggal_rencana', 
        'status'
    ];

    public function kambing()
    {
        return $this->belongsTo(Kambing::class, 'id_kambing', 'id_kambing'); 
    }
}