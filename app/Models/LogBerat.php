<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogBerat extends Model
{
<<<<<<< HEAD
    protected $table = 'log_berat';

    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_kambing',
        'berat_sekarang',
        'tanggal_timbang'
    ];
}
=======
    protected $table = 'log_berat'; // Kasih tahu nama tabelnya
    protected $fillable = ['tanggal_timbang', 'berat_sekarang']; // Kolom yang boleh diisi
}
>>>>>>> 88ff55d (Selesaiin fitur medis dan perbaiki route)
