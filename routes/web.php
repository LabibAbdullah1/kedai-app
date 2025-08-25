<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    DashboardController,
    MejaController,
    BookingController,
    MenuController,
    PelangganController,
    PesananController,
    profileController,
    PesananDetailController,
    DapurController,
    PembersihanController,
    AbsensiController,
    GajiController,
    LaporanController
};

// PROFILE
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| AUTHENTICATION & LOGIN
|--------------------------------------------------------------------------
*/

// HALAMAN UTAMA APP
Route::get('/', function () {
    return view('welcome');
});

//RUTE LOGIN & REGISTER
Route::get('/login', function () {
    return view('auth', ['form' => 'login']);
})->name('login');

Route::get('/register', function () {
    return view('auth', ['form' => 'register']);
})->name('register');


// ==========================
// DASHBOARD UTAMA
// ==========================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Meja
    Route::get('/meja', [MejaController::class, 'index'])->name('meja.index');
    Route::get('/meja/create', [MejaController::class, 'create'])->name('meja.create');
    Route::post('/meja/store', [MejaController::class, 'store'])->name('meja.store');
    Route::get('/meja/edit/{id}', [MejaController::class, 'edit'])->name('meja.edit');
    Route::post('/meja/update/{id}', [MejaController::class, 'update'])->name('meja.update');
    Route::delete('/meja/delete/{id}', [MejaController::class, 'destroy'])->name('meja.destroy');
    Route::get('/meja/status/{id}', [MejaController::class, 'status'])->name('meja.status');

    // Booking
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/edit/{id}', [BookingController::class, 'edit'])->name('booking.edit');
    Route::post('/booking/update/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/delete/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
    Route::get('/booking/check', [BookingController::class, 'check'])->name('booking.check');

    // Menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
    Route::post('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/delete/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/edit/{id}', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::post('/pelanggan/update/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/pelanggan/delete/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    // Absensi & Gaji
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/riwayat', [AbsensiController::class, 'riwayat'])->name('absensi.riwayat');

    Route::get('/gaji', [GajiController::class, 'index'])->name('gaji.index');
    Route::get('/gaji/create', [GajiController::class, 'create'])->name('gaji.create');
    Route::post('/gaji/store', [GajiController::class, 'store'])->name('gaji.store');
    Route::get('/gaji/edit/{id}', [GajiController::class, 'edit'])->name('gaji.edit');
    Route::post('/gaji/update/{id}', [GajiController::class, 'update'])->name('gaji.update');
    Route::delete('/gaji/delete/{id}', [GajiController::class, 'destroy'])->name('gaji.destroy');
    Route::get('/gaji/slip/{id}', [GajiController::class, 'slip'])->name('gaji.slip');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/harian', [LaporanController::class, 'harian'])->name('laporan.harian');
    Route::get('/laporan/bulanan', [LaporanController::class, 'bulanan'])->name('laporan.bulanan');
    Route::get('/laporan/tahunan', [LaporanController::class, 'tahunan'])->name('laporan.tahunan');
    Route::get('/laporan/menu-terlaris', [LaporanController::class, 'menuTerlaris'])->name('laporan.menu.terlaris');
});

/*
|--------------------------------------------------------------------------
| WAITER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:waiter'])->group(function () {
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
    Route::post('/pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/edit/{id}', [PesananController::class, 'edit'])->name('pesanan.edit');
    Route::post('/pesanan/update/{id}', [PesananController::class, 'update'])->name('pesanan.update');
    Route::delete('/pesanan/delete/{id}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
    Route::get('/pesanan/status/{id}', [PesananController::class, 'status'])->name('pesanan.status');
    Route::get('/pesanan/detail/{id}', [PesananDetailController::class, 'index'])->name('pesanandetail.index');
    Route::post('/pesanan/detail/add', [PesananDetailController::class, 'store'])->name('pesanandetail.store');
    Route::delete('/pesanan/detail/delete/{id}', [PesananDetailController::class, 'destroy'])->name('pesanandetail.destroy');
});

/*
|--------------------------------------------------------------------------
| KOKI AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:koki'])->group(function () {
    Route::get('/dapur', [DapurController::class, 'index'])->name('dapur.index');
    Route::post('/dapur/update/{id}', [DapurController::class, 'update'])->name('dapur.update');
});

/*
|--------------------------------------------------------------------------
| PELAYAN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pelayan'])->group(function () {
    Route::get('/pembersihan', [PembersihanController::class, 'index'])->name('pembersihan.index');
    Route::post('/pembersihan/update/{id}', [PembersihanController::class, 'update'])->name('pembersihan.update');
});

require __DIR__ . '/auth.php';
