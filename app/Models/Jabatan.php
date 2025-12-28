<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';

    protected $fillable = [
        'nama_jabatan',
        'status_aktif'
    ];

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diubah_pada';

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_jabatan');
    }
}
