<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ObjectStatus;
use App\Enums\ObjectZone;
use App\Enums\ObjectType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_objects', function (Blueprint $table) {
            $table->id();
            $table->string('name_ua');
            $table->string('name_en');
            $table->text('description_ua')->nullable();
            $table->text('description_en')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('weekend_price', 10, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            $table->dateTime('discount_start_date')->nullable();
            $table->dateTime('discount_end_date')->nullable();
            $table->json('photos')->nullable();
            $table->enum('zone', ['bungalow', 'pool', 'cottages'])->default(ObjectZone::POOL->value);
            $table->enum('status', ['free', 'reserved', 'booked'])->default(ObjectStatus::FREE->value);
            $table->enum('type', ['sunbed', 'bed', 'bungalow', 'second bungalow', 'little cottage', 'big cottage'])->default(ObjectType::SUNBED->value);
            $table->string('preview_photo')->nullable();
            $table->integer('max_persons')->nullable();
            $table->boolean('is_blocked')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_objects');
    }
};
