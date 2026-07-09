<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departemen')->insert([
            [
                'nama_departemen' => 'Direksi',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_departemen' => 'Human Resource',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_departemen' => 'Keuangan',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_departemen' => 'IT',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_departemen' => 'Operasional',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_departemen' => 'Marketing',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
            [
                'nama_departemen' => 'Gudang',
                'status_aktif' => true,
                'dibuat_pada' => Carbon::now(),
                'diubah_pada' => Carbon::now(),
            ],
        ]);
    }
}
