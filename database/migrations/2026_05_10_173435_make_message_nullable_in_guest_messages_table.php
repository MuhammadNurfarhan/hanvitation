<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guest_messages', function (Blueprint $table) {
            // ✅ Ubah kolom message agar bisa NULL
            $table->text('message')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('guest_messages', function (Blueprint $table) {
            // Revert ke NOT NULL jika diperlukan
            $table->text('message')->nullable(false)->change();
        });
    }
};
