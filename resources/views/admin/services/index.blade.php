@extends('admin.layouts.app')

@section('title', 'Layanan')
@section('header', 'Kelola Layanan')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.services.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Tambah Layanan
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($services as $service)
                    <tr>
                        <td class="px-6 py-4">{{ $service->name }}</td>
                        <td class="px-6 py-4">
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.services.edit', $service) }}"
                                class="text-blue-600 hover:underline mr-3">Edit</a>

                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline"
                                    onclick="return confirm('Apakah Anda yakin?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $services->links() }}
    </div>
@endsection