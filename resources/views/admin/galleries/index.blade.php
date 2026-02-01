@extends('admin.layouts.app')

@section('title', 'Galeri')
@section('header', 'Kelola Galeri')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.galleries.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Unggah Foto
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($galleries as $gallery)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" class="w-full h-48 object-cover">

                <div class="p-4">
                    @if($gallery->caption)
                        <p class="text-sm text-gray-700 mb-2">{{ $gallery->caption }}</p>
                    @endif

                    <form action="{{ route('admin.galleries.destroy', $gallery) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline text-sm" onclick="return confirm('Apakah Anda yakin?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $galleries->links() }}
    </div>
@endsection