<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PesananDetail;
use App\Models\Pesanan;
use App\Models\Menu;
use Illuminate\Http\Request;

class PesananDetailController extends Controller
{
    /**
     * Menampilkan daftar detail pesanan berdasarkan pesanan_id.
     */
    public function index($pesananId)
    {
        $pesanan = Pesanan::with('pelanggan', 'meja')->findOrFail($pesananId);
        $detail = PesananDetail::with('menu')
            ->where('pesanan_id', $pesananId)
            ->get();

        return view('admin.pesanan.detail', compact('pesanan', 'detail'));
    }

    /**
     * Form tambah menu ke dalam pesanan.
     */
    public function create($pesananId)
    {
        $pesanan = Pesanan::findOrFail($pesananId);
        $menus = Menu::where('stok', '>', 0)->get();
        return view('admin.pesanan.create-detail', compact('pesanan', 'menus'));
    }

    /**
     * Simpan detail pesanan baru.
     */
    public function store(Request $request, $pesananId)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'required|integer|min:1'
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $totalHarga = $menu->harga * $request->qty;

        PesananDetail::create([
            'pesanan_id' => $pesananId,
            'menu_id' => $menu->id,
            'qty' => $request->qty,
            'harga_satuan' => $menu->harga,
            'total_harga' => $totalHarga,
        ]);

        // Kurangi stok menu
        $menu->decrement('stok', $request->qty);

        return redirect()->route('pesanan.detail.index', $pesananId)
            ->with('success', 'Menu berhasil ditambahkan ke pesanan');
    }

    /**
     * Form edit menu di pesanan.
     */
    public function edit($pesananId, $detailId)
    {
        $pesanan = Pesanan::findOrFail($pesananId);
        $detail = PesananDetail::findOrFail($detailId);
        $menus = Menu::all();
        return view('admin.pesanan.edit-detail', compact('pesanan', 'detail', 'menus'));
    }

    /**
     * Update menu pada detail pesanan.
     */
    public function update(Request $request, $pesananId, $detailId)
    {
        $detail = PesananDetail::findOrFail($detailId);

        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'required|integer|min:1'
        ]);

        $menu = Menu::findOrFail($request->menu_id);
        $totalHarga = $menu->harga * $request->qty;

        // Kembalikan stok lama
        $detail->menu->increment('stok', $detail->qty);

        // Update detail pesanan
        $detail->update([
            'menu_id' => $menu->id,
            'qty' => $request->qty,
            'harga_satuan' => $menu->harga,
            'total_harga' => $totalHarga,
        ]);

        // Kurangi stok menu baru
        $menu->decrement('stok', $request->qty);

        return redirect()->route('pesanan.detail.index', $pesananId)
            ->with('success', 'Detail pesanan berhasil diperbarui');
    }

    /**
     * Hapus detail pesanan.
     */
    public function destroy($pesananId, $detailId)
    {
        $detail = PesananDetail::findOrFail($detailId);
        $detail->menu->increment('stok', $detail->qty);
        $detail->delete();

        return redirect()->route('pesanan.detail.index', $pesananId)
            ->with('success', 'Detail pesanan berhasil dihapus');
    }
}
