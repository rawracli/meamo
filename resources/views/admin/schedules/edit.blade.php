@extends('admin.layouts.app')

@section('title', 'Edit Jadwal')
@section('header', 'Edit Jadwal')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tanggal Acara</label>
                <input type="date" name="event_date" value="{{ old('event_date', $schedule->event_date->format('Y-m-d')) }}"
                    class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Waktu Mulai</label>
                <input type="time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}"
                    class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Waktu Selesai</label>
                <input type="time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}"
                    class="w-full px-3 py-2 border rounded" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border rounded" required>
                    <option value="available" {{ $schedule->status === 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="booked" {{ $schedule->status === 'booked' ? 'selected' : '' }}>Dipesan</option>
                    <option value="unavailable" {{ $schedule->status === 'unavailable' ? 'selected' : '' }}>Tidak Tersedia
                    </option>
                </select>
            </div>

            <div class="flex gap-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Perbarui
                </button>
                <a href="{{ route('admin.schedules.index') }}" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection