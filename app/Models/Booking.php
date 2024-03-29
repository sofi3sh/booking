<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'object_id', 'reserved_from', 'reserved_to', 'payment_status'];

    protected $table = 'bookings';
}
