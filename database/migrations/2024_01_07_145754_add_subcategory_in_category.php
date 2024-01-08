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
        Schema::table('categories', function (Blueprint $table) {
            if(!Schema::hasColumn('categories', 'subcategory_id')) {
                $table->unsignedBigInteger('subcategory_id')->nullable()->after('parent_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if(Schema::hasColumn('categories', 'subcategory_id')) {
                $table->dropColumn('subcategory_id');
            }
        });
    }
};
