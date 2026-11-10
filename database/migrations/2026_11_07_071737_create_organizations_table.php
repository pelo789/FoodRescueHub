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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id('organization_id');

            $table->foreignId('user_id')
                    ->constrained('users', 'user_id')
                    ->onDelete('cascade');

            $table->string('organization_name');
            $table->string('organization_type');
            $table->string('organization_address')->nullable(); // Good to have for completeness
            
            // Supporting verification document path
            $table->string('verification_document')->nullable();

            // Updated status field supporting all BRD statuses
            $table->enum('verification_status', [
                'Pending', 
                'Verified', 
                'Rejected', 
                'Additional Information Required'
            ])->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
