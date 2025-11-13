<?php

namespace App\Models;

use App\Enum\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends BaseModel
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => OrderStatus ::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->code)) {
                $order->code = 'ORD-' . strtoupper(Str::random(8));
            }
        });
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', OrderStatus::PENDING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', OrderStatus::DELIVERED);
    }

    public function generatePaymentId()
    {
        return $this->code . '-' . strtoupper(Str::random(4));
    }

}
