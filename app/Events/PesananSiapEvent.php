<?php

namespace App\Events;

use App\Models\Pesanan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PesananSiapEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pesanan;

    /**
     * Create a new event instance.
     */
    public function __construct(Pesanan $pesanan)
    {
        $this->pesanan = $pesanan;
    }

    /**
     * Tentukan channel broadcast.
     */
    public function broadcastOn()
    {
        return new Channel('pesanan-siap');
    }

    /**
     * Nama event ketika diterima di frontend.
     */
    public function broadcastAs()
    {
        return 'pesanan.siap';
    }

    /**
     * Data yang dikirim ke listener.
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->pesanan->id,
            'nama_pelanggan' => $this->pesanan->pelanggan->nama ?? 'Pelanggan',
            'nama_menu' => $this->pesanan->menu->nama ?? 'Menu',
            'meja' => $this->pesanan->meja->nomor ?? 'Tanpa Meja',
            'status' => $this->pesanan->status,
            'waktu' => now()->format('H:i:s'),
        ];
    }
}
