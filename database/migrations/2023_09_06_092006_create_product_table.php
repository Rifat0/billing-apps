<?php

use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('description', 1000);
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('generic_id');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->string('status')->default(Product::UNAVIALABLE_PRODUCT);
            $table->timestamps();
            $table->softdeletes();

            $table->foreign('generic_id')->references('id')->on('generics')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
