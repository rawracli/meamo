@extends('admin.layouts.app')

@section('title', 'Edit Tambahan')
@section('header', 'Edit Tambahan Layanan')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl">
        <form action="{{ route('admin.service-addons.update', $serviceAddon) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 font-semibold">Nama Tambahan *</label>
                    <input type="text" name="name" value="{{ old('name', $serviceAddon->name) }}" class="w-full border rounded px-3 py-2" required>
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-2 font-semibold">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', $serviceAddon->price) }}" class="w-full border rounded px-3 py-2" min="0" required>
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Deskripsi</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" rows="2">{{ old('description', $serviceAddon->description) }}</textarea>
            </div>

            <div class="mb-6 border-t pt-4">
                <label class="block mb-4 font-semibold text-lg">Hasil Item (Output)</label>
                <p class="text-sm text-gray-500 mb-4">Pilih item mana yang diberikan tambahan ini kepada pelanggan.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($items as $index => $item)
                        @php
                            $relatedItem = $serviceAddon->items->find($item->id);
                            $isChecked = $relatedItem ? true : false;
                            $quantity = $relatedItem ? $relatedItem->pivot->quantity : 1;
                        @endphp
                        <div class="border rounded p-3 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" name="items[{{ $index }}][id]" value="{{ $item->id }}" 
                                    class="form-checkbox h-5 w-5 text-blue-600 item-checkbox"
                                    onchange="toggleQuantity(this, {{ $index }})"
                                    {{ $isChecked ? 'checked' : '' }}>
                                <span>{{ $item->name }}</span>
                            </div>
                            <input type="number" name="items[{{ $index }}][quantity]" 
                                id="qty_{{ $index }}"
                                class="w-16 border rounded px-2 py-1 text-center" 
                                value="{{ $quantity }}" min="1" 
                                {{ $isChecked ? '' : 'disabled' }}>
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                function toggleQuantity(checkbox, index) {
                    const qtyInput = document.getElementById('qty_' + index);
                    if (checkbox.checked) {
                        qtyInput.disabled = false;
                    } else {
                        qtyInput.disabled = true;
                    }
                }
            </script>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.service-addons.index') }}" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui Tambahan</button>
            </div>
        </form>
    </div>
@endsection
