<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('server_whitelist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('server_id');
            $table->string('player_id');
            $table->string('steam_id');
            $table->timestamps();

            $table->foreign('server_id')->on('servers')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('server_whitelist');
    }
};
