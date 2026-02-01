@extends('admin.layouts.app')

@section('title', 'Item')
@section('header', 'Kelola Item')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.items.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Item Baru
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($items as $item)
                    <tr>
                        <td class="px-6 py-4">{{ $item->id }}</td>
                        <td class="px-6 py-4 font-medium">{{ $item->name }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.items.edit', $item) }}" class="text-yellow-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.items.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Hapus item ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $items->links() }}
        </div>
    </div>
@endsection