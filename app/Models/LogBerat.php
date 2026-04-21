<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogBerat extends Model
{
    /**
     * Nama tabel di database
     */
    protected $table = 'log_berat';

    /**
     * Primary key dari tabel
     */
    protected $primaryKey = 'id_log';

    /**
     * Kolom yang boleh diisi secara massal
     */
    protected $fillable = [
        'id_kambing',
        'berat_sekarang',
        'tanggal_timbang'
    ];

    /**
     * Relasi ke model Kambing
     * Satu log berat milik satu kambing
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kambing()
    {
        return $this->belongsTo(Kambing::class, 'id_kambing');
    }
}
