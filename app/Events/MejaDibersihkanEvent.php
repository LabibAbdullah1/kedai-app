<?php

namespace App\Events;

use App\Models\Meja;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MejaDibersihkanEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $meja;

    public function __construct(Meja $meja)
    {
        $this->meja = $meja;
    }

    public function broadcastOn()
    {
        return new Channel('meja-dibersihkan');
    }

    public function broadcastAs()
    {
        return 'meja.dibersihkan';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->meja->id,
            'nomor' => $this->meja->nomor,
            'status' => $this->meja->status,
        ];
    }
}
