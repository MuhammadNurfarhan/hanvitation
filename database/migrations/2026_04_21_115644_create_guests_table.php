<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('unique_code')->unique(); // Untuk link unik
            $table->enum('status', ['pending', 'hadir', 'tidak_hadir', 'ragu'])->default('pending');
            $table->integer('guest_count')->default(1);
            $table->text('message')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['wedding_id', 'unique_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
