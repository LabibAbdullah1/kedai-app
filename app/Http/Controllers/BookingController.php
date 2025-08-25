<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Meja;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $booking = Booking::with(['pelanggan', 'meja'])->latest()->get();
        $meja = Meja::all();
        return view('booking.index', compact('booking', 'meja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required',
            'meja_id' => 'required',
            'booking_mulai' => 'required|date',
            'booking_selesai' => 'required|date|after:booking_mulai'
        ]);

        // Cek apakah meja sudah dibooking pada jam tersebut
        $exists = Booking::where('meja_id', $request->meja_id)
            ->where('booking_mulai', '<=', $request->booking_selesai)
            ->where('booking_selesai', '>=', $request->booking_mulai)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Meja sudah dibooking di jam tersebut');
        }

        $booking = Booking::create($request->all());

        $meja = Meja::find($request->meja_id);
        $meja->status = 'dibooking';
        $meja->save();

        return redirect()->back()->with('success', 'Booking meja berhasil');
    }
}
