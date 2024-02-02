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
        Schema::table('servers', function (Blueprint $table) {
            $table->dropColumn('storage');
            $table->boolean('shutting_down')->default(false);
            $table->boolean('uses_whitelist')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->string('storage');
            $table->dropColumn('shutting_down');
            $table->dropColumn('uses_whitelist');
        });
    }
};
