<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table = 'departemen';

    protected $fillable = [
        'nama_departemen',
        'status_aktif'
    ];

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diubah_pada';

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, 'id_departemen');
    }
}
