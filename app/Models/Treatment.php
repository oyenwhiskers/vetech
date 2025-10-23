<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'user_id',
        'collaborator_id',
        'treatment_date',
        'disease',
        'diagnosis',
        'treatment_given',
        'medication',
        'cost',
        'notes',
        'treatment_location',
    ];

    protected $casts = [
        'treatment_date' => 'date',
        'cost' => 'decimal:2',
    ];

    /**
     * Get the pet that received the treatment.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Get the user (vet) who performed the treatment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the collaborator if treatment was done at collaborator clinic.
     */
    public function collaborator(): BelongsTo
    {
        return $this->belongsTo(Collaborator::class);
    }
}
