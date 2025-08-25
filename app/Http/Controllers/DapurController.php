<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

class DapurController extends Controller
{
    // Menampilkan daftar pesanan untuk koki
    public function index()
    {
        $pesanan = Pesanan::with('menu', 'meja', 'pelanggan')
            ->orderBy('created_at', 'desc')
            ->where('status', '!=', 'Selesai')
            ->paginate(10);

        return view('admin.dapur.index', compact('pesanan'));
    }

    // Update status pesanan menjadi "Siap Diambil"
    public function updateStatus($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => 'Siap Diambil']);

        // Broadcast event realtime ke pelayan
        broadcast(new \App\Events\PesananSiapEvent($pesanan))->toOthers();

        return redirect()->back()->with('success', 'Pesanan siap diambil');
    }

    // Menampilkan riwayat pesanan
    public function riwayat()
    {
        $riwayat = Pesanan::with('menu', 'meja', 'pelanggan')
            ->where('status', 'Selesai')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('admin.dapur.riwayat', compact('riwayat'));
    }
}
