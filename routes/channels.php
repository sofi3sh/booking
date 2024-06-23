<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('booking-status', function () {
    return true;
});