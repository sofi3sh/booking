<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ua',
        'name_en',
        'description_ua',
        'description_en',
        'price',
        'weekend_price',
        'discount', 
        'discount_start_date', 
        'discount_end_date',
        'photos',
        'zone',
        'status',
        'type',
        'preview_photo', 
        'max_persons',
        'location',
        'position',
        'childrens_price',
        'childrens_weekend_price'
    ];

    protected $casts = [
        'photos' => 'array'
    ];

    protected $table = 'booking_objects';
}
