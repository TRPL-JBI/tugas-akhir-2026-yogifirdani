<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'package_id',
        'num_participants',
        'booking_date',
        'trip_date',
        'total_price',
        'dp_amount',
        'remaining_amount',
        'payment_status',
        'booking_status',
        'customer_name',
        'customer_phone',
        'customer_email',
        'notes',
        'snap_token',
        'identity_document_path',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'trip_date'    => 'date',
    ];

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class, 'package_id');
    }
}
