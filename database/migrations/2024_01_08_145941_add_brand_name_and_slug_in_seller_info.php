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
            if(!Schema::hasColumn('seller_infos', 'brand')) {
                $table->string('brand')->nullable()->after('seller_id');
            }

            if(!Schema::hasColumn('seller_infos', 'slug')) {
                $table->string('slug')->nullable()->after('brand');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_infos', function (Blueprint $table) {
            if(Schema::hasColumn('seller_infos', 'brand')) {
                $table->dropColumn('brand');
            }
            if(Schema::hasColumn('seller_infos', 'slug')) {
                $table->dropColumn('slug');
            }
        });
    }
};
