<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class BroadcastTyping1 implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $reqplat;
    public $message;

    public function __construct($username, $reqplat, $message)
    {
        $this->username = $username;
        $this->reqplat = $reqplat;
        $this->message = $message;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('broadcast-channel1'),
        ];
    }

    public function broadcastAs()
    {
        return 'broadcast.typing1';
    }

    public function broadcastWith()
    {
        return [
            'username' => $this->username,
            'reqplat' => $this->reqplat,
            'message' => $this->message,
        ];
    }

}