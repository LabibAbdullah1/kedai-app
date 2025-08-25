@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold">Dashboard Koki</h1>
    <p>Halo, {{ $user->name }}! Lihat dan proses pesanan pelanggan.</p>
</div>
@endsection
