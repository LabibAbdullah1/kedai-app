<?php

namespace App\Events;

use App\Models\Meja;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class MejaUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $meja;

    public function __construct(Meja $meja)
    {
        $this->meja = $meja;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('meja.status');
    }
}
