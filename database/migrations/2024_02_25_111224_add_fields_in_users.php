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
        Schema::table('users', function (Blueprint $table) {
            if(!Schema::hasColumn('users','phone')){
                $table->string('phone')->nullable()->after('name');
            }

            if(!Schema::hasColumn('users','avatar')){
                $table->string('avatar')->nullable()->after('phone');
            }

            if(!Schema::hasColumn('users','is_active')){
                $table->tinyInteger('is_active')->default(1)->after('avatar');
            }

            if(!Schema::hasColumn('users','can_notify')){
                $table->tinyInteger('can_notify')->default(0)->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if(Schema::hasColumn('users','phone')){
                $table->dropColumn('phone');
            }

            if(Schema::hasColumn('users','avatar')){
                $table->dropColumn('avatar');
            }

            if(Schema::hasColumn('users','is_active')){
                $table->dropColumn('is_active');
            }

            if(Schema::hasColumn('users','can_notify')){
                $table->dropColumn('can_notify');
            }
        });
    }
};
