<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'email',
        'kata_sandi',
        'role',
        'status_aktif',
        'id_departemen',
        'id_jabatan',
        'jenis_kelamin',
    ];

    protected $hidden = [
        'kata_sandi',
    ];

    const CREATED_AT = 'dibuat_pada';
    const UPDATED_AT = 'diubah_pada';

    public function getAuthPassword()
    {
        return $this->kata_sandi;
    }

    public function jabatan()
    {
        return $this->belongsTo(\App\Models\Jabatan::class, 'id_jabatan');
    }

    public function departemen()
    {
        return $this->belongsTo(\App\Models\Departemen::class, 'id_departemen');
    }
}
