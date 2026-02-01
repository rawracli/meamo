@extends('admin.layouts.app')

@section('title', 'Buat Promo')
@section('header', 'Tambah Promo Baru')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.promos.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Kode Promo *</label>
                    <input type="text" name="code" class="w-full border rounded px-3 py-2 uppercase"
                        placeholder="cth. DISKON25" required>
                    @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Cakupan Layanan</label>
                    <select name="service_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- Terapkan ke Semua Layanan --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Jenis Diskon *</label>
                    <select name="discount_type" class="w-full border rounded px-3 py-2">
                        <option value="fixed">Jumlah Tetap (Rp)</option>
                        <option value="percentage">Persentase (%)</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Nilai Diskon *</label>
                    <input type="number" name="discount_value" class="w-full border rounded px-3 py-2" min="0" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Tanggal Mulai *</label>
                    <input type="date" name="start_date" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Tanggal Berakhir *</label>
                    <input type="date" name="end_date" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Kuota (Kosong untuk Tak Terbatas)</label>
                    <input type="number" name="quota" class="w-full border rounded px-3 py-2" min="0">
                </div>
                <div class="flex items-center mt-8">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="checkbox" name="is_auto" class="form-checkbox h-5 w-5 text-blue-600" value="1">
                        <span class="font-semibold">Terapkan Otomatis?</span>
                    </label>
                    <p class="text-xs text-gray-500 ml-4">Jika dicentang, promo ini akan diterapkan otomatis tanpa
                        memasukkan
                        kode.</p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Deskripsi</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" rows="2"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.promos.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan Promo</button>
            </div>
        </form>
    </div>
@endsection