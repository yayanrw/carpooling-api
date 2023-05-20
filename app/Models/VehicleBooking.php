<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleBooking extends Model
{
    use HasFactory;

    protected $table = 't_vehicle_booking';

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'user_request_id',
        'estimation_start_date',
        'actual_start_date',
        'estimation_completion_date',
        'actual_completion_date',
        'necessary',
        'status',
        'created_by',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userRequest(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
