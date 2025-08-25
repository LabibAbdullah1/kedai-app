<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Events\AbsensiUpdated;
use App\Http\Controllers\Controller;

class AbsensiController extends Controller
{
    // Menampilkan daftar absensi harian
    public function index()
    {
        $absensi = Absensi::with('user')->orderBy('tanggal', 'desc')->paginate(10);
        return view('admin.absensi.index', compact('absensi'));
    }

    // Proses absensi via scan sidik jari
    public function store(Request $request)
    {
        $user = User::where('fingerprint_id', $request->fingerprint_id)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $today = Carbon::today();
        $now = Carbon::now();

        // Cek absensi hari ini
        $absensi = Absensi::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->first();

        if (!$absensi) {
            // Jika belum ada absensi, catat jam masuk
            Absensi::create([
                'user_id' => $user->id,
                'tanggal' => $today,
                'jam_masuk' => $now->format('H:i:s'),
                'status' => 'hadir'
            ]);

            return response()->json(['message' => 'Absensi masuk berhasil']);
            event(new AbsensiUpdated($absensi));
        } else {
            // Jika sudah absen masuk, catat jam pulang jika lewat jam 5 sore
            if ($now->gte(Carbon::createFromTime(17, 0, 0))) {
                $absensi->update([
                    'jam_pulang' => $now->format('H:i:s'),
                    'status' => 'pulang'
                ]);

                return response()->json(['message' => 'Absensi pulang berhasil']);
            } else {
                return response()->json(['message' => 'Anda sudah melakukan absensi masuk']);
            }
        }
    }

    // Konfirmasi lembur oleh admin
    public function confirmOvertime($id)
    {
        $absensi = Absensi::findOrFail($id);

        $absensi->update([
            'lembur' => true,
            'jam_lembur' => 0 // Awal lembur 0, akan dihitung otomatis
        ]);

        return redirect()->back()->with('success', 'Lembur dikonfirmasi!');
    }
}
