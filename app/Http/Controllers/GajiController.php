<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GajiController extends Controller
{
    public function index()
    {
        $gaji = Gaji::with('user')->latest()->paginate(10);
        return view('admin.gaji.index', compact('gaji'));
    }

    public function create()
    {
        $pegawai = User::whereIn('role', ['waiter', 'koki', 'pelayan'])->get();
        return view('admin.gaji.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode_gaji' => 'required|date',
        ]);

        $userId = $request->user_id;
        $periode = $request->periode_gaji;

        // Ambil absensi pegawai berdasarkan periode gaji
        $absensi = Absensi::where('user_id', $userId)
            ->whereMonth('tanggal', Carbon::parse($periode)->month)
            ->whereYear('tanggal', Carbon::parse($periode)->year)
            ->get();

        $totalHadir = $absensi->count();
        $totalMenitKerja = $absensi->sum('total_menit_kerja');
        $totalLembur = $absensi->sum('total_menit_lembur');

        // Ambil gaji pokok dari profil pegawai
        $user = User::find($userId);
        $gajiPokok = $user->gaji_pokok ?? 2000000; // Default 2 juta kalau belum di-set
        $uangLembur = ($totalLembur / 60) * 20000; // Rp 20.000 per jam
        $totalGaji = $gajiPokok + $uangLembur;

        Gaji::updateOrCreate(
            ['user_id' => $userId, 'periode_gaji' => $periode],
            [
                'total_hadir' => $totalHadir,
                'total_jam_kerja' => $totalMenitKerja,
                'total_lembur' => $totalLembur,
                'gaji_pokok' => $gajiPokok,
                'uang_lembur' => $uangLembur,
                'total_gaji' => $totalGaji,
            ]
        );

        return redirect()->route('admin.gaji.index')->with('success', 'Gaji berhasil dihitung dan disimpan!');
    }

    public function show(Gaji $gaji)
    {
        return view('admin.gaji.show', compact('gaji'));
    }

    public function edit(Gaji $gaji)
    {
        $pegawai = User::whereIn('role', ['waiter', 'koki', 'pelayan'])->get();
        return view('admin.gaji.edit', compact('gaji', 'pegawai'));
    }

    public function update(Request $request, Gaji $gaji)
    {
        $request->validate([
            'status' => 'required|in:belum_dibayar,dibayar',
        ]);

        $gaji->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.gaji.index')->with('success', 'Status gaji berhasil diperbarui!');
    }

    public function destroy(Gaji $gaji)
    {
        $gaji->delete();
        return redirect()->route('admin.gaji.index')->with('success', 'Data gaji berhasil dihapus!');
    }
}
