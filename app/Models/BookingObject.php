<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingObject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'photos', 'preview_photo', 'type'];

    protected $casts = [
        'photos' => 'array'
    ];

    protected $table = 'booking_objects';
}
