<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class hapuscomment1 implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $id1;
    public $id;
    public function __construct($id1, $id)
    {
        $this->id1 = $id1;
        $this->id = $id;
    }
    public function broadcastOn(): array
    {
        return [
            new Channel('hapuscomment1'),
        ];
    }
    public function broadcastAs()
    {
        return 'hapuscomment1';
    }
    public function broadcastWith()
    {
        return [
            'id1' => $this->id1,
            'id' => $this->id,
        ];
    }
}