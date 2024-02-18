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
            if(!Schema::hasColumn('seller_infos','signature')){
                $table->string('signature')->nullable()->after('slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_infos', function (Blueprint $table) {
            if(Schema::hasColumn('seller_infos','signature')){
                $table->dropColumn('signature');
            }
        });
    }
};
