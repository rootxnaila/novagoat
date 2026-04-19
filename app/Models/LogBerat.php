<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogBerat extends Model
{
    protected $table = 'log_berat';

    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_kambing',
        'berat_sekarang',
        'tanggal_timbang'
    ];
}
