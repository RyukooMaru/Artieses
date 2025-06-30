<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping1 implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userid;
    public $username;
    public $message;
    public $comstoriesid;
    public $improfil;
    public $timeAgo;
    public $filename;
    public $jumlah;
    public $reqplat;

    public $broadcastQueue = false;

    public function __construct($userid, $username, $message, $comstoriesid, $improfil, $timeAgo, $filename, $jumlah, $reqplat)
    {
        $this->username = $username;
        $this->userid = $userid;
        $this->message = $message;
        $this->filename = $filename;
        $this->improfil = $improfil;
        $this->timeAgo = $timeAgo;
        $this->comstoriesid = $comstoriesid;
        $this->jumlah = $jumlah;
        $this->reqplat = $reqplat;
    }
    public function broadcastOn()
    {
        return new Channel('typing-channel1');
    }

    public function broadcastAs()
    {
        return 'user.typing1';
    }
    public function broadcastWith()
    {
        return [
            'userid' => $this->userid,
            'username' => $this->username,
            'message' => $this->message,
            'filename' => $this->filename,
            'improfil' => $this->improfil,
            'timeAgo' => $this->timeAgo,
            'comstoriesid' => $this->comstoriesid,
            'jumlah' => $this->jumlah,
            'reqplat' => $this->reqplat,
        ];
    }
}