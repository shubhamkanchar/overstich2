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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['new','processed','delivered','cancelled','returned','rejected'])->change();
            if(!Schema::hasColumn('orders','rejection_reason')){
                $table->text('rejection_reason')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', ['new','processed','delivered','cancelled','returned'])->change();
            if(Schema::hasColumn('orders','rejection_reason')){
                $table->dropColumn('rejection_reason');
            }
        });
    }
};
