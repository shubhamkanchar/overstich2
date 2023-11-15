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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('seller_id')->unsigned();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->string('color')->nullable();
            $table->string('size')->default('M')->nullable();            
            $table->text('description')->nullable();
            $table->float('price');
            $table->float('discount')->nullabale();
            $table->integer('stock')->default(1);
            $table->enum('condition',['default','new','hot'])->default('default');
            $table->enum('status',['active','inactive'])->default('active');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('child_category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('SET NULL');
            $table->foreign('child_category_id')->references('id')->on('categories')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
