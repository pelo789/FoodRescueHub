<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organization extends Model
{
    protected $primaryKey = 'organization_id';

    protected $fillable = [
        'user_id',
        'organization_name',
        'organization_type',
        'organization_address',
        'verification_status',
        'verification_document',
        'verification_remarks',
    ];

    // Links this organization back to its owner
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    // An organization can have multiple food listings
    public function foodListings(): HasMany
    {
        return $this->hasMany(
            FoodListing::class,
            'organization_id',
            'organization_id'
        );
    }
}
