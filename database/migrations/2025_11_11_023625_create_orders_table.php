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
            $table->foreignId('address_id')->constrained()->onDelete('cascade');
            $table->bigInteger('total_price');
            $table->integer('shipping_cost')->default(0);
            $table->bigInteger('grand_total');
            $table->string('status')->default(OrderStatus::PENDING); // pending, paid, failed, shipped, completed
            $table->string('payment_method')->nullable(); // e.g. 'gopay', 'bank_transfer'
            $table->string('payment_status')->default('unpaid');
            $table->string('midtrans_transaction_id')->nullable();
            $table->timestamps();

            $table->index(['code', 'status', 'total_price', 'shipping_cost', 'grand_total']);
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
