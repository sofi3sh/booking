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
        Schema::create('object_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_object_id')->constrained()->onDelete('cascade');
            $table->string('title_ua');
            $table->string('title_en');
            $table->text('description_ua');
            $table->text('description_en');
            $table->string('img')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('object_details');
    }
};
