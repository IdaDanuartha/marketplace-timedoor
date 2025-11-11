<?php

use App\Enum\OrderStatus;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->bigInteger('total_price');
            $table->integer('shipping_cost');
            $table->string('status')->default(OrderStatus::PENDING);
            $table->timestamps();

            $table->index(['code', 'customer_id', 'status', 'total_price', 'shipping_cost']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
