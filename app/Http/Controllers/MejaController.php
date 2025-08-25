<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;
use App\Events\MejaUpdated;

class MejaController extends Controller
{
    public function index()
    {
        $meja = Meja::orderBy('nomor_meja', 'asc')->get();
        return view('meja.index', compact('meja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|unique:meja',
            'kapasitas' => 'required|integer'
        ]);

        Meja::create($request->all());

        return redirect()->back()->with('success', 'Meja berhasil ditambahkan');
    }

    public function updateStatus(Request $request, $id)
    {
        $meja = Meja::findOrFail($id);
        $meja->status = $request->status;
        $meja->save();

        // Kirim event realtime
        broadcast(new MejaUpdated($meja))->toOthers();

        return response()->json(['success' => true]);
    }
}
