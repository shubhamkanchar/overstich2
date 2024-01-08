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
            if(!Schema::hasColumn('products', 'subcategory_id')) {
                $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            }

            if(!Schema::hasColumn('products', 'master_category_id')) {
                $table->unsignedBigInteger('master_category_id')->nullable()->after('category_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if(Schema::hasColumn('products', 'subcategory_id')) {
                $table->dropColumn('subcategory_id');
            }
            if(Schema::hasColumn('products', 'master_category_id')) {
                $table->dropColumn('master_category_id');
            }
        });
    }
};
