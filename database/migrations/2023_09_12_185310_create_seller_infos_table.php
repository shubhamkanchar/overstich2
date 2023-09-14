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
        Schema::create('seller_infos', function (Blueprint $table) {
            $table->id();
            $table->string('seller_id');
            $table->string('gst');
            $table->string('whatsapp');
            $table->string('category');
            $table->string('products');
            $table->string('price_range');
            $table->string('address');
            $table->string('locality');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('account');
            $table->integer('is_approved');
            $table->string('ifsc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_infos');
    }
};
