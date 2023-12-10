<?php

use App\Models\ProductBatchLotPayment;
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
        Schema::create('product_batch_lot_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_no')->unique();
            $table->unsignedBigInteger('lot_id');
            $table->string('payment_method');
            $table->string('payment_reference');
            $table->string('payment_status')->default(ProductBatchLotPayment::PENDING);
            $table->decimal('payment_amount', 8, 2);
            $table->dateTime('payment_time')->nullable();
            $table->string('payment_note')->nullable();
            $table->timestamps();
            $table->softdeletes();

            $table->foreign('lot_id')->references('id')->on('product_batch_lots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_batch_payments');
    }
};
