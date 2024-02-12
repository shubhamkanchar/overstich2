<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'taxable_amount')) {
                $table->decimal('taxable_amount', 10, 2)->after('product_id')->nullable();
            }
            if (!Schema::hasColumn('order_items', 'striked_price')) {
                $table->decimal('striked_price', 10, 2)->after('product_id')->nullable();
            }
            if (!Schema::hasColumn('order_items', 'cgst_percent')) {
                $table->decimal('cgst_percent', 5, 2)->after('taxable_amount')->nullable();
            }
            if (!Schema::hasColumn('order_items', 'sgst_percent')) {
                $table->decimal('sgst_percent', 5, 2)->after('cgst_percent')->nullable();
            }
            if (!Schema::hasColumn('order_items', 'cgst_amount')) {
                $table->decimal('cgst_amount', 10, 2)->after('sgst_percent')->nullable();
            }
            if (!Schema::hasColumn('order_items', 'sgst_amount')) {
                $table->decimal('sgst_amount', 10, 2)->after('cgst_amount')->nullable();
            }
            if(!Schema::hasColumn('order_items','hsn')){
                $table->string('hsn')->after('cgst_amount');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'total_taxable_amount')) {
                $table->decimal('total_taxable_amount', 10, 2)->after('total_discount')->nullable();
            }
            if (!Schema::hasColumn('orders', 'total_striked_price')) {
                $table->decimal('total_striked_price', 10, 2)->after('total_taxable_amount')->nullable();
            }
            if (!Schema::hasColumn('orders', 'total_cgst_amount')) {
                $table->decimal('total_cgst_amount', 10, 2)->after('total_striked_price')->nullable();
            }
            if (!Schema::hasColumn('orders', 'total_sgst_amount')) {
                $table->decimal('total_sgst_amount', 10, 2)->after('total_cgst_amount')->nullable();
            }
        });

        if (Schema::hasTable('shoppingcart')) {
            DB::table('shoppingcart')->truncate();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'taxable_amount')) {
                $table->dropColumn('taxable_amount');
            }
            if (Schema::hasColumn('order_items', 'striked_price')) {
                $table->dropColumn('striked_price');
            }
            if (!Schema::hasColumn('order_items', 'cgst_percent')) {
                $table->dropColumn('cgst_percent');
            }
            if (!Schema::hasColumn('order_items', 'sgst_percent')) {
                $table->dropColumn('sgst_percent');
            }
            if (!Schema::hasColumn('order_items', 'cgst_amount')) {
                $table->dropColumn('cgst_amount');
            }
            if (!Schema::hasColumn('order_items', 'sgst_amount')) {
                $table->dropColumn('sgst_amount');
            }
            if(Schema::hasColumn('order_items','hsn')){
                $table->dropColumn('hsn');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'total_taxable_amount')) {
                $table->dropColumn('total_taxable_amount');
            }
            if (Schema::hasColumn('orders', 'total_striked_price')) {
                $table->dropColumn('total_striked_price');
            }
            if (Schema::hasColumn('orders', 'total_cgst_amount')) {
                $table->dropColumn('total_cgst_amount');
            }
            if (Schema::hasColumn('orders', 'total_sgst_amount')) {
                $table->dropColumn('total_sgst_amount');
            }
        });
    }
};
