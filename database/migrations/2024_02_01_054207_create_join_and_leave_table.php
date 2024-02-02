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
        Schema::create('join_and_leave', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id');
            $table->enum('action', ['JOIN', 'LEFT', 'KICKWL', 'KICKUSR', 'BANUSR']);
            $table->timestamps();

            $table->foreign('player_id')->on('players')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('join_and_leave');
    }
};
