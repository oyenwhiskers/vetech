<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Treatment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pet_id',
        'user_id',
        'collaborator_id',
        'treated_by',
        'treatment_date',
        'disease',
        'diagnosis',
        'treatment_given',
        'medication',
        'cost',
        'notes',
        'treatment_location',
        'deleted_by',
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

    /**
     * Get the user who deleted the treatment.
     */
    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Check if current user can delete this treatment.
     */
    public function canBeDeletedBy($user): bool
    {
        return $this->user_id === $user->id;
    }

    /**
     * Check if current user can view this treatment.
     */
    public function canBeViewedBy($user): bool
    {
        // All authenticated users can view treatments
        return true;
    }
}
