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
        Schema::create('rcon_data', function (Blueprint $table) {
            $table->id();
            $table->string('host');
            $table->integer('port', false, true);
            $table->string('password')->nullable();
            $table->integer('timeout')->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rcon_data');
    }
};
