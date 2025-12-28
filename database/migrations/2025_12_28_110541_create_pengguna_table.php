<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nip', 30)->unique();
            $table->string('nama_lengkap', 120);
            $table->string('email', 120)->nullable()->unique();
            $table->string('kata_sandi', 255);

            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();

            $table->unsignedBigInteger('id_departemen');
            $table->unsignedBigInteger('id_jabatan');

            $table->enum('role', ['admin', 'karyawan'])->default('karyawan');
            $table->boolean('status_aktif')->default(true);

            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diubah_pada')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_departemen')
                ->references('id')->on('departemen')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('id_jabatan')
                ->references('id')->on('jabatan')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
