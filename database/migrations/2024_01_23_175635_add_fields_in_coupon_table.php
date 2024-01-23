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
        Schema::table('coupons', function (Blueprint $table) {
            if(!Schema::hasColumn('coupons','seller_id')){
                $table->unsignedBigInteger('seller_id')->after('id');
            }
            if(!Schema::hasColumn('coupons','minimum')){
                $table->unsignedInteger('minimum')->default(0)->after('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if(Schema::hasColumn('coupons','seller_id')){
                $table->dropColumn('seller_id');
            }
            if(Schema::hasColumn('coupons','minimum')){
                $table->dropColumn('minimum');
            }
        });
    }
};
