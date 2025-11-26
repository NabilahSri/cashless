@extends('template')

@push('styles')
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }

        /* Custom focus styles */
        input:focus,
        select:focus,
        textarea:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }
    </style>
@endpush

@section('content')
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    @if ($mode != 'cek_saldo')
                        Tambah Data
                    @endif {{ $pageName }}
                </h3>
            </div>

            <div class="py-5 space-y-4 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

                @if (!$member)
                    <div x-data="qrScanner('{{ $activeSearchTab ?? 'card' }}')" x-init="initAutoNfc()" class="mb-4">
                        <div class="border-b border-gray-200 dark:border-gray-700">
                            <nav class="-mb-px flex gap-x-6" aria-label="Tabs">
                                <button
                                    @click="activeTab = 'card'; resetForm(); $nextTick(() => { document.getElementById('cardUid') && document.getElementById('cardUid').focus(); stopQRScanner(); if (isNfcSupported) startNfcScan(); })"
                                    :class="activeTab === 'card' ?
                                        'border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400' :
                                        'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium transition-colors duration-200">
                                    <i class="fa-solid fa-id-card mr-2"></i>
                                    Tap Kartu
                                </button>

                                @if (!isset($mode) || $mode !== 'cek_saldo')
                                    <button @click="activeTab = 'qr'; resetForm(); $nextTick(() => startQRScanner())"
                                        :class="activeTab === 'qr' ?
                                            'border-blue-500 text-blue-600 dark:border-blue-400 dark:text-blue-400' :
                                            'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                                        class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium transition-colors duration-200">
                                        <i class="fa-solid fa-qrcode mr-2"></i>
                                        Scan QR
                                    </button>
                                @endif
                            </nav>
                        </div>

                        <div class="py-4">
                            <div x-show="activeTab === 'card'" style="display: none;"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0">
                                <form id="cardForm" action="{{ route('transaction.create') }}" method="GET">
                                    <input type="hidden" name="searchType" value="card">
                                    @if (isset($mode) && $mode)
                                        <input type="hidden" name="mode" value="{{ $mode }}">
                                    @endif

                                    <div
                                        class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                                        <div class="text-center">
                                            <div
                                                class="w-16 h-16 mx-auto mb-4 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                                                <i
                                                    class="fa-solid fa-id-card text-2xl text-blue-600 dark:text-blue-400"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                                                Tempelkan Kartu
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                Tempelkan kartu member Anda di reader RFID
                                            </p>

                                            <div class="relative">
                                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                                    <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                                                </div>
                                                <div class="relative flex justify-center">
                                                    <span
                                                        class="bg-white dark:bg-gray-800 px-3 text-sm text-gray-500 dark:text-gray-400">
                                                        Akan terbaca otomatis
                                                    </span>
                                                </div>
                                            </div>

                                            <input type="password" id="cardUid" name="cardUid" x-ref="cardInput"
                                                placeholder="Kartu akan terbaca otomatis..."
                                                oninput="if(this.value.length === 11) { this.form.submit(); }"
                                                class="mt-4 w-full text-center text-lg font-mono bg-white dark:bg-gray-800 border-2 border-dashed border-blue-300 dark:border-blue-600 rounded-lg py-4 px-4 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200"
                                                autocomplete="off" autofocus>
                                            <div
                                                class="mt-2 flex items-center justify-center text-sm text-blue-600 dark:text-blue-400">
                                                <i class="fa-solid fa-circle-info mr-1"></i>
                                                <span>Tempelkan kartu dan tunggu</span>
                                            </div>
                                        </div>
                                    </div>
                                    @error('cardUid')
                                        <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                    <div class="mt-4 flex justify-center">
                                        <template x-if="isNfcSupported">
                                            <button type="button" @click="startNfcScan()"
                                                class="rounded-lg bg-green-600 px-6 py-2 text-sm font-medium text-white hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-400 transition-colors duration-200 flex items-center">
                                                <i class="fa-solid fa-wave-square mr-2"></i>
                                                Scan via NFC (Mobile)
                                            </button>
                                        </template>
                                    </div>
                                </form>
                            </div>

                            @if (!isset($mode) || $mode !== 'cek_saldo')
                                <div x-show="activeTab === 'qr'" style="display: none;"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0">
                                    <form id="qrForm" action="{{ route('transaction.create') }}" method="GET">
                                        <input type="hidden" name="searchType" value="qr">
                                        <input type="hidden" id="qrCode" name="qrCode" value="">
                                        @if (isset($mode) && $mode)
                                            <input type="hidden" name="mode" value="{{ $mode }}">
                                        @endif
                                    </form>

                                    <div
                                        class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6 border border-purple-200 dark:border-purple-800">
                                        <div class="text-center">
                                            <div
                                                class="w-16 h-16 mx-auto mb-4 bg-purple-100 dark:bg-purple-800 rounded-full flex items-center justify-center">
                                                <i
                                                    class="fa-solid fa-qrcode text-2xl text-purple-600 dark:text-purple-400"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                                                Scan QR Code
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                Arahkan kamera ke QR Code member
                                            </p>

                                            <div id="qr-reader"
                                                class="mt-2 mx-auto w-full max-w-xs rounded-lg border-2 border-dashed border-purple-300 dark:border-purple-600 bg-white dark:bg-gray-800 overflow-hidden">
                                            </div>

                                            <template x-if="!isScanning">
                                                <button type="button" @click="startQRScanner()"
                                                    class="mt-4 rounded-lg bg-purple-600 px-6 py-3 text-sm font-medium text-white hover:bg-purple-700 dark:bg-purple-500 dark:hover:bg-purple-400 transition-colors duration-200 flex items-center justify-center mx-auto">
                                                    <i class="fa-solid fa-camera mr-2"></i>
                                                    Mulai Scan QR
                                                </button>
                                            </template>

                                            <template x-if="isScanning">
                                                <button type="button" @click="stopQRScanner()"
                                                    class="mt-4 rounded-lg bg-red-600 px-6 py-3 text-sm font-medium text-white hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-400 transition-colors duration-200 flex items-center justify-center mx-auto">
                                                    <i class="fa-solid fa-square-stop mr-2"></i>
                                                    Hentikan Scan
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20 animate-pulse">
                        <div class="flex items-center">
                            <i class="fa-solid fa-circle-exclamation text-red-500 mr-3 text-lg"></i>
                            <div>
                                <span class="text-red-700 dark:text-red-400 font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($member)
                    <div class=" mb-3">
                        <a href="{{ isset($mode) && $mode ? route('transaction.create', ['mode' => $mode]) : route('transaction.create') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                    <div id="member-data-card"
                        class="rounded-xl border border-green-200 bg-green-50 dark:border-green-800 dark:bg-green-900/20 p-6 animate-fade-in">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-800 dark:text-white flex items-center">
                                    <i class="fa-solid fa-user-check text-green-600 mr-2"></i>
                                    Data Member Ditemukan
                                </h4>
                                <dl class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                                    <div class="flex flex-col">
                                        <dt class="text-gray-500 dark:text-gray-400">Nama:</dt>
                                        <dd class="dark:text-white font-medium">{{ $member->name }}</dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="text-gray-500 dark:text-gray-400">No. Member:</dt>
                                        <dd class="dark:text-white font-medium">{{ $member->member_no }}</dd>
                                    </div>
                                </dl>
                                @if ($limitInfo && $limitInfo['limit_type'] != 'no_limit')
                                    <div class="mt-4">
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-500 dark:text-gray-400">Limit:</span>
                                                <div class="font-semibold text-gray-800 dark:text-white">
                                                    Rp {{ number_format($limitInfo['limit_amount'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div>
                                                <span class="text-gray-500 dark:text-gray-400">Terpakai:</span>
                                                <div class="font-semibold text-gray-800 dark:text-white">
                                                    Rp {{ number_format($limitInfo['used_amount'], 0, ',', '.') }}
                                                </div>
                                            </div>
                                            <div class="col-span-2">
                                                <span class="text-gray-500 dark:text-gray-400">Sisa Limit:</span>
                                                <div
                                                    class="font-bold text-lg
                                            @if ($limitInfo['is_exceeded']) text-red-600 dark:text-red-400
                                            @elseif($limitInfo['remaining_limit'] < $limitInfo['limit_amount'] * 0.2)
                                                text-orange-600 dark:text-orange-400
                                            @else
                                                text-green-600 dark:text-green-400 @endif">
                                                    Rp {{ number_format($limitInfo['remaining_limit'], 0, ',', '.') }}
                                                </div>
                                                @if ($limitInfo['is_exceeded'])
                                                    <div class="text-red-500 text-xs mt-1 flex items-center">
                                                        <i class="fa-solid fa-exclamation-triangle mr-1"></i>
                                                        Limit telah tercapai!
                                                    </div>
                                                @elseif($limitInfo['remaining_limit'] < $limitInfo['limit_amount'] * 0.2)
                                                    <div class="text-orange-500 text-xs mt-1 flex items-center">
                                                        <i class="fa-solid fa-info-circle mr-1"></i>
                                                        Limit hampir habis
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="mt-2">
                                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                                @php
                                                    $percentage =
                                                        $limitInfo['limit_amount'] > 0
                                                            ? min(
                                                                100,
                                                                ($limitInfo['used_amount'] /
                                                                    $limitInfo['limit_amount']) *
                                                                    100,
                                                            )
                                                            : 0;
                                                    $progressColor =
                                                        $percentage >= 100
                                                            ? 'bg-red-500'
                                                            : ($percentage >= 80
                                                                ? 'bg-orange-500'
                                                                : 'bg-blue-500');
                                                @endphp
                                                <div class="h-2 rounded-full {{ $progressColor }} transition-all duration-300"
                                                    style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                @elseif($limitInfo && $limitInfo['limit_type'] == 'unlimited')
                                    <div
                                        class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center text-blue-600 dark:text-blue-400">
                                            <i class="fa-solid fa-infinity mr-2"></i>
                                            <span class="font-medium">Tidak ada limit transaksi</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div
                                class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-check text-green-600 dark:text-green-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    @if (
                        (($cekDefault && $cekDefault->status == 1) ||
                            ($cekDefault && $cekDefault->status != 1 && !$limitInfo['is_exceeded'])) &&
                            $mode !== 'cek_saldo')
                        <form id="transaction-form" action="{{ route('transaction.store') }}" method="POST"
                            class="space-y-6 pt-4">
                            @csrf
                            <input type="hidden" name="memberId" value="{{ $member->member_no }}">
                            @if ($qrCodeToken)
                                <input type="hidden" name="qrToken" value="{{ $qrCodeToken }}">
                            @endif

                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                                <label for="nominal_display"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <i class="fa-solid fa-money-bill-wave mr-2"></i>
                                    Nominal Transaksi
                                </label>
                                <input type="text" id="nominal_display" placeholder="Contoh: Rp 50.000"
                                    inputmode="numeric" autocomplete="off"
                                    class="w-full text-3xl font-bold rounded-lg border-2 border-gray-300 dark:border-gray-600 py-6 px-4 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 dark:bg-gray-700 dark:text-white"
                                    @if (isset($prefilledNominal)) value="{{ 'Rp ' . number_format($prefilledNominal, 0, ',', '.') }}" readonly @endif
                                    autofocus>
                                <input type="hidden" id="nominal" name="nominal"
                                    value="{{ isset($prefilledNominal) ? $prefilledNominal : old('nominal') }}" />
                                @error('nominal')
                                    <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                                @enderror
                                {{-- rekomendas harga --}}
                                <div class="mt-4 flex flex-wrap gap-3"
                                    @if (isset($prefilledNominal)) style="display:none" @endif>
                                    @if (!empty($recommendations))
                                        @foreach ($recommendations as $rec)
                                            <button type="button" data-amount="{{ $rec }}"
                                                class="nominal-recom-btn text-xs px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900 transition-colors">
                                                {{ 'Rp ' . number_format($rec, 0, ',', '.') }}
                                            </button>
                                        @endforeach
                                    @else
                                    @endif
                                </div>
                            </div>

                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                                <label for="deskripsi"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                    <i class="fa-solid fa-file-lines mr-2"></i>
                                    Deskripsi (Opsional)
                                </label>
                                <textarea id="deskripsi" name="deskripsi" rows="3"
                                    placeholder="Contoh: Pembelian produk, Top up saldo, dll..."
                                    class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 py-3 px-4 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 dark:bg-gray-700 dark:text-white">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($member->status_pin == 'active')
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                                    <label for="pin"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                        <i class="fa-solid fa-lock mr-2"></i>
                                        PIN Member
                                    </label>
                                    <input type="password" id="pin" name="pin"
                                        placeholder="Masukkan  PIN member"
                                        class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 py-3 px-4 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 dark:bg-gray-700 dark:text-white"
                                        required>
                                    @error('pin')
                                        <span class="text-sm text-red-500 mt-2 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="submit"
                                    class="rounded-xl bg-green-600 px-8 py-3 text-sm font-medium text-white hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-400 transition-colors duration-200 flex items-center shadow-lg shadow-green-200 dark:shadow-green-900/30">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                                    Simpan Transaksi
                                </button>
                            </div>
                        </form>
                    @endif

                    @if ($mode === 'cek_saldo')
                        <div id="pin_check_card"
                            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mt-4">
                            <label for="pin_check"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                <i class="fa-solid fa-lock mr-2"></i>
                                Masukkan PIN Member untuk melihat saldo
                            </label>
                            <form id="pin-check-form" action="{{ route('transaction.checkBalance') }}" method="GET"
                                class="flex gap-3 items-center">
                                <input type="password" id="pin_check" name="pin" placeholder="Masukkan PIN"
                                    class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 py-3 px-4 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-800 transition-all duration-200 dark:bg-gray-700 dark:text-white"
                                    required>
                                <input type="hidden" name="mode" value="cek_saldo">
                                @if (!empty($memberId))
                                    <input type="hidden" name="memberId" value="{{ $memberId }}">
                                    <input type="hidden" name="searchType" value="member">
                                @elseif(!empty($cardUid))
                                    <input type="hidden" name="cardUid" value="{{ $cardUid }}">
                                    <input type="hidden" name="searchType" value="card">
                                @endif
                                <button type="submit"
                                    class="rounded-lg bg-blue-600 px-6 py-3 text-sm font-medium text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400 transition-colors duration-200 flex items-center">
                                    <i class="fa-solid fa-eye mr-2"></i>
                                    Tampilkan Saldo
                                </button>
                            </form>
                            <div id="pin_error" class="text-sm text-red-500 mt-2"></div>
                        </div>

                        @php $showBalance = !empty($pinValid) && $pinValid; @endphp
                        <div id="balance_card"
                            class="rounded-xl border border-blue-200 bg-blue-50 dark:border-blue-800 dark:bg-blue-900/20 p-6 animate-fade-in mt-4"
                            @if (!$showBalance) style="display:none" @endif>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-wallet text-2xl text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 dark:text-white">Saldo Member</h4>
                                    <div class="mt-1 flex items-center gap-3">
                                        <div id="balance_value"
                                            class="text-3xl font-extrabold text-blue-700 dark:text-blue-300">
                                            @if ($showBalance)
                                                Rp {{ number_format($walletBalance ?? 0, 0, ',', '.') }}
                                            @endif
                                        </div>
                                        <button id="balance_toggle" type="button"
                                            class="rounded-md border border-blue-300 dark:border-blue-600 px-3 py-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30">
                                            <i class="fa-solid fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                @endif

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nominalDisplay = document.getElementById('nominal_display');
            const nominalHidden = document.getElementById('nominal');
            const recomButtons = document.querySelectorAll('.nominal-recom-btn');

            if (nominalDisplay && nominalHidden) {
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });

                function handleInput(e) {
                    let rawValue = e.target.value.replace(/\D/g, '');
                    nominalHidden.value = rawValue;
                    if (rawValue) {
                        e.target.value = formatter.format(parseInt(rawValue, 10));
                    } else {
                        e.target.value = '';
                    }
                }
                nominalDisplay.addEventListener('input', handleInput);

                recomButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const amount = this.getAttribute(
                            'data-amount'); // Mengambil nilai angka dari data-amount
                        const numericAmount = parseInt(amount, 10);

                        // Mengisi input hidden dengan nilai angka murni
                        nominalHidden.value = numericAmount;

                        // Mengisi input display dengan nilai terformat
                        nominalDisplay.value = formatter.format(numericAmount);

                        // Opsional: Langsung fokus kembali ke input display setelah tombol diklik
                        nominalDisplay.focus();
                    });
                });

                // Format existing value if any
                if (nominalHidden.value) {
                    nominalDisplay.value = formatter.format(parseInt(nominalHidden.value, 10));
                }
            }

            // Auto-focus on card input when tab is active
            @if (!$member)
                setTimeout(() => {
                    const cardInput = document.getElementById('cardUid');
                    if (cardInput) {
                        cardInput.focus();
                    }
                }, 500);
            @endif

            // Auto-focus nominal field if member data is present
            @if ($member)
                setTimeout(() => {
                    const nominalDisplay = document.getElementById('nominal_display');
                    if (nominalDisplay) {
                        nominalDisplay.focus();
                        nominalDisplay.select();
                    }
                }, 300);
            @endif

            const pinForm = document.getElementById('pin-check-form');
            const pinCard = document.getElementById('pin_check_card');
            const balanceCard = document.getElementById('balance_card');
            const balanceValue = document.getElementById('balance_value');
            const pinError = document.getElementById('pin_error');
            const balanceToggle = document.getElementById('balance_toggle');
            let balanceOriginal = balanceValue ? balanceValue.textContent.trim() : '';
            let balanceHidden = true;
            if (balanceValue && balanceOriginal) {
                balanceValue.textContent = '••••••••';
            }
            if (balanceToggle) {
                balanceToggle.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
            }
            if (balanceToggle && balanceValue) {
                balanceToggle.addEventListener('click', function() {
                    if (!balanceHidden) {
                        balanceOriginal = balanceValue.textContent.trim();
                        balanceValue.textContent = '••••••••';
                        balanceToggle.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
                        balanceHidden = true;
                    } else {
                        balanceValue.textContent = balanceOriginal;
                        balanceToggle.innerHTML = '<i class="fa-solid fa-eye"></i>';
                        balanceHidden = false;
                    }
                });
            }
            if (pinForm) {
                pinForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    if (pinError) pinError.textContent = '';
                    const params = new URLSearchParams(new FormData(pinForm));
                    try {
                        const res = await fetch(pinForm.action + '?' + params.toString(), {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json'
                            },
                            credentials: 'same-origin'
                        });
                        let data;
                        const ct = res.headers.get('content-type') || '';
                        if (ct.includes('application/json')) {
                            data = await res.json();
                        } else {
                            const text = await res.text();
                            // coba parse jika server mengirim json tanpa header yang tepat
                            try {
                                data = JSON.parse(text);
                            } catch (_) {
                                data = null;
                            }
                        }
                        if (data && data.success) {
                            if (balanceValue) {
                                const f = new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                });
                                const formatted = f.format(parseInt(data.balance, 10));
                                balanceOriginal = formatted;
                                balanceValue.textContent = balanceHidden ? '••••••••' : formatted;
                            }
                            if (pinCard) pinCard.style.display = 'none';
                            if (balanceCard) balanceCard.style.display = 'block';
                        } else {
                            const msg = (data && data.error) ? data.error : (res.ok ?
                                'Gagal verifikasi PIN' : 'Permintaan gagal');
                            if (pinError) pinError.textContent = msg;
                        }
                    } catch (err) {
                        if (pinError) pinError.textContent = 'Koneksi gagal';
                    }
                });
            }
        });

        // ==========================================================
        // PERBAIKAN: Fungsi resetForm() kini menghilangkan data member
        // dan form transaksi saat perpindahan tab.
        // ==========================================================
        function qrScanner(initialTab) {
            return {
                html5QrCode: null,
                isScanning: false,
                activeTab: initialTab,
                isNfcSupported: typeof NDEFReader !== 'undefined',
                isScanningNfc: false,
                nfcResult: '',
                autoNfc: JSON.parse(localStorage.getItem('autoNfc') || 'false'),

                // Fungsi untuk mereset form dan menghilangkan tampilan data member
                resetForm() {
                    // --- START PERBAIKAN PENTING ---

                    // 1. Manipulasi URL: Hapus parameter pencarian untuk membuat $member menjadi null
                    const url = new URL(window.location);
                    url.searchParams.delete('searchType');
                    url.searchParams.delete('cardUid');
                    url.searchParams.delete('qrCode');

                    // Ganti URL di address bar tanpa reload halaman
                    history.replaceState(null, '', url);

                    // 2. Hilangkan tampilan Data Member (hijau) dan Form Transaksi secara instan
                    const memberCard = document.getElementById('member-data-card');
                    const transactionForm = document.getElementById('transaction-form');

                    if (memberCard) {
                        memberCard.style.display = 'none';
                    }
                    if (transactionForm) {
                        transactionForm.style.display = 'none';
                    }

                    // --- END PERBAIKAN PENTING ---

                    // Clear form fields
                    const cardForm = document.getElementById('cardForm');
                    if (cardForm) {
                        cardForm.reset();
                    }

                    const qrForm = document.getElementById('qrForm');
                    if (qrForm) {
                        qrForm.reset();
                        document.getElementById('qrCode').value = '';
                    }

                    // Stop scanner if it's running
                    if (this.html5QrCode && this.isScanning) {
                        this.stopQRScanner();
                    }
                },

                // QR Scanner start function
                startQRScanner() {
                    const qrReaderDiv = document.getElementById('qr-reader');
                    if (!qrReaderDiv) return;

                    // Clear previous scanner
                    if (this.html5QrCode) {
                        this.html5QrCode.clear();
                    }

                    qrReaderDiv.innerHTML = '';
                    this.html5QrCode = new Html5Qrcode("qr-reader");
                    this.isScanning = true;

                    this.html5QrCode.start({
                            facingMode: "environment"
                        }, {
                            fps: 10,
                            qrbox: {
                                width: 250,
                                height: 250
                            }
                        },
                        (decodedText) => {
                            console.log('Scan berhasil, mencari data member...');
                            this.onScanSuccess(decodedText);
                        },
                        (error) => {
                            // Keep scanner running on failure
                        }
                    ).catch(err => {
                        qrReaderDiv.innerHTML = `
                            <div class="p-4 text-red-600 text-center">
                                <i class="fa-solid fa-triangle-exclamation text-2xl mb-2"></i>
                                <p>Gagal memulai kamera</p>
                                <p class="text-sm">${err}</p>
                            </div>`;
                        this.isScanning = false;
                    });
                },

                // QR Scanner stop function
                stopQRScanner() {
                    if (this.html5QrCode && this.isScanning) {
                        this.html5QrCode.stop().then(() => {
                            this.isScanning = false;
                            console.log("QR Scanner stopped");
                            const qrReaderDiv = document.getElementById('qr-reader');
                            if (qrReaderDiv) qrReaderDiv.innerHTML = ''; // Clear the video element
                        }).catch(err => {
                            console.error("Failed to stop QR scanner", err);
                        });
                    }
                },

                // Action on successful QR scan
                onScanSuccess(decodedText) {
                    if (this.html5QrCode && this.isScanning) {
                        this.html5QrCode.stop().then(() => {
                            this.isScanning = false;

                            const qrReaderDiv = document.getElementById('qr-reader');
                            qrReaderDiv.innerHTML = `
                                <div class="p-4 text-green-600 text-center">
                                    <i class="fa-solid fa-check-circle text-2xl mb-2"></i>
                                    <p>Scan Berhasil!</p>
                                    <p class="text-sm">Mencari data member...</p>
                                </div>`;

                            // Submit the QR form
                            document.getElementById('qrCode').value = decodedText;
                            document.getElementById('qrForm').submit();

                        }).catch(err => {
                            console.error("Gagal menghentikan scanner", err);
                        });
                    }
                },

                initAutoNfc() {
                    if (!this.isNfcSupported) return;
                    if (this.autoNfc && this.activeTab === 'card') {
                        try {
                            this.startNfcScan();
                        } catch (_) {}
                        const handler = () => {
                            if (!this.isScanningNfc) {
                                try {
                                    this.startNfcScan();
                                } catch (_) {}
                            }
                            document.removeEventListener('pointerdown', handler, {
                                once: true
                            });
                        };
                        document.addEventListener('pointerdown', handler, {
                            once: true
                        });
                    }
                },

                startNfcScan() {
                    if (!this.isNfcSupported) return;
                    try {
                        const ndef = new NDEFReader();
                        ndef.scan().then(() => {
                            this.isScanningNfc = true;
                            this.autoNfc = true;
                            localStorage.setItem('autoNfc', 'true');
                        }).catch(() => {
                            this.isScanningNfc = false;
                        });
                        ndef.onreading = (event) => {
                            let formatted = '';
                            if (event.serialNumber) {
                                let raw = String(event.serialNumber).toUpperCase();
                                raw = raw.replace(/[^0-9A-F]/g, '');
                                const pairs = raw.match(/.{1,2}/g);
                                formatted = pairs ? pairs.join(':') : raw;
                            }
                            if (!formatted) {
                                this.nfcResult = 'Tag tidak mengandung UID yang dapat dibaca via Web NFC';
                                this.isScanningNfc = false;
                                return;
                            }
                            this.nfcResult = formatted;
                            const input = document.getElementById('cardUid');
                            const form = document.getElementById('cardForm');
                            if (input && form) {
                                input.value = formatted;
                                form.submit();
                            }
                            this.isScanningNfc = false;
                        };
                    } catch (_) {
                        this.isScanningNfc = false;
                    }
                }
            }
        }
    </script>
@endpush
