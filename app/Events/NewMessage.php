<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use App\Models\Message;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Events\NewMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /** 
    *
    * @return \Illuminate\Broadcasting\Channel|array
    */

    public function broadcastOn()
    {
        return new PrivateChannel('messages.' . $this->message->to);
    }

    public function broadcastWith()
    {
        $this->message->load('fromContact');

        return ["message" => $this->message];
    }
}
