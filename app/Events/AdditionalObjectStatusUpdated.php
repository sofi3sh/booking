<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdditionalObjectStatusUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $additionalObjectId;
    public $isAvailable;

    public function __construct($additionalObjectId, $isAvailable)
    {
        $this->additionalObjectId = $additionalObjectId;
        $this->isAvailable = $isAvailable;
    }

    public function broadcastOn()
    {
        return new Channel('additional-object-status');
    }

    public function broadcastAs()
    {
        return 'additional-object-status-updated';
    }
}
