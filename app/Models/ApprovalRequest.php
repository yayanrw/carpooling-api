<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalRequest extends Model
{
    use HasFactory;

    protected $table = 't_approval_request';

    protected $fillable = [
        'vehicle_booking_id', 'approval_order', 'approval_user_id', 'note', 'is_approved', 'approved_at',
    ];

    public function vehicleBooking(): BelongsTo
    {
        return $this->belongsTo(VehicleBooking::class);
    }

    public function approvalUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
