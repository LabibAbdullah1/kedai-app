<?php

namespace App\Events;

use App\Models\Absensi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AbsensiUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $absensi;

    public function __construct(Absensi $absensi)
    {
        $this->absensi = $absensi;
    }

    public function broadcastOn()
    {
        return new Channel('absensi-updates');
    }
}
