@extends('admin.layouts.app')

@section('title', 'Edit Kategori')
@section('header', 'Edit Kategori Template')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-lg">
        <form action="{{ route('admin.template-categories.update', $templateCategory) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">
                    Nama Kategori
                </label>

                <input type="text" name="name" value="{{ old('name', $templateCategory->name) }}" class="w-full px-3 py-2 border rounded
                              @error('name') border-red-500 @enderror" required>

                @error('name')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Perbarui
                </button>

                <a href="{{ route('admin.template-categories.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection