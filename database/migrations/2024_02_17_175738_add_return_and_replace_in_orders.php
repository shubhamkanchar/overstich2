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
        Schema::table('orders',function(Blueprint $table){
            if(!Schema::hasColumn('orders','return')){
                $table->tinyInteger('return')->default(0)->after('status');
            }

            if(!Schema::hasColumn('orders','replace')){
                $table->tinyInteger('replace')->default(0)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if(Schema::hasColumn('orders','return')){
                $table->dropColumn('return');
            }

            if(Schema::hasColumn('orders','replace')){
                $table->dropColumn('replace');
            }
        });
    }
};
