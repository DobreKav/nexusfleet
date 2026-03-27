<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Truck extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'plate_number',
        'brand',
        'model',
        'year',
        'total_km',
        'current_odometer',
        'service_interval_km',
        'cost_per_km',
        'last_service_date',
        'status',
    ];

    protected $casts = [
        'last_service_date' => 'date',
        'total_km' => 'integer',
        'current_odometer' => 'integer',
        'service_interval_km' => 'integer',
        'cost_per_km' => 'decimal:2',
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
