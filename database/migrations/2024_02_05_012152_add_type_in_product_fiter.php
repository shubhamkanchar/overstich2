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
        Schema::table('product_filters', function (Blueprint $table) {
            if(!Schema::hasColumn('product_filters','type')){
                $table->string('type')->after('filter_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_filters', function (Blueprint $table) {
            if(Schema::hasColumn('product_filters','type')){
                $table->dropColumn('type');
            }
        });
    }
};
