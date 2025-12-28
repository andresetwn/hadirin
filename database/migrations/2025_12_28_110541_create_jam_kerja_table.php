<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jam_kerja', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nama_shift', 60);
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->unsignedSmallInteger('toleransi_menit')->default(0);
            $table->boolean('status_aktif')->default(true);

            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diubah_pada')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jam_kerja');
    }
};
