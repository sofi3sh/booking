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
        Schema::table('booking_objects', function (Blueprint $table) {
            $table->decimal('childrens_price', 10, 2)->default(0);
            $table->decimal('childrens_weekend_price', 10, 2)->default(0);    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_objects', function (Blueprint $table) {
            //
        });
    }
};
