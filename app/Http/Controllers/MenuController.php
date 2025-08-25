<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Barryvdh\DomPDF\PDF;
use App\Exports\MenuExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;


class MenuController extends Controller
{
    // Menampilkan semua menu
    public function index(Request $request)
    {
        $search = $request->input('search');
        $menus = Menu::when($search, function ($query) use ($search) {
            $query->where('nama', 'like', "%$search%")
                ->orWhere('kategori', 'like', "%$search%");
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.menu.index', compact('menus', 'search'));
    }

    // Form tambah menu
    public function create()
    {
        return view('admin.menu.create');
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        }

        Menu::create($data);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    // Form edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
    }

    // Update menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Jika ada gambar baru, ganti gambar lama
        if ($request->hasFile('gambar')) {
            if ($menu->gambar && file_exists(storage_path('app/public/' . $menu->gambar))) {
                unlink(storage_path('app/public/' . $menu->gambar));
            }
            $data['gambar'] = $request->file('gambar')->store('menu', 'public');
        }

        $menu->update($data);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui');
    }

    // Hapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->gambar && file_exists(storage_path('app/public/' . $menu->gambar))) {
            unlink(storage_path('app/public/' . $menu->gambar));
        }
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus');
    }

    // Export PDF
    // public function exportPDF()
    // {
    //     $menus = Menu::all();
    //     $pdf = PDF::loadView('admin.menu.pdf', compact('menus'));
    //     return $pdf->download('menu-kedai.pdf');
    // }

    // Export Excel
    // public function exportExcel()
    // {
    //     return Excel::download(new MenuExport, 'menu-kedai.xlsx');
    // }
}
