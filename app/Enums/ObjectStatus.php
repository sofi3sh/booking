<?php

namespace App\Enums;

/**
 * The Status enum.
 *
 */
enum ObjectStatus: string
{
    case FREE = 'free';
    case RESERVED = 'reserved';
    case BOOKED = 'booked';
}