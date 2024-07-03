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
        Schema::table('additional_objects', function (Blueprint $table) {
            $table->dropColumn('is_available');
        });

        Schema::table('additional_objects', function (Blueprint $table) {
            $table->boolean('is_available')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('additional_objects', function (Blueprint $table) {
            $table->dropColumn('is_available');
        });

        Schema::table('additional_objects', function (Blueprint $table) {
            $table->enum('is_available', ['yes', 'no'])->default('yes');
        });
    }
};
