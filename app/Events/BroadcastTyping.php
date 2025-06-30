<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class BroadcastTyping implements ShouldBroadcast
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
            new Channel('broadcast-channel'),
        ];
    }

    public function broadcastAs()
    {
        return 'broadcast.typing';
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

