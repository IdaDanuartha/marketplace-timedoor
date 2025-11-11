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
            $table->string('country')->default('Indonesia');
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->text('street_address');
            $table->string('postal_code');
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['province', 'city', 'district']);
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
