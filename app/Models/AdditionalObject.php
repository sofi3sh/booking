<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ua',
        'name_en',
        'description_ua',
        'description_en',
        'price',
        'weekend_price',
        'is_available',
    ];
}
