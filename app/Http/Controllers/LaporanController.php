<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Pesanan;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    // Menampilkan laporan harian, mingguan, bulanan
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'harian');

        switch ($filter) {
            case 'mingguan':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                break;
            case 'bulanan':
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;
            default:
                $start = Carbon::now()->startOfDay();
                $end = Carbon::now()->endOfDay();
                break;
        }

        $pesanan = Pesanan::whereBetween('created_at', [$start, $end])->get();
        $totalPendapatan = $pesanan->sum('total_harga');
        $menuTerlaris = Menu::withCount('pesanan')->orderByDesc('pesanan_count')->take(5)->get();

        return view('admin.laporan.index', compact('pesanan', 'totalPendapatan', 'menuTerlaris', 'filter'));
    }

    // Export PDF
    // public function exportPDF(Request $request)
    // {
    //     $pesanan = Pesanan::latest()->get();
    //     $totalPendapatan = $pesanan->sum('total_harga');
    //     $pdf = PDF::loadView('admin.laporan.pdf', compact('pesanan', 'totalPendapatan'));
    //     return $pdf->download('laporan-kedai.pdf');
    // }

    // Export Excel
    // public function exportExcel(Request $request)
    // {
    //     return Excel::download(new LaporanExport, 'laporan-kedai.xlsx');
    // }
}
