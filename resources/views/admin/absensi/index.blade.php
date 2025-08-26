@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
        <h1 class="text-2xl font-bold text-gray-800">📌 Daftar Absensi</h1>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table Absensi --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm">
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Jam Masuk</th>
                        <th class="px-4 py-3 text-left">Jam Pulang</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Lembur</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $index => $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            {{-- Nomor Urut --}}
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $absensi->firstItem() + $index }}
                            </td>

                            {{-- Nama User --}}
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                {{ $item->user->name ?? '-' }}
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </td>

                            {{-- Jam Masuk --}}
                            <td class="px-4 py-3 text-sm text-green-600 font-semibold">
                                {{ $item->jam_masuk ?? '-' }}
                            </td>

                            {{-- Jam Pulang --}}
                            <td class="px-4 py-3 text-sm text-red-600 font-semibold">
                                {{ $item->jam_pulang ?? '-' }}
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3 text-center">
                                @if($item->status === 'hadir')
                                    <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">Hadir</span>
                                @elseif($item->status === 'pulang')
                                    <span class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">Pulang</span>
                                @else
                                    <span class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded-full">-</span>
                                @endif
                            </td>

                            {{-- Lembur --}}
                            <td class="px-4 py-3 text-center">
                                @if($item->lembur)
                                    <span class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded-full">Ya</span>
                                @else
                                    <span class="px-3 py-1 text-xs bg-gray-200 text-gray-600 rounded-full">Tidak</span>
                                @endif
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="px-4 py-3 text-center">
                                @if(!$item->lembur)
                                    <form action="{{ route('absensi.confirmOvertime', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 bg-purple-500 hover:bg-purple-600 text-white text-xs rounded-lg shadow">
                                            Konfirmasi Lembur
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-xs">Sudah dikonfirmasi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">
                                Tidak ada data absensi
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4">
            {{ $absensi->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
