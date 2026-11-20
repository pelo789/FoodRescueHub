<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodListing extends Model
{
    protected $table = 'food_listings';

    protected $primaryKey = 'food_listing_id';

    protected $fillable = [
        'organization_id',
        'food_name',
        'category',
        'description',
        'quantity',
        'available_quantity',
        'reserved_quantity',
        'redistributed_quantity',
        'expiration_date',
        'storage_requirement',
        'food_condition',
        'allergen_information',
        'pickup_details',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'available_quantity' => 'integer',
            'reserved_quantity' => 'integer',
            'redistributed_quantity' => 'integer',
            'expiration_date' => 'date',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(
            Organization::class,
            'organization_id',
            'organization_id'
        );
    }
}
