@extends('user.layouts.app')

@section('title', 'Kontak')

@section('content')
    <section class="py-16 max-w-4xl mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-12">Hubungi Kami</h1>

        <div class="bg-white shadow rounded-lg p-8 text-center">
            <p class="mb-4">Email: info@meamo.com</p>
            <p class="mb-4">Telepon: +62 812-3456-7890</p>

            <a href="https://wa.me/6281234567890" class="inline-block bg-green-500 text-white px-6 py-3 rounded-lg">
                Chat via WhatsApp
            </a>
        </div>
    </section>
@endsection