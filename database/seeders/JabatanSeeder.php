<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jabatan')->insert([
            [
                'nama_jabatan' => 'Direktur',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_jabatan' => 'Manager',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_jabatan' => 'Supervisor',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_jabatan' => 'Staff',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_jabatan' => 'Admin',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_jabatan' => 'Operator',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_jabatan' => 'Teknisi',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
        ]);
    }
}
