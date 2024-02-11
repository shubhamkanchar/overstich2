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
        Schema::table('products', function (Blueprint $table) {
            if(!Schema::hasColumn('products','striked_price')){
                $table->float('striked_price')->after('price')->nullable();
            }
            if(!Schema::hasColumn('products','sgst_amount')){
                $table->float('sgst_amount')->after('price')->nullable();
            }
            if(!Schema::hasColumn('products','cgst_amount')){
                $table->float('cgst_amount')->after('price')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if(Schema::hasColumn('products','striked_price')){
                $table->dropColumn('striked_price');
            }
            if(Schema::hasColumn('products','sgst_amount')){
                $table->dropColumn('sgst_amount');
            }
            if(Schema::hasColumn('products','cgst_amount')){
                $table->dropColumn('cgst_amount');
            }
        });
    }
};
