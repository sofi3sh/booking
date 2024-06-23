<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingObjectStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $objectId;
    public $status;

    public function __construct($objectId, $status)
    {
        $this->objectId = $objectId;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new Channel('booking-status');
    }

    public function broadcastAs()
    {
        return 'status-updated';
    }
}
