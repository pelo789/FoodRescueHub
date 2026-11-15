<?php
// database/migrations/xxxx_xx_xx_update_users_table_for_brd.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');

            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();

            $table->enum('role', ['admin', 'food_provider', 'recipient_organization'])
                ->default('recipient_organization');

            $table->enum('status', ['active', 'inactive', 'banned'])
                ->default('active');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
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