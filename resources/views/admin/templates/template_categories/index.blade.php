@extends('admin.layouts.app')

@section('title', 'Kategori Template')
@section('header', 'Kelola Kategori Template')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.template-categories.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
        Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Nama Kategori</th>
                <th class="px-4 py-2 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr class="border-t">
                    <td class="px-4 py-2">
                        {{ $category->name }}
                    </td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('admin.template-categories.edit', $category) }}"
                           class="text-blue-600 hover:underline text-sm">
                            Edit
                        </a>

                        <form action="{{ route('admin.template-categories.destroy', $category) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline text-sm ml-2"
                                    onclick="return confirm('Hapus kategori ini?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-4 py-6 text-center text-gray-500">
                        Belum ada kategori.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection
