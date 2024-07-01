<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'additional_object_id',
        'booked_from',
        'booked_to',
        'payment_status',
        'order_id',
        'description',
        'price',
        'is_child',
    ];
}
