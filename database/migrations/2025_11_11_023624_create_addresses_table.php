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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->text('full_address');
            $table->text('additional_information')->nullable();
            $table->string('postal_code');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('label')->default('Home'); // e.g., Home, Work, Office, etc.
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['postal_code', 'latitude', 'longitude', 'label']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
