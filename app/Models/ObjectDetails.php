<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectDetails extends Model
{

    protected $fillable = [
        'booking_object_id',
        'title_ua',
        'title_en',
        'description_ua',
        'description_en',
        'img',
    ];

    use HasFactory;
}
