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
        Schema::table('products',function(Blueprint $table){
            if(!Schema::hasColumn('products','return')){
                $table->integer('return')->default(0)->after('status');
            }

            if(!Schema::hasColumn('products','replace')){
                $table->integer('replace')->default(0)->after('status');
            }

            if(!Schema::hasColumn('products','show')){
                $table->integer('show')->default(1)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products',function(Blueprint $table){
            if(Schema::hasColumn('products','return')){
                $table->dropColumn('return');
            }

            if(Schema::hasColumn('products','replace')){
                $table->dropColumn('replace');
            }

            if(Schema::hasColumn('products','show')){
                $table->dropColumn('show');
            }
        });
    }
};
