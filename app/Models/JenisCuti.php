<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisCuti extends Model
{
    protected $table = 'jenis_cuti';
    protected $primaryKey = 'id';

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diubah_pada';

    protected $fillable = [
        'nama_cuti',
        'batas_hari',
        'wajib_lampiran',
        'status_aktif',
    ];

    protected $casts = [
        'batas_hari' => 'integer',
        'wajib_lampiran' => 'boolean',
        'status_aktif' => 'boolean',
    ];
}
