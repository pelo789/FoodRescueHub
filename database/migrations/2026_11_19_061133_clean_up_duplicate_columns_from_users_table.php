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
            //
            $columnsToDrop = [
            'address',
            'organization_name',
            'verification_status',
            'verification_document',
            'document_path',
        ];

        foreach ($columnsToDrop as $column) {
            if (Schema::hasColumn('users', $column)) {
                $table->dropColumn($column);
            }
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
