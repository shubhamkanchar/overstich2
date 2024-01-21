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
        Schema::table('seller_infos',function(Blueprint $table){
            if(!Schema::hasColumn('seller_infos','owner_name')){
                $table->string('owner_name')->after('ifsc');
            }
            if(!Schema::hasColumn('seller_infos','owner_contact')){
                $table->string('owner_contact')->after('ifsc');
            }
            if(!Schema::hasColumn('seller_infos','organization_name')){
                $table->string('organization_name')->after('ifsc');
            }
            if(!Schema::hasColumn('seller_infos','cancel_cheque')){
                $table->string('cancel_cheque')->after('ifsc');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_infos',function(Blueprint $table){
            if(Schema::hasColumn('seller_infos','owner_name')){
                $table->dropColumn('owner_name');
            }
            if(Schema::hasColumn('seller_infos','owner_contact')){
                $table->dropColumn('owner_contact');
            }
            if(Schema::hasColumn('seller_infos','organization_name')){
                $table->dropColumn('organization_name');
            }
            if(Schema::hasColumn('seller_infos','cancel_cheque')){
                $table->dropColumn('cancel_cheque');
            }
        });
    }
};
