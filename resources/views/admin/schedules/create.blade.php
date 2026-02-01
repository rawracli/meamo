@extends('admin.layouts.app')

@section('title', 'Tambah Jadwal')
@section('header', 'Tambah Jadwal Baru')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Tanggal Acara</label>
                <input type="date" name="event_date" value="{{ old('event_date') }}"
                    class="w-full px-3 py-2 border rounded @error('event_date') border-red-500 @enderror" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Waktu Mulai</label>
                <input type="time" name="start_time" value="{{ old('start_time') }}"
                    class="w-full px-3 py-2 border rounded @error('start_time') border-red-500 @enderror" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Waktu Selesai</label>
                <input type="time" name="end_time" value="{{ old('end_time') }}"
                    class="w-full px-3 py-2 border rounded @error('end_time') border-red-500 @enderror" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-3 py-2 border rounded" required>
                    <option value="available">Tersedia</option>
                    <option value="booked">Dipesan</option>
                    <option value="unavailable">Tidak Tersedia</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan
                </button>
                <a href="{{ route('admin.schedules.index') }}" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection