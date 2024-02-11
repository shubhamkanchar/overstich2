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
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'taxable_amount')) {
                $table->decimal('taxable_amount', 10, 2)->after('product_id')->nullable();
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
        });

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'total_taxable_amount')) {
                $table->decimal('total_taxable_amount', 10, 2)->after('user_id')->nullable();
            }
            if (!Schema::hasColumn('orders', 'total_cgst_amount')) {
                $table->decimal('total_cgst_amount', 10, 2)->after('total_taxable_amount')->nullable();
            }
            if (!Schema::hasColumn('orders', 'total_sgst_amount')) {
                $table->decimal('total_sgst_amount', 10, 2)->after('total_cgst_amount')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            if (Schema::hasColumn('order_items', 'taxable_amount')) {
                $table->decimal('taxable_amount', 10, 2)->after('product_id')->nullable();
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
        });

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'total_taxable_amount')) {
                $table->dropColumn('total_taxable_amount');
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
