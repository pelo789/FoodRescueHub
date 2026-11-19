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
        Schema::table('organizations', function (Blueprint $table) {
            if (!Schema::hasColumn('organizations', 'organization_address')) {
                $table->string('organization_address')->nullable()->after('organization_type');
            } // safety check that asks the database if that column already exists before Laravel tries to add or delete it.

            //$table->string('organization_address')->after('organization_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            if (Schema::hasColumn('organizations', 'organization_address')) {
                $table->dropColumn('organization_address');
            }
        });
    }
};
