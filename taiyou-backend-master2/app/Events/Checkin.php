<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use App\Model\System\CheckInCheckOut;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Checkin
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $checkInCheckOut, $emailReceiveMail, $businessCategory)
    {
        $this->checkInCheckOut = $checkInCheckOut;
        $this->emailReceiveMail = $emailReceiveMail;
        $this->businessCategory = $businessCategory;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
