@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold">Dashboard Admin</h1>
        <p>Halo, {{ $user->name }}! Kelola pegawai, menu, meja, gaji, dan laporan.</p>
    </div>
@endsection
