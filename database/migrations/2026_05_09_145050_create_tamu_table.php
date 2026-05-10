<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tamu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 100);
            $table->enum('status', ['guru', 'siswa']);
            $table->string('kelas', 50)->nullable();
            $table->string('foto', 255);
            $table->string('tanda_tangan', 255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tamu');
    }
};
