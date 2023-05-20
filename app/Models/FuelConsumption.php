<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelConsumption extends Model
{
    use HasFactory;

    protected $table = 't_fuel_consumption';

    protected $fillable = [
        'vehicle_id', 'date', 'litres', 'created_by'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'created_by',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
