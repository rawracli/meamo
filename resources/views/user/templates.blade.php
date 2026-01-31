@extends('user.layouts.app')

@section('title', 'Templates')

@section('content')
<section class="py-16 max-w-7xl mx-auto px-4">
    <h1 class="text-4xl font-bold text-center mb-8">
        Our Templates
    </h1>

    {{-- FILTER --}}
    <form method="GET" class="flex justify-center mb-10">
        <select name="category"
                onchange="this.form.submit()"
                class="pl-4 pr-9 py-2 border rounded-lg">
            <option value="">Semua Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- GRID TEMPLATE --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @forelse($templates as $template)
            <div class="group relative bg-white rounded-xl overflow-hidden shadow">
                <div class="aspect-square overflow-hidden">
                    <img src="{{ asset('storage/' . $template->image) }}"
                         alt="{{ $template->name }}"
                         class="w-full h-full object-cover
                                group-hover:scale-110 transition duration-300">
                </div>

                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 truncate">
                        {{ $template->name }}
                    </h3>

                    <p class="text-xs text-gray-500 mt-1">
                        {{ $template->category?->name ?? 'Tanpa Kategori' }}
                    </p>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">
                Template tidak ditemukan.
            </p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $templates->links() }}
    </div>
</section>
@endsection
