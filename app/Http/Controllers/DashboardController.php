<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return view('dashboard.admin', compact('user'));

            case 'waiter':
                return view('dashboard.waiter', compact('user'));

            case 'koki':
                return view('dashboard.koki', compact('user'));

            case 'pelayan':
                return view('dashboard.pelayan', compact('user'));

            default:
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role tidak dikenali, silakan hubungi admin.');
        }
    }
}
