<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_vehicle';

    protected $fillable = [
        'company_id', 'office_id', 'license_plate', 'hall_number', 'type', 'created_by', 'updated_by', 'deleted_by',
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fuelConsumptions(): HasMany
    {
        return $this->hasMany(FuelConsumption::class);
    }

    public function serviceSchedules(): HasMany
    {
        return $this->hasMany(ServiceSchedule::class);
    }

    public function vehicleBookings(): HasMany
    {
        return $this->hasMany(VehicleBooking::class);
    }
}
