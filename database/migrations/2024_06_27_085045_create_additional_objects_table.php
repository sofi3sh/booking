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
        Schema::create('additional_objects', function (Blueprint $table) {
            $table->id();
            $table->string('name_ua');
            $table->string('name_en');
            $table->text('description_ua')->nullable();
            $table->text('description_en')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('weekend_price', 10, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            $table->enum('is_available', ['yes', 'no'])->default('yes');           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_objects');
    }
};
