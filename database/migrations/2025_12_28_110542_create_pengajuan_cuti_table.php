<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_cuti', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_jenis_cuti');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->unsignedSmallInteger('jumlah_hari');

            $table->text('alasan');
            $table->string('lampiran_file', 255);

            $table->enum('status_pengajuan', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');

            $table->unsignedBigInteger('disetujui_oleh')->nullable();
            $table->dateTime('disetujui_pada')->nullable();
            $table->text('catatan_admin')->nullable();

            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diubah_pada')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_pengguna')
                ->references('id')->on('pengguna')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_jenis_cuti')
                ->references('id')->on('jenis_cuti')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('disetujui_oleh')
                ->references('id')->on('pengguna')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_cuti');
    }
};
