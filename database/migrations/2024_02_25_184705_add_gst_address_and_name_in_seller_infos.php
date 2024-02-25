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
        Schema::table('seller_infos', function (Blueprint $table) {
            if(!Schema::hasColumn('seller_infos','gst_name')){
                $table->string('gst_name')->nullable()->after('gst');
            }

            if(!Schema::hasColumn('seller_infos','gst_address')){
                $table->string('gst_address')->nullable()->after('gst_name');
            }

            if(Schema::hasColumn('seller_infos','noc_doc')){
                $table->string('noc_doc')->nullable()->change();
            }

            if(Schema::hasColumn('seller_infos','category')){
                $table->string('category')->nullable()->change();
            }

            if(Schema::hasColumn('seller_infos','price_range')){
                $table->string('price_range')->nullable()->change();
            }

            if(Schema::hasColumn('seller_infos','products')){
                $table->string('products')->nullable()->change();
            }

            if(!Schema::hasColumn('seller_infos','is_completed')){
                $table->tinyInteger('is_completed')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_infos', function (Blueprint $table) {
            if(Schema::hasColumn('seller_infos','gst_address')){
                $table->dropColumn('gst_address');
            }

            if(Schema::hasColumn('seller_infos','gst_name')){
                $table->dropColumn('gst_name');
            }

            if(Schema::hasColumn('seller_infos','is_completed')){
                $table->dropColumn('is_completed');
            }
        });
    }
};
