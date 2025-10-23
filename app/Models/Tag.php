<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'tag_code',
        'qr_code_path',
        'status',
        'issued_date',
        'notes',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    /**
     * Get the pet that owns the tag.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}
