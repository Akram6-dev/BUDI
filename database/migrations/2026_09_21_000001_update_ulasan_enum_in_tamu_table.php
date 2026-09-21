<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tamu', function (Blueprint $table) {
            $table->string('ulasan', 50)->default('senang')->change();
        });

        // Update existing records in tamu table now that check constraint is lifted
        DB::table('tamu')->where('ulasan', 'biasa')->update(['ulasan' => 'menarik']);
        DB::table('tamu')->where('ulasan', 'sedih')->update(['ulasan' => 'unik']);
    }

    public function down(): void
    {
        DB::table('tamu')->where('ulasan', 'menarik')->update(['ulasan' => 'biasa']);
        DB::table('tamu')->where('ulasan', 'unik')->update(['ulasan' => 'sedih']);

        Schema::table('tamu', function (Blueprint $table) {
            $table->string('ulasan', 50)->default('senang')->change();
        });
    }
};
