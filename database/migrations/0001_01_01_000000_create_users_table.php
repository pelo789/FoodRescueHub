<?php
// database/migrations/xxxx_xx_xx_update_users_table_for_brd.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Ensure role exists
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('recipient_organization');
            }
            // Verification status per BRD
            if (!Schema::hasColumn('users', 'verification_status')) {
                $table->string('verification_status')->default('Pending');
            }
            // Account status per BRD
            if (!Schema::hasColumn('users', 'account_status')) {
                $table->string('account_status')->default('Active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'verification_status', 'account_status']);
        });
    }
};
?>