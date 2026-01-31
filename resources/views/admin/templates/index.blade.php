@extends('admin.layouts.app')

@section('title', 'Templates')
@section('header', 'Manage Templates')

@section('content')

{{-- TOP BAR: ACTION LEFT, FILTER RIGHT --}}
<div class="mb-6 flex items-center justify-between flex-wrap gap-4">
    {{-- LEFT: ACTION BUTTONS --}}
    <div class="flex gap-2">
        <a href="{{ route('admin.templates.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Tambah Template
        </a>

        <a href="{{ route('admin.template-categories.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
            Kelola Kategori
        </a>
    </div>

    {{-- RIGHT: FILTER --}}
    <form method="GET" class="flex items-center gap-2">
        <label class="text-sm text-gray-600">
            Filter:
        </label>

        <select name="category"
                class="pl-3 pr-9 py-1 text-sm border rounded-md"
                onchange="this.form.submit()">
            <option value="">Semua</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        @if(request('category'))
            <a href="{{ route('admin.templates.index') }}"
               class="text-sm text-gray-500 underline">
                Reset
            </a>
        @endif
    </form>
</div>

{{-- GRID TEMPLATES --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @forelse($templates as $template)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <img src="{{ asset('storage/' . $template->image) }}"
                 alt="{{ $template->name }}"
                 class="w-full h-48 object-cover">

            <div class="p-4">
                <h3 class="font-semibold text-gray-800 truncate">
                    {{ $template->name }}
                </h3>

                <p class="text-xs text-gray-500 mb-2">
                    {{ $template->category?->name ?? '-' }}
                </p>

                @if($template->description)
                    <p class="text-sm text-gray-700 mb-3 line-clamp-2">
                        {{ $template->description }}
                    </p>
                @endif

                <div class="flex items-center justify-between">
                    <span class="text-xs px-2 py-1 rounded
                        {{ $template->status
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' }}">
                        {{ $template->status ? 'Active' : 'Inactive' }}
                    </span>

                    <form action="{{ route('admin.templates.destroy', $template) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:underline text-sm"
                                onclick="return confirm('Yakin hapus template ini?')">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="col-span-full text-center text-gray-500">
            Template tidak ditemukan.
        </p>
    @endforelse
</div>

{{-- PAGINATION --}}
<div class="mt-6">
    {{ $templates->links() }}
</div>

@endsection
