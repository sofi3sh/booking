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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('object_id');
            $table->dateTime('reserved_from');
            $table->dateTime('reserved_to');
            $table->dateTime('booked_from')->nullable();
            $table->dateTime('booked_to')->nullable();
            $table->boolean('payment_status');
            $table->boolean('canceled')->default(0);
            $table->string('order_id')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
