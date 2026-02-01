@extends('admin.layouts.app')

@section('title', 'Pemesanan')
@section('header', 'Kelola Pemesanan')

@section('content')
    <div class="mb-4">
        <form method="GET" class="flex gap-2">
            <select name="status" class="px-3 py-2 border rounded">
                <option value="">Semua Status</option>
                @foreach(['pending', 'booked', 'completed', 'cancelled'] as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                        @switch($status)
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
                        @endswitch
                    </option>
                @endforeach
            </select>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Filter
            </button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Antrian</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Telepon</th>
                    <th class="px-6 py-3">Layanan</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 font-bold">{{ $booking->queue_number }} <span
                                    class="text-xs text-gray-500">#{{ $booking->sequence }}</span></td>
                            <td class="px-6 py-4">{{ $booking->user->name }}</td>
                            <td class="px-6 py-4">{{ $booking->user->phone_number }}</td>
                            <td class="px-6 py-4">{{ $booking->service->name }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    {{ $booking->schedule->event_date->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $booking->time_slot }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
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
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="{{ route('admin.bookings.show', $booking) }}"
                                    class="text-blue-600 hover:underline">Lihat</a>

                                @if($booking->status === 'skipped')
                                    <form action="{{ route('admin.bookings.move-to-top', $booking) }}" method="POST"
                                        onsubmit="return confirm('Pindahkan pemesanan ini ke urutan teratas?');">
                                        @csrf
                                        <button class="text-green-600 hover:underline text-xs">Pindah Atas</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
@endsection