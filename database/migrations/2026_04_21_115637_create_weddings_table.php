<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weddings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title')->default('The Wedding Of');

            // Groom Info
            $table->string('groom_name');
            $table->string('groom_first_name');
            $table->string('groom_father_name');
            $table->string('groom_mother_name');
            $table->string('groom_photo')->nullable();
            $table->string('groom_instagram')->nullable();
            $table->string('groom_instagram_handle')->nullable();

            // Bride Info
            $table->string('bride_name');
            $table->string('bride_first_name');
            $table->string('bride_father_name');
            $table->string('bride_mother_name');
            $table->string('bride_photo')->nullable();
            $table->string('bride_instagram')->nullable();
            $table->string('bride_instagram_handle')->nullable();

            // Event Details
            $table->dateTime('event_date');
            $table->text('quote')->nullable();
            $table->string('quote_source')->nullable();
            $table->text('greeting_message')->nullable();

            // Media
            $table->string('cover_image')->nullable();
            $table->string('music_url')->nullable();
            $table->string('qr_code')->nullable();

            // Status
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weddings');
    }
};
