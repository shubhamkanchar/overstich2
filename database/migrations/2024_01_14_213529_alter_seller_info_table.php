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
            if(!Schema::hasColumn('seller_infos','gst_doc')){
                $table->string('gst_doc')->after('ifsc');
            }
            if(!Schema::hasColumn('seller_infos','noc_doc')){
                $table->string('noc_doc')->after('ifsc');
            }
            if(!Schema::hasColumn('seller_infos','account_holder_name')){
                $table->string('account_holder_name')->after('ifsc');
            }
            if(!Schema::hasColumn('seller_infos','bank_name')){
                $table->string('bank_name')->after('ifsc');
            }
            if(!Schema::hasColumn('seller_infos','account_type')){
                $table->string('account_type')->after('ifsc');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_infos',function(Blueprint $table){
            if(Schema::hasColumn('seller_infos','gst_doc')){
                $table->dropColumn('gst_doc');
            }
            if(Schema::hasColumn('seller_infos','noc_doc')){
                $table->dropColumn('noc_doc');
            }
            if(Schema::hasColumn('seller_infos','account_holder_name')){
                $table->dropColumn('account_holder_name');
            }
            if(Schema::hasColumn('seller_infos','bank_name')){
                $table->dropColumn('bank_name');
            }
            if(Schema::hasColumn('seller_infos','account_type')){
                $table->dropColumn('account_type');
            }
        });
    }
};
