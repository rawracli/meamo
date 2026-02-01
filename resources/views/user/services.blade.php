@extends('user.layouts.app')

@section('title', 'Layanan')

@section('content')
    <section class="py-16 max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-12">Layanan Kami</h1>

        <div class="grid md:grid-cols-2 gap-8">
            @foreach($services as $service)
                <div class="bg-white shadow rounded-lg p-8">
                    <h2 class="text-2xl font-bold mb-4">{{ $service->name }}</h2>
                    <p class="text-gray-600 mb-6">{{ $service->description }}</p>
                    <div class="flex justify-between items-center">
                        <p class="text-3xl font-bold text-blue-600">
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </p>
                        <a href="{{ route('booking.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection