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
        Schema::create('order_platform_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch');
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->enum('payment_method',['cod','phone_pe'])->default('cod');
            $table->tinyInteger('is_order_confirmed')->default(0);
            $table->float('amount')->nullable();
            $table->float('taxable_amount')->nullable();
            $table->float('gst_percent')->nullable();
            $table->float('gst_amount')->nullable();
            $table->string('invoice_number')->nullable();
            $table->timestamp('invoice_generated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_platform_fees');
    }
};
