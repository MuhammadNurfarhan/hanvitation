<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guest_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sender_name')->nullable();
            $table->text('message');
            $table->enum('attendance_status', ['hadir', 'tidak_hadir', 'ragu'])->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->index(['wedding_id', 'is_approved']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_messages');
    }
};
