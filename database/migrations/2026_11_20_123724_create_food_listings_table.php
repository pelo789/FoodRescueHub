
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_listings', function (Blueprint $table) {

            // Primary Key
            $table->id('food_listing_id');

            // Organization Ownership and Food Origin
            $table->unsignedBigInteger('organization_id');

            // Food Information
            $table->string('food_name', 150);
            $table->string('category', 100);
            $table->text('description')->nullable();

            // Food Inventory
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('available_quantity');
            $table->unsignedInteger('reserved_quantity')->default(0);
            $table->unsignedInteger('redistributed_quantity')->default(0);

            // Expiration and Food Safety Information
            $table->date('expiration_date');
            $table->string('storage_requirement', 150);
            $table->string('food_condition', 100);
            $table->text('allergen_information')->nullable();

            // Pickup Information
            $table->text('pickup_details')->nullable();

            // Food Listing Status
            $table->enum('status', [
                'Available',
                'Partially Reserved',
                'Fully Reserved',
                'Partially Redistributed',
                'Fully Redistributed',
                'Expired',
                'Withdrawn',
            ])->default('Available');

            // Timestamps
            $table->timestamps();

            // Organization Relationship
            $table->foreign('organization_id')
                ->references('organization_id')
                ->on('organizations')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_listings');
    }
};
