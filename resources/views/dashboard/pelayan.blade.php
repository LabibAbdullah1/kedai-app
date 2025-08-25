@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold">Dashboard Pelayan</h1>
        <p>Halo, {{ $user->name }}! Antar pesanan dan bersihkan meja pelanggan.</p>
    </div>
@endsection
