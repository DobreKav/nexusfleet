<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'truck_id',
        'trailer_id',
        'driver_id',
        'partner_id',
        'start_location',
        'end_location',
        'start_date',
        'end_date',
        'total_km',
        'cost_per_km',
        'total_cost',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'total_km' => 'integer',
        'cost_per_km' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($tour) {
            if ($tour->total_km) {
                // Користи ја turata cost_per_km ако е поставена, инаку користи truck's cost_per_km
                $costPerKm = $tour->cost_per_km ?? ($tour->truck->cost_per_km ?? 0.50);
                $tour->total_cost = $tour->total_km * $costPerKm;
            }
        });

        static::saved(function ($tour) {
            // Ажурирај ја километражата на камионот кога turata е завршена
            if ($tour->isDirty('status') && $tour->status === 'completed') {
                $tour->truck->update([
                    'current_odometer' => $tour->truck->current_odometer + $tour->total_km,
                ]);
            }

            // Автоматски создај фактура кога Тура е завршена
            if ($tour->isDirty('status') && $tour->status === 'completed' && $tour->partner_id) {
                Invoice::create([
                    'company_id' => $tour->company_id,
                    'tour_id' => $tour->id,
                    'type' => 'outbound',
                    'client_or_supplier_name' => $tour->partner->name ?? 'Партнер',
                    'amount' => $tour->total_cost,
                    'issue_date' => now()->toDateString(),
                    'due_date' => now()->addDays(30)->toDateString(),
                    'status' => 'pending',
                    'notes' => "Фактура за Тура од {$tour->start_location} до {$tour->end_location}",
                ]);
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function truck(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }

    public function trailer(): BelongsTo
    {
        return $this->belongsTo(Trailer::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(DriverExpense::class);
    }
}
