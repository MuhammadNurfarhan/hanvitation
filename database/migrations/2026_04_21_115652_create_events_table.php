<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['misa', 'resepsi']);
            $table->string('venue_name');
            $table->text('address');
            $table->string('maps_link')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
