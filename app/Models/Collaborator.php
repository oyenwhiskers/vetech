<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Collaborator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'clinic_name',
        'email',
        'phone',
        'address',
        'registration_number',
        'status',
    ];

    /**
     * Get the user associated with the collaborator.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the treatments performed by the collaborator.
     */
    public function treatments(): HasMany
    {
        return $this->hasMany(Treatment::class);
    }
}
