
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Preserve old roles while allowing the new FoodRescue Hub roles.
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'admin',
                'customer',
                'administrator',
                'food_provider',
                'recipient_organization'
            ) NOT NULL DEFAULT 'customer'
        ");

        // Preserve old account statuses while allowing the new statuses.
        DB::statement("
            ALTER TABLE users
            MODIFY status ENUM(
                'active',
                'inactive',
                'banned',
                'suspended',
                'deactivated'
            ) NOT NULL DEFAULT 'active'
        ");

        Schema::table('users', function (Blueprint $table) {
            $table->string('organization_name', 150)
                ->nullable()
                ->after('address');

            $table->enum('verification_status', [
                'pending',
                'verified',
                'rejected'
            ])->default('pending')->after('status');

            $table->string('verification_document', 255)
                ->nullable()
                ->after('verification_status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'organization_name',
                'verification_status',
                'verification_document'
            ]);
        });

        // Keep expanded role and status enums to avoid losing
        // values if newer accounts have already been created.
    }
};
