<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_cuti', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('nama_cuti', 80)->unique();
            $table->unsignedSmallInteger('batas_hari')->default(0);
            $table->boolean('wajib_lampiran')->default(false);
            $table->boolean('status_aktif')->default(true);

            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diubah_pada')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_cuti');
    }
};
