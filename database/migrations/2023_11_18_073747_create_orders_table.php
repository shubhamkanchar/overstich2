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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('batch');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->float('sub_total');
            $table->float('total_discount');
            $table->float('delivery_charge');
            $table->float('total_amount');
            $table->enum('payment_method',['cod','phone_pe'])->default('cod');
            $table->string('payment_transaction_id')->nullable();
            $table->tinyInteger('is_order_confirmed')->default(0);
            $table->enum('status',['new','process','delivered','cancel'])->default('new');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('pincode');
            $table->text('address');
            $table->text('locality')->nullable();
            $table->timestamps();
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
