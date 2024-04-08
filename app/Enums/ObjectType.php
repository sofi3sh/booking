<?php

namespace App\Enums;

/**
 * The Status enum.
 *
 */
enum ObjectType: string
{
    case SUNBED = 'sunbed';
    case BED = 'bed';
    case BUNGALOW = 'bungalow';
    case SECOND_BUNGALOW = 'second bungalow';
    case LITTLE_COTTAGE = 'little cottage';
    case BIG_COTTAGE = 'big cottage';
}