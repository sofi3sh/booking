<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookingObject;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'object_id',
        'reserved_from',
        'reserved_to',
        'payment_status',
        'booked_from',
        'booked_to',
        'canceled',
        'description',
        'order_id',
        'price',
        'is_child'
    ];

    protected $table = 'bookings';

    public function object()
    {
        return $this->belongsTo(BookingObject::class, 'object_id');
    }
}
