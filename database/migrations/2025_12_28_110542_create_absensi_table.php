<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_jam_kerja')->nullable();

            $table->date('tanggal');

            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_pulang')->nullable();

            $table->enum('status', ['hadir', 'terlambat'])->default('hadir');

            $table->string('bukti_foto', 255);
            $table->text('catatan')->nullable();

            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diubah_pada')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_pengguna')
                ->references('id')->on('pengguna')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_jam_kerja')
                ->references('id')->on('jam_kerja')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->unique(['id_pengguna', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
