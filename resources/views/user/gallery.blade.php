@extends('user.layouts.app')

@section('title', 'Galeri')

@section('content')
    <section class="py-16 max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-12">Galeri Kami</h1>

        <div class="grid md:grid-cols-4 gap-4">
            @foreach($galleries as $gallery)
                <div class="relative overflow-hidden rounded-lg aspect-square">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}"
                        class="w-full h-full object-cover hover:scale-110 transition">
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $galleries->links() }}
        </div>
    </section>
@endsection