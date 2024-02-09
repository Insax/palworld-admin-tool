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
        Schema::rename('join_and_leave', 'join_leave_log');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('join_leave_log', 'join_and_leave');
    }
};
