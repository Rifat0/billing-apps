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
        Schema::create('product_batch_lots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id');
            $table->string('lot_no');
            $table->timestamps();
            $table->softdeletes();

            $table->foreign('batch_id')->references('id')->on('product_batches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_batch_lots');
    }
};
