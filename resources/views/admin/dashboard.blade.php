@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Total Pemesanan</h3>
            <p class="text-3xl font-bold">{{ $stats['total_bookings'] }}</p>
        </div>

        <div class="bg-yellow-100 p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Menunggu</h3>
            <p class="text-3xl font-bold">{{ $stats['pending_bookings'] }}</p>
        </div>

        <div class="bg-blue-100 p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Dipesan</h3>
            <p class="text-3xl font-bold">{{ $stats['booked'] }}</p>
        </div>

        <div class="bg-green-100 p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm">Selesai</h3>
            <p class="text-3xl font-bold">{{ $stats['completed'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold">Pemesanan Terbaru</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jadwal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($recent_bookings as $booking)
                        <tr>
                            <td class="px-6 py-4">{{ $booking->user->name }}</td>
                            <td class="px-6 py-4">{{ $booking->service->name }}</td>
                            <td class="px-6 py-4">
                                {{ $booking->schedule->event_date->format('d M Y') }}
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $booking->time_slot }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded
                                        {{ $booking->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                        {{ $booking->status === 'booked' ? 'bg-blue-200 text-blue-800' : '' }}
                                        {{ $booking->status === 'completed' ? 'bg-green-200 text-green-800' : '' }}">
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
                                        @default
                                            {{ ucfirst($booking->status) }}
                                    @endswitch
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection