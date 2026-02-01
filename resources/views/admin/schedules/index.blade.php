@extends('admin.layouts.app')

@section('title', 'Jadwal')
@section('header', 'Kelola Jadwal')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.schedules.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Tambah Jadwal
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($schedules as $schedule)
            <tr>
                <td class="px-6 py-4">{{ $schedule->event_date->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    {{ $schedule->start_time }} - {{ $schedule->end_time }}
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded
                        {{ $schedule->status === 'available' ? 'bg-green-200 text-green-800' : '' }}
                        {{ $schedule->status === 'booked' ? 'bg-blue-200 text-blue-800' : '' }}
                        {{ $schedule->status === 'unavailable' ? 'bg-gray-200 text-gray-800' : '' }}">
                        @switch($schedule->status)
                            @case('available')
                                Tersedia
                                @break
                            @case('booked')
                                Dipesan
                                @break
                            @case('unavailable')
                                Tidak Tersedia
                                @break
                            @default
                                {{ ucfirst($schedule->status) }}
                        @endswitch
                    </span>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.schedules.edit', $schedule) }}"
                       class="text-blue-600 hover:underline mr-3">Edit</a>

                    <form action="{{ route('admin.schedules.destroy', $schedule) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline"
                                onclick="return confirm('Apakah Anda yakin?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $schedules->links() }}
</div>
@endsection
