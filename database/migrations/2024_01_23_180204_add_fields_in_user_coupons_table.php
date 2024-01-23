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
        Schema::table('user_coupons', function (Blueprint $table) {
            if(!Schema::hasColumn('user_coupons','is_applied')){
                $table->tinyInteger('is_applied')->default(0)->after('is_used');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_coupons', function (Blueprint $table) {
            if(Schema::hasColumn('user_coupons','is_applied')){
                $table->dropColumn('is_applied');
            }
        });
    }
};
