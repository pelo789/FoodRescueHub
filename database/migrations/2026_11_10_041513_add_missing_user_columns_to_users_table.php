<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check and add columns if they don't already exist
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->string('verification_status')->default('Pending');
            }
            if (!Schema::hasColumn('users', 'account_status')) {
                $table->string('account_status')->default('Active');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('recipient_organization');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'verification_status',
                'account_status',
                'role',
                'phone',
                'address'
            ]);
        });
    }
};