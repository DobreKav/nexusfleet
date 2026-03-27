<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trailer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plate_number',
        'type',
        'payload_capacity',
        'status',
    ];

    protected $casts = [
        'payload_capacity' => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
