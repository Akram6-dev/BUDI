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
            $table->enum('status', ['instansi', 'sekolah']);
            $table->string('instansi', 150)->nullable();
            $table->string('asal_sekolah', 150)->nullable();
            $table->enum('ulasan', ['senang', 'biasa', 'sedih'])->default('senang');
            $table->string('foto', 255);
            $table->string('tanda_tangan', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tamu');
    }
};

