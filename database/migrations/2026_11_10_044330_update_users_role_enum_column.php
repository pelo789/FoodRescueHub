<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Updating the enum to support our BRD roles
            $table->enum('role', ['admin', 'food_provider', 'recipient_organization'])
                  ->default('recipient_organization')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'customer'])->default('customer')->change();
        });
    }
};