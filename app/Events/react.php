<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class react implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $username;
    public $reqplat;
    public $reactfront;
    public function __construct($username, $reqplat, $reactfront)
    {
        $this->username = $username;
        $this->reqplat = $reqplat;
        $this->reactfront = $reactfront;
    }
    public function broadcastOn(): array
    {
        return [
            new Channel('react'),
        ];
    }
    public function broadcastAs()
    {
        return 'react';
    }
    public function broadcastWith()
    {
        return [
            'username' => $this->username,
            'reqplat' => $this->reqplat,
            'reactfront' => $this->reactfront,
        ];
    }
}

