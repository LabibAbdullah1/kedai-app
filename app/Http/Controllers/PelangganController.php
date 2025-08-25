<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // Menampilkan daftar pelanggan
    public function index(Request $request)
    {
        $search = $request->input('search');
        $pelanggan = Pelanggan::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%$search%")
                ->orWhere('no_hp', 'like', "%$search%");
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pelanggan.index', compact('pelanggan', 'search'));
    }

    // Form tambah pelanggan
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    // Simpan pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        Pelanggan::create($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    // Detail riwayat pesanan pelanggan
    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $riwayatPesanan = Pesanan::where('pelanggan_id', $id)->latest()->get();

        return view('admin.pelanggan.show', compact('pelanggan', 'riwayatPesanan'));
    }

    // Form edit pelanggan
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    // Update pelanggan
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        $pelanggan->update($request->all());

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    // Hapus pelanggan
    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
