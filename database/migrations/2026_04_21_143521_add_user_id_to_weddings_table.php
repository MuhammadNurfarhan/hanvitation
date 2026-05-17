<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            // Tambahkan kolom user_id setelah id
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete()
                  ->after('id');

            // Tambahkan index untuk performa query
            $table->index(['user_id', 'is_published']);
        });
    }

    public function down(): void
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id', 'is_published']);
            $table->dropColumn('user_id');
        });
    }
};
