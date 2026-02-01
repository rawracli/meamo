@extends('admin.layouts.app')

@section('title', 'Buat Item')
@section('header', 'Tambah Item Baru')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-md">
        <form action="{{ route('admin.items.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Nama Item</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2"
                    placeholder="cth. Foto Strip, Gantungan Kunci" required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.items.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection