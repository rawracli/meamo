@extends('admin.layouts.app')

@section('title', 'Detail Pemesanan')
@section('header', 'Detail Pemesanan')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-4xl">

        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-xl font-bold">Pemesanan #{{ $booking->id }}</h3>
                <span class="text-gray-500">Dibuat: {{ $booking->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold">{{ $booking->queue_number }}</div>
                <div class="text-sm text-gray-500">Urutan #{{ $booking->sequence }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-semibold mb-3 border-b pb-2">Info Pelanggan</h3>
                <p class="mb-1"><span class="font-medium">Nama:</span> {{ $booking->user->name }}</p>
                <p class="mb-1"><span class="font-medium">Telepon:</span> {{ $booking->user->phone_number ?? '-' }}</p>
                @if($booking->notes)
                    <div class="mt-2 bg-yellow-50 p-2 rounded text-sm">
                        <span class="font-medium">Catatan:</span> {{ $booking->notes }}
                    </div>
                @endif
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-3 border-b pb-2">Info Jadwal</h3>
                <p class="mb-1"><span class="font-medium">Tanggal:</span> {{ $booking->schedule->event_date->format('d F Y') }}
                </p>
                <p class="mb-1"><span class="font-medium">Est. Slot:</span> {{ $booking->time_slot }}</p>
                <p class="mb-1"><span class="font-medium">Status:</span>
                    <span
                        class="px-2 py-1 text-xs rounded-full 
                            {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' :
        ($booking->status === 'skipped' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                        @switch($booking->status)
                            @case('pending')
                                Menunggu
                                @break
                            @case('booked')
                                Dipesan
                                @break
                            @case('completed')
                                Selesai
                                @break
                            @case('cancelled')
                                Dibatalkan
                                @break
                            @case('skipped')
                                Dilewati
                                @break
                            @default
                                {{ ucfirst($booking->status) }}
                        @endswitch
                    </span>
                </p>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-3 border-b pb-2">Ringkasan Pesanan</h3>

            <div class="bg-gray-50 rounded p-4">
                <div class="flex justify-between mb-2">
                    <span>Layanan Dasar: <b>{{ $booking->service->name }}</b></span>
                    <span>Rp {{ number_format($booking->service->price, 0, ',', '.') }}</span>
                </div>

                @foreach($booking->addons as $addon)
                    <div class="flex justify-between mb-2 text-sm text-gray-700">
                        <span>+ Tambahan: {{ $addon->name }}</span>
                        <span>Rp {{ number_format($addon->price, 0, ',', '.') }}</span>
                    </div>
                @endforeach

                @if($booking->promo)
                    <div class="flex justify-between mb-2 text-green-600">
                        <span>Promo: {{ $booking->promo->code ?? $booking->promo->description }}</span>
                        <span>- Rp {{ number_format($booking->promo->discount_amount ?? 0, 0, ',', '.') }}</span>
                    </div>
                @endif

                <div class="border-t mt-3 pt-3 flex justify-between font-bold text-lg">
                    <span>Total Harga</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-3 border-b pb-2">Hasil Item (Output)</h3>
            <ul class="list-disc list-inside">
                @foreach($booking->items as $item)
                    <li>{{ $item->name }} <span
                            class="badge bg-blue-100 text-blue-800 px-2 rounded-full text-xs">x{{ $item->pivot->quantity }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <hr class="my-6">

        <div class="flex gap-4 items-center flex-wrap">
            <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" class="flex gap-2 items-center">
                @csrf
                @method('PATCH')
                <select name="status" class="border px-3 py-2 rounded">
                    @foreach(['pending', 'booked', 'skipped', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $booking->status === $status ? 'selected' : '' }}>
                            @switch($status)
                                @case('pending')
                                    Menunggu
                                    @break
                                @case('booked')
                                    Dipesan
                                    @break
                                @case('skipped')
                                    Dilewati
                                    @break
                                @case('completed')
                                    Selesai
                                    @break
                                @case('cancelled')
                                    Dibatalkan
                                    @break
                            @endswitch
                        </option>
                    @endforeach
                </select>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Perbarui Status
                </button>
            </form>

            @if($booking->status === 'skipped')
                <form action="{{ route('admin.bookings.move-to-top', $booking) }}" method="POST">
                    @csrf
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-bold">
                        ↑ Pindah ke Atas
                    </button>
                </form>
            @endif

            @if($booking->status === 'completed')
                <form action="{{ route('admin.bookings.send-result', $booking) }}" method="POST">
                    @csrf
                    <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                        Kirim Foto
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.bookings.index') }}" class="ml-auto text-gray-600 hover:underline">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection