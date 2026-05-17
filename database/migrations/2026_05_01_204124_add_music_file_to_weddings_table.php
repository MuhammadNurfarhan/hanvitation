<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->string('music_file')->nullable()->after('music_url');
        });
    }

    public function down()
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn('music_file');
        });
    }
};
