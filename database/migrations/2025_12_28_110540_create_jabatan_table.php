<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_jabatan', 100)->unique();
            $table->boolean('status_aktif')->default(true);

            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamp('diubah_pada')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan');
    }
};
