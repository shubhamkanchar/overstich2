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
        Schema::table('orders', function (Blueprint $table) {
            if(!Schema::hasColumn('orders','coupon_discount')){
                $table->float('coupon_discount')->after('total_discount')->nullable();
            }
            if(!Schema::hasColumn('orders','coupon_id')){
                $table->unsignedBigInteger('coupon_id')->after('total_discount')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if(Schema::hasColumn('orders','coupon_discount')){
                $table->dropColumn('coupon_discount');
            }
            if(Schema::hasColumn('orders','coupon_id')){
                $table->dropColumn('coupon_id');
            }
        });
    }
};
