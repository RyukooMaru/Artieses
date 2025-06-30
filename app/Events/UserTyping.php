<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $message;
    public $filename;
    public $coderies;
    public $improfil;
    public $timeAgo;
    public $comstoriesid;

    public $broadcastQueue = false;

    public function __construct($username, $message , $filename, $improfil, $coderies, $timeAgo, $comstoriesid)
    {
        $this->username = $username;
        $this->message = $message;
        $this->filename = $filename;
        $this->coderies = $coderies;
        $this->improfil = $improfil;
        $this->timeAgo = $timeAgo;
        $this->comstoriesid = $comstoriesid;
    }
    public function broadcastOn()
    {
        return new Channel('typing-channel');
    }

    public function broadcastAs()
    {
        return 'user.typing';
    }
    public function broadcastWith()
    {
        return [
            'username' => $this->username,
            'message' => $this->message,
            'filename' => $this->filename,
            'coderies' => $this->coderies,
            'improfil' => $this->improfil,
            'timeAgo' => $this->timeAgo,
            'comstoriesid' => $this->comstoriesid,
        ];
    }
}

