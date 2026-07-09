<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengguna')->insert([
            [
                'nip' => '12121213',
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@example.com',
                'kata_sandi' => Hash::make('password'),
                'jenis_kelamin' => 'L',
                'id_departemen' => 1,
                'id_jabatan' => 1,
                'role' => 'admin',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
        ]);
    }
}
