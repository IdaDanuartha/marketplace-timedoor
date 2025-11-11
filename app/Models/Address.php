<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends BaseModel
{
    protected $guarded = [];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function customer(): BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'customer_addresses');
    }
}
