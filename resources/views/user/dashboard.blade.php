@extends('user.layouts.dashboard')

@section('title', 'Dashboard')
@section('header', 'Ringkasan')

@section('content')
    <!-- Bagian Selamat Datang -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
        <div class="p-6 text-gray-900">
            {{ __("Selamat datang kembali, ") }} <span class="font-semibold">{{ $user->name }}</span>!
            @if(!$user->phone_number)
                <div class="mt-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <p>Silakan <a href="{{ route('profile.edit') }}" class="underline font-bold hover:text-yellow-900">tambahkan nomor telepon Anda</a> untuk melengkapi profil dan mulai melakukan pemesanan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Bagian Pemesanan -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">Pemesanan Saya</h3>
                <a href="{{ route('booking.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    + Pemesanan Baru
                </a>
            </div>

            @if($bookings->isEmpty())
                <p class="text-gray-500">Anda belum melakukan pemesanan.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Layanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                                    & Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->service->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($booking->schedule->event_date)->format('Y-m-d') }} <br>
                                        <span class="text-sm text-gray-500">{{ $booking->time_slot }} (Slot Antrian)</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                    {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                                    {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                                    {{ $booking->status === 'booked' ? 'bg-blue-100 text-blue-800' : '' }}
                                                                    {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                                ">
                                            @switch($booking->status)
                                                @case('completed')
                                                    Selesai
                                                    @break
                                                @case('pending')
                                                    Menunggu
                                                    @break
                                                @case('booked')
                                                    Dipesan
                                                    @break
                                                @case('cancelled')
                                                    Dibatalkan
                                                    @break
                                                @default
                                                    {{ ucfirst($booking->status) }}
                                            @endswitch
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $booking->notes ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection