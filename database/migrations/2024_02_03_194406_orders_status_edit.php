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
            $table->enum('status', ['new','processed','delivered','cancelled','returned','rejected','in-transit','processing','out-for-delivery','refund-initializing','refund-initialized','refunded'])->change();
            if(!Schema::hasColumn('orders','platform_fee')){
                $table->float('platform_fee')->default(00.00)->after('total_discount');
            }

            if(!Schema::hasColumn('orders','cgst_percent')){
                $table->float('cgst_percent')->default(00.00)->after('total_discount');
            }

            if(!Schema::hasColumn('orders','sgst_percent')){
                $table->float('sgst_percent')->default(00.00)->after('total_discount');
            }

            if(!Schema::hasColumn('orders','igst_percent')){
                $table->float('igst_percent')->default(00.00)->after('total_discount');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if(!Schema::hasColumn('products','net_price')){
                $table->float('net_price')->default(00.00)->after('price');
            }

            if(!Schema::hasColumn('products','cgst_percent')){
                $table->float('cgst_percent')->default(00.00)->after('price');
            }

            if(!Schema::hasColumn('products','sgst_percent')){
                $table->float('sgst_percent')->default(00.00)->after('price');
            }

            if(!Schema::hasColumn('products','igst_percent')){
                $table->float('igst_percent')->default(00.00)->after('price');
            }

            if(!Schema::hasColumn('products','final_price')){
                $table->float('final_price')->default(00.00)->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['new','processed','delivered','cancelled','returned','rejected'])->change();
            if(Schema::hasColumn('orders','platform_fee')){
                $table->dropColumn('platform_fee');
            }

            if(Schema::hasColumn('orders','cgst_percent')){
                $table->dropColumn('cgst_percent');
            }

            if(Schema::hasColumn('orders','sgst_percent')){
                $table->dropColumn('sgst_percent');
            }

            if(Schema::hasColumn('orders','igst_percent')){
                $table->dropColumn('igst_percent');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if(Schema::hasColumn('products','net_price')){
                $table->dropColumn('net_price');
            }

            if(Schema::hasColumn('products','cgst_percent')){
                $table->dropColumn('cgst_percent');
            }

            if(Schema::hasColumn('products','sgst_percent')){
                $table->dropColumn('sgst_percent');
            }

            if(Schema::hasColumn('products','igst_percent')){
                $table->dropColumn('igst_percent');
            }

            if(Schema::hasColumn('products','final_price')){
                $table->dropColumn('final_price');
            }
        });
    }
};
