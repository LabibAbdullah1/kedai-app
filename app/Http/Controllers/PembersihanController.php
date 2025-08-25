<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Http\Request;

class PembersihanController extends Controller
{
    /**
     * Menampilkan daftar meja yang belum dibersihkan.
     */
    public function index()
    {
        $mejas = Meja::where('status', 'Belum Dibersihkan')->get();
        return view('admin.pembersihan.index', compact('mejas'));
    }

    /**
     * Tandai meja sudah dibersihkan.
     */
    public function updateStatus($id)
    {
        $meja = Meja::findOrFail($id);
        $meja->update(['status' => 'Siap Dipakai']);

        // Broadcast event realtime untuk update status meja
        broadcast(new \App\Events\MejaDibersihkanEvent($meja))->toOthers();

        return redirect()->back()->with('success', "Meja {$meja->nomor} siap dipakai kembali");
    }
}
