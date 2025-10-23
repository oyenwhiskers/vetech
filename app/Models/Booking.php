<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'pet_id',
        'booking_date',
        'booking_time',
        'service_type',
        'reason',
        'status',
        'queue_number',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime:H:i',
    ];

    /**
     * Get the customer for the booking.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the pet for the booking.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}
