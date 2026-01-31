@extends('admin.layouts.app')

@section('title', 'Tambah Template')
@section('header', 'Tambah Template')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form action="{{ route('admin.templates.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama Template</label>
            <input type="text" name="name"
                   value="{{ old('name') }}"
                   class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Kategori</label>
            <select name="template_category_id"
                    class="w-full px-3 py-2 border rounded" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('template_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Preview Template</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description"
                      class="w-full px-3 py-2 border rounded"
                      rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-6 flex items-center gap-2">
            <input type="checkbox" name="status" value="1" checked>
            <span class="text-gray-700">Aktif</span>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('admin.templates.index') }}"
               class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
