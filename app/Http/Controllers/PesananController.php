<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Menu;
use App\Models\Dapur;
use Illuminate\Http\Request;
use App\Events\PesananBaru;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with(['pelanggan', 'detail.menu'])->latest()->get();
        $menu = Menu::where('status', 'tersedia')->get();

        return view('pesanan.index', compact('pesanan', 'menu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'meja_id' => 'required',
            'waiter_id' => 'required',
            'menu_id' => 'required|array',
            'qty' => 'required|array'
        ]);

        $pesanan = Pesanan::create([
            'pelanggan_id' => $request->pelanggan_id,
            'meja_id' => $request->meja_id,
            'waiter_id' => $request->waiter_id,
            'total_harga' => 0,
            'status' => 'pending'
        ]);

        $total = 0;

        foreach ($request->menu_id as $index => $menuId) {
            $menu = Menu::findOrFail($menuId);
            $subtotal = $menu->harga * $request->qty[$index];

            PesananDetail::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $menuId,
                'qty' => $request->qty[$index],
                'subtotal' => $subtotal
            ]);

            $total += $subtotal;
        }

        $pesanan->update(['total_harga' => $total]);

        Dapur::create([
            'pesanan_id' => $pesanan->id,
            'koki_id' => null,
            'status' => 'pending'
        ]);

        // Kirim notifikasi ke koki realtime
        broadcast(new PesananBaru($pesanan))->toOthers();

        return redirect()->back()->with('success', 'Pesanan berhasil dibuat');
    }
}
