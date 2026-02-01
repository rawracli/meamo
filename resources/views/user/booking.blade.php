@extends('user.layouts.dashboard')

@section('title', 'Pesan Sekarang')
@section('header', 'Pemesanan Baru')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri: Form Pemesanan --}}
        <div class="lg:col-span-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                    @csrf

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Layanan *</label>
                        <select id="service_select" name="service_id" class="w-full border rounded-lg px-4 py-3" required
                            onchange="updateForm()">
                            <option value="">-- Pilih Layanan --</option>
                            @foreach($services as $service)
                                {{-- Siapkan Data Item Yield --}}
                                @php
                                    $yieldData = $service->items->map(function ($item) {
                                        return ['name' => $item->name, 'quantity' => $item->pivot->quantity];
                                    });
                                @endphp
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}"
                                    data-addons="{{ $service->addons->pluck('id') }}"
                                    data-yield='{{ json_encode($yieldData) }}'>
                                    {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bagian Addon -->
                    <div id="addons_section" class="mb-6 hidden">
                        <label class="block mb-2 font-semibold">Tambahan</label>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($services->pluck('addons')->flatten()->unique('id') as $addon)
                                @php
                                    $addonYield = $addon->items->map(function ($item) {
                                        return ['name' => $item->name, 'quantity' => $item->pivot->quantity];
                                    });
                                @endphp
                                <div class="addon-item border rounded p-3 flex justify-between items-center"
                                    data-id="{{ $addon->id }}" data-yield='{{ json_encode($addonYield) }}'>
                                    <div class="flex items-center gap-3 flex-1">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $addon->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $addon->description }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-blue-600 font-semibold text-sm">Rp
                                            {{ number_format($addon->price, 0, ',', '.') }}</span>
                                        <div class="flex items-center border rounded">
                                            <button type="button" class="px-3 py-1 bg-gray-100 hover:bg-gray-200"
                                                onclick="updateQty(this, -1)">-</button>
                                            <input type="number" name="addons[{{ $addon->id }}]" value="0" min="0"
                                                class="w-12 text-center border-none p-1 focus:ring-0 addon-qty"
                                                data-price="{{ $addon->price }}" data-name="{{ $addon->name }}" readonly>
                                            <button type="button" class="px-3 py-1 bg-gray-100 hover:bg-gray-200"
                                                onclick="updateQty(this, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Jadwal *</label>
                        <select id="schedule_select" name="schedule_id" class="w-full border rounded-lg px-4 py-3" required
                            onchange="checkPromo()">
                            <option value="">-- Pilih Tanggal --</option>
                            @foreach($schedules as $schedule)
                                @php $isAvailable = $schedule->isAvailable(); @endphp
                                <option value="{{ $schedule->id }}" data-date="{{ $schedule->event_date->format('Y-m-d') }}" {{ !$isAvailable ? 'disabled' : '' }}
                                    class="{{ !$isAvailable ? 'text-gray-400 bg-gray-100' : '' }}">
                                    {{ $schedule->event_date->format('d F Y') }} ({{ $schedule->next_slot }})
                                    {{ !$isAvailable ? '(Penuh)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Kode Promo</label>
                        <div class="flex gap-2">
                            <input type="text" id="promo_code" name="promo_code"
                                class="w-full border rounded-lg px-4 py-3 uppercase" placeholder="Masukkan kode"
                                onchange="checkPromo()">
                            <button type="button" onclick="checkPromo('manual')"
                                class="bg-gray-200 px-4 rounded hover:bg-gray-300">Terapkan</button>
                        </div>
                        <p id="promo_message" class="text-sm mt-1"></p>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 font-semibold">Catatan</label>
                        <textarea name="notes" class="w-full border rounded-lg px-4 py-3"
                            placeholder="Catatan opsional..."></textarea>
                    </div>

                    <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700">
                        Kirim Pemesanan
                    </button>
                </form>
            </div>
        </div>

        {{-- Kolom Kanan: Ringkasan Pesanan --}}
        <div class="lg:col-span-1">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6 sticky top-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Ringkasan Pesanan</h3>

                <div id="summary_items" class="space-y-2 mb-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Layanan</span>
                        <span class="font-medium" id="summary_service">-</span>
                    </div>
                    <div id="summary_addons_list" class="space-y-1 pl-2 border-l-2 border-gray-100 mt-2">
                        <!-- Addon dimasukkan di sini -->
                    </div>
                </div>

                <!-- Bagian Ringkasan Hasil -->
                <div class="bg-gray-50 p-3 rounded mb-4 text-sm">
                    <h4 class="font-semibold text-gray-700 mb-2">Total Item (Hasil):</h4>
                    <ul id="yield_summary_list" class="list-disc list-inside text-gray-600 space-y-1">
                        <li>-</li>
                    </ul>
                </div>

                <div class="border-t pt-2 space-y-2">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span id="summary_subtotal">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-green-600 font-medium" id="summary_discount_row"
                        style="display:none;">
                        <span>Diskon <span id="promo_name_display" class="text-xs text-gray-500"></span></span>
                        <span id="summary_discount">- Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold text-gray-800 mt-2 pt-2 border-t">
                        <span>Total</span>
                        <span id="summary_total">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // State
        let currentPromo = null;

        function updateQty(btn, change) {
            const input = btn.parentNode.querySelector('input');
            let val = parseInt(input.value) || 0;
            val = Math.max(0, val + change);
            input.value = val;
            calculateTotal();
        }

        function updateForm() {
            const serviceSelect = document.getElementById('service_select');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const addonsSection = document.getElementById('addons_section');
            const addonItems = document.querySelectorAll('.addon-item');

            if (!selectedOption.value) {
                addonsSection.classList.add('hidden');
                checkPromo(); // Cek promo lagi karena layanan berubah
                calculateTotal();
                return;
            }

            // Tampilkan addon yang relevan
            const validAddons = JSON.parse(selectedOption.getAttribute('data-addons') || '[]');

            let hasAddons = false;
            addonItems.forEach(item => {
                const id = parseInt(item.getAttribute('data-id'));
                const input = item.querySelector('input');

                if (validAddons.includes(id)) {
                    item.classList.remove('hidden');
                    hasAddons = true;
                } else {
                    item.classList.add('hidden');
                    input.value = 0; // Reset addon tersembunyi
                }
            });

            if (hasAddons) {
                addonsSection.classList.remove('hidden');
            } else {
                addonsSection.classList.add('hidden');
            }

            checkPromo(); // Cek promo lagi karena layanan berubah
            calculateTotal();
        }

        function calculateTotal() {
            const serviceSelect = document.getElementById('service_select');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

            // Elemen Ringkasan
            const summaryService = document.getElementById('summary_service');
            const summaryAddonsList = document.getElementById('summary_addons_list');
            const summarySubtotal = document.getElementById('summary_subtotal');
            const summaryTotal = document.getElementById('summary_total');
            const summaryDiscountRow = document.getElementById('summary_discount_row');
            const summaryDiscount = document.getElementById('summary_discount');
            const yieldSummaryList = document.getElementById('yield_summary_list');

            let subtotal = 0;
            summaryAddonsList.innerHTML = ''; // Hapus daftar
            let totalYield = {};

            // Layanan Dasar
            if (selectedOption.value) {
                let price = parseFloat(selectedOption.getAttribute('data-price'));
                subtotal += price;
                summaryService.textContent = `${selectedOption.text.split('(')[0]} (Rp ${price.toLocaleString('id-ID')})`;

                // Hasil Layanan
                let serviceYield = JSON.parse(selectedOption.getAttribute('data-yield') || '[]');
                serviceYield.forEach(item => {
                    totalYield[item.name] = (totalYield[item.name] || 0) + item.quantity;
                });

            } else {
                summaryService.textContent = '-';
            }

            // Addon
            const addonInputs = document.querySelectorAll('.addon-qty');
            addonInputs.forEach(input => {
                let qty = parseInt(input.value) || 0;
                if (qty > 0) {
                    let price = parseFloat(input.getAttribute('data-price'));
                    let totalAddonPrice = price * qty;
                    subtotal += totalAddonPrice;

                    // Tambahkan ke ringkasan
                    let div = document.createElement('div');
                    div.className = 'flex justify-between text-xs text-gray-500';
                    div.innerHTML = `<span>+ ${input.getAttribute('data-name')} x${qty}</span><span>Rp ${totalAddonPrice.toLocaleString('id-ID')}</span>`;
                    summaryAddonsList.appendChild(div);

                    // Hasil Addon
                    let addonItemDiv = input.closest('.addon-item');
                    let addonYield = JSON.parse(addonItemDiv.getAttribute('data-yield') || '[]');
                    addonYield.forEach(item => {
                        totalYield[item.name] = (totalYield[item.name] || 0) + (item.quantity * qty);
                    });
                }
            });

            // Perbarui Tampilan Hasil
            yieldSummaryList.innerHTML = '';
            let hasYield = false;
            for (const [name, qty] of Object.entries(totalYield)) {
                let li = document.createElement('li');
                li.textContent = `${qty}x ${name}`;
                yieldSummaryList.appendChild(li);
                hasYield = true;
            }
            if (!hasYield) yieldSummaryList.innerHTML = '<li>-</li>';


            summarySubtotal.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

            // Diskon
            let discountAmount = 0;
            if (currentPromo) {
                if (currentPromo.discount_amount) {
                    discountAmount = parseFloat(currentPromo.discount_amount);
                } else if (currentPromo.discount_percentage) {
                    discountAmount = subtotal * (parseFloat(currentPromo.discount_percentage) / 100);
                }
                // Batasi pada subtotal
                discountAmount = Math.min(discountAmount, subtotal);
            }

            if (discountAmount > 0) {
                summaryDiscountRow.style.display = 'flex';
                summaryDiscount.textContent = '- Rp ' + discountAmount.toLocaleString('id-ID');
                document.getElementById('promo_name_display').textContent = `(${currentPromo.code})`;
            } else {
                summaryDiscountRow.style.display = 'none';
                document.getElementById('promo_name_display').textContent = '';
            }

            let total = subtotal - discountAmount;
            summaryTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        async function checkPromo(mode = 'auto') {
            const promoCodeInput = document.getElementById('promo_code');
            const serviceSelect = document.getElementById('service_select');
            const scheduleSelect = document.getElementById('schedule_select');
            const messageEl = document.getElementById('promo_message');

            const serviceId = serviceSelect.value;
            const scheduleId = scheduleSelect.value;
            const manualCode = promoCodeInput.value.trim();

            // Hapus pesan sebelumnya
            messageEl.textContent = '';

            // Hapus promo saat ini jika input tidak lengkap, kecuali hanya memeriksa kode manual
            if (!serviceId || !scheduleId) {
                currentPromo = null;
                calculateTotal();
                return;
            }

            const scheduleDate = scheduleSelect.options[scheduleSelect.selectedIndex].getAttribute('data-date');

            // Logika:
            // 1. Jika kode manual dimasukkan, validasi kode tersebut secara khusus.
            // 2. Jika TIDAK ada kode manual, periksa promo OTOMATIS.

            try {
                const response = await fetch('{{ route("api.check-promo") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        service_id: serviceId,
                        date: scheduleDate,
                        code: manualCode
                    })
                });

                const data = await response.json();

                if (data.valid && data.promo) {
                    currentPromo = data.promo;
                    if (mode === 'manual') {
                        messageEl.className = 'text-green-600 text-sm mt-1';
                        messageEl.textContent = 'Promo Diterapkan: ' + data.promo.code;
                        promoCodeInput.value = data.promo.code; // Isi kode otomatis jika ditemukan
                    } else {
                        // Mode otomatis: Hanya beritahu jika menemukan sesuatu dan pengguna tidak mengetik apapun
                        if (manualCode === '') {
                            promoCodeInput.value = data.promo.code;
                            messageEl.textContent = ''; // Jangan spam pesan sukses untuk otomatis
                        }
                    }
                } else {
                    currentPromo = null;
                    if (mode === 'manual' && manualCode !== '') {
                        messageEl.className = 'text-red-600 text-sm mt-1';
                        messageEl.textContent = 'Kode Promo tidak valid untuk tanggal/layanan yang dipilih.';
                    } else if (mode === 'auto' && manualCode !== '') {
                        // Jika ada kode manual tapi tidak valid untuk otomatis, hapus.
                        // Ini mencegah kode manual yang tidak valid bertahan jika pengguna mengubah layanan/tanggal.
                        promoCodeInput.value = '';
                    }
                }

                calculateTotal();

            } catch (error) {
                console.error('Error Pemeriksaan Promo', error);
                messageEl.className = 'text-red-600 text-sm mt-1';
                messageEl.textContent = 'Terjadi kesalahan saat memeriksa promo.';
            }
        }

        // Panggilan awal
        document.addEventListener('DOMContentLoaded', () => {
            updateForm(); // Ini juga akan memanggil calculateTotal dan checkPromo
        });
    </script>
@endsection