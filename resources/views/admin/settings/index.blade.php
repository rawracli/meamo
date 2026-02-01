@extends('admin.layouts.app')

@section('title', 'Pengaturan')
@section('header', 'Pengaturan Sistem')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-xl">
        <form action="{{ route('admin.settings.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Durasi Pemesanan (Menit)</label>
                <p class="text-sm text-gray-500 mb-2">Waktu yang dialokasikan untuk setiap slot pemesanan.</p>
                <input type="number" name="booking_duration_minutes"
                    value="{{ $settings['booking_duration_minutes'] ?? 10 }}" class="w-full border rounded px-3 py-2"
                    min="1" required>
            </div>

            <div class="flex justify-end gap-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Konfigurasi</button>
            </div>
        </form>
    </div>
@endsection