@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold">Dashboard Waiter</h1>
    <p>Halo, {{ $user->name }}! Silakan kelola pesanan dan meja pelanggan.</p>
</div>
@endsection
