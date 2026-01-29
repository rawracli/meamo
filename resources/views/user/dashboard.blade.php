@extends('user.layouts.dashboard')

@section('title', 'Dashboard')
@section('header', 'Overview')

@section('content')
    <!-- Welcome Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
        <div class="p-6 text-gray-900">
            {{ __("Welcome back, ") }} <span class="font-semibold">{{ $user->name }}</span>!
            @if(!$user->phone_number)
                <div class="mt-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    <p>Please <a href="{{ route('profile.edit') }}" class="underline font-bold hover:text-yellow-900">add your
                            phone number</a> to complete your profile and start booking.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Bookings Section -->
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">My Bookings</h3>
                <a href="{{ route('booking.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                    + New Booking
                </a>
            </div>

            @if($bookings->isEmpty())
                <p class="text-gray-500">You haven't made any bookings yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                                    & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $booking->service->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $booking->schedule->date }} <br>
                                        <span class="text-sm text-gray-500">{{ $booking->schedule->start_time }} -
                                            {{ $booking->schedule->end_time }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ $booking->status === 'booked' ? 'bg-blue-100 text-blue-800' : '' }}
                                                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                                    ">
                                            {{ ucfirst($booking->status) }}
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