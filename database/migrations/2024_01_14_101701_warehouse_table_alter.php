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
        Schema::table('warehouses',function(Blueprint $table){
            if(!Schema::hasColumn('warehouses','return_country')){
                $table->string('return_country')->after('id');
                $table->string('return_state')->after('id');
                $table->string('return_city')->after('id');
                $table->string('return_pincode')->after('id');
                $table->string('return_address')->after('id');
                $table->string('default')->after('id')->nullable();
            }
            if(!Schema::hasColumn('warehouses','client')){
                $table->string('client')->after('default')->nullable();
            }
            if(!Schema::hasColumn('warehouses','country')){
                $table->string('country')->after('id');
                $table->string('state')->after('id');
                $table->string('city')->after('id');
                $table->string('pincode')->after('id');
                $table->string('address')->after('id');
                $table->string('email')->after('id');
                $table->string('mobile')->after('id');
                $table->string('name')->after('id');
                $table->string('user_id')->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warehouses',function(Blueprint $table){
            if(Schema::hasColumn('warehouses','return_country')){
                $table->dropColumn('return_country');
                $table->dropColumn('return_state');
                $table->dropColumn('return_city');
                $table->dropColumn('return_pincode');
                $table->dropColumn('return_address');
            }
            if(Schema::hasColumn('warehouses','default')){
                $table->dropColumn('default');
            }
            if(Schema::hasColumn('warehouses','client')){
                $table->dropColumn('client');
            }
            if(Schema::hasColumn('warehouses','country')){
                $table->dropColumn('country');
                $table->dropColumn('state');
                $table->dropColumn('city');
                $table->dropColumn('pincode');
                $table->dropColumn('address');
                $table->dropColumn('email');
                $table->dropColumn('mobile');
                $table->dropColumn('name');
                $table->dropColumn('user_id');
            }
        });
    }
};
