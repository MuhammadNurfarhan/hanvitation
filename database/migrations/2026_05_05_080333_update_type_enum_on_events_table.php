<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Tambahkan 'akad' dan 'ramah_tamah' ke ENUM
        DB::statement("ALTER TABLE events MODIFY COLUMN type ENUM('misa', 'resepsi', 'akad', 'ramah_tamah') NOT NULL");
    }

    public function down(): void
    {
        // 🔄 Rollback ke kondisi semula (jika diperlukan)
        DB::statement("ALTER TABLE events MODIFY COLUMN type ENUM('misa', 'resepsi') NOT NULL");
    }
};
