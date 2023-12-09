<?php

use App\Models\ProductBatch;
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
        Schema::create('product_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no')->unique()->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id');
            $table->unsignedBigInteger('supplier_id');
            $table->integer('quantity')->unsigned();
            $table->decimal('purchase_price', 8, 2)->unsigned();
            $table->decimal('sale_price', 8, 2)->unsigned();
            $table->date('manufacturing_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('status')->default(ProductBatch::RECEIVE_PENDING);
            $table->dateTime('receive_time')->nullable();
            $table->dateTime('purchase_time')->nullable();
            $table->timestamps();
            $table->softdeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_variation_id')->references('id')->on('product_variations')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_batches');
    }
};
