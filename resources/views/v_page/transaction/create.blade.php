@extends('template')

@section('content')
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Tambah Data {{ $pageName }}
                </h3>
            </div>

            <div class="py-5 space-y-4 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

                <div x-data="{ activeTab: '{{ $activeSearchTab ?? 'member' }}' }" class="mb-4">
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <nav class="-mb-px flex gap-x-6" aria-label="Tabs">
                            <button
                                @click="activeTab = 'member'; $nextTick(() => document.getElementById('memberId').focus())"
                                :class="activeTab === 'member' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium">
                                <i class="fa-solid fa-hashtag mr-1"></i>
                                Nomor Member
                            </button>

                            <button @click="activeTab = 'card'; $nextTick(() => document.getElementById('cardUid').focus())"
                                :class="activeTab === 'card' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium">
                                <i class="fa-solid fa-id-card mr-1"></i>
                                Tap Kartu
                            </button>

                            {{-- <button @click="activeTab = 'qr'"
                                :class="activeTab === 'qr' ? 'border-blue-500 text-blue-600' :
                                    'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="whitespace-nowrap border-b-2 py-3 px-1 text-sm font-medium">
                                <i class="fa-solid fa-qrcode mr-1"></i>
                                Scan QR
                            </button> --}}
                        </nav>
                    </div>

                    <div class="py-4">
                        <div x-show="activeTab === 'member'">
                            <form action="{{ route('transaction.create') }}" method="GET">
                                <label for="memberId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nomor Member
                                </label>
                                <div class="mt-1 flex gap-2">
                                    <input type="text" id="memberId" name="memberId"
                                        value="{{ old('memberId', $memberId ?? null) }}" placeholder="Masukkan No. Member"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <button type="submit"
                                        class="flex-shrink-0 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400">
                                        Cari
                                    </button>
                                </div>
                                @error('memberId')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </form>
                        </div>

                        <div x-show="activeTab === 'card'" style="display: none;">
                            <form action="{{ route('transaction.create') }}" method="GET">
                                <label for="cardUid" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    UID Kartu
                                </label>
                                <div class="mt-1">
                                    <input type="text" id="cardUid" name="cardUid"
                                        value="{{ old('cardUid', $cardUid ?? null) }}" placeholder="Tempelkan kartu..."
                                        oninput="if(this.value.length === 11) { this.form.submit(); }"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                </div>
                                @error('cardUid')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </form>
                        </div>

                        {{-- <div x-show="activeTab === 'qr'" style="display: none;">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pindai QR Code member menggunakan kamera.
                            </p>

                            <div id="qr-reader" class="mt-2 w-full max-w-sm rounded-lg border dark:border-gray-600"></div>

                            <button type="button" id="start-scan-btn"
                                class="mt-3 rounded-lg bg-gray-700 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500">
                                <i class="fa-solid fa-camera mr-1"></i>
                                Mulai Scan
                            </button>
                        </div> --}}
                    </div>
                </div>
                @if ($member)
                    <div class="rounded-lg border bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-700">
                        <h4 class="font-semibold dark:text-white">Data Member</h4>
                        <dl class="mt-2 grid grid-cols-2 gap-x-4 gap-y-1 text-sm">
                            <dt class="text-gray-500 dark:text-gray-400">Nama:</dt>
                            <dd class="dark:text-white">{{ $member->name }}</dd>
                            <dt class="text-gray-500 dark:text-gray-400">Email:</dt>
                            <dd class="dark:text-white">{{ $member->email }}</dd>
                            <dt class="text-gray-500 dark:text-gray-400 mt-2">Saldo Saat Ini:</dt>
                            <dd class="dark:text-white font-bold text-lg mt-1">
                                Rp {{ number_format($currentBalance, 0, ',', '.') }}
                            </dd>
                        </dl>
                    </div>

                    <form action="{{ route('transaction.store') }}" method="POST" class="space-y-4 pt-4">
                        @csrf
                        <input type="hidden" name="memberId" value="{{ $member->member_no }}">
                        <div>
                            <label for="nominal_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nominal Transaksi
                            </label>
                            <input type="text" id="nominal_display" placeholder="Contoh: Rp 50.000"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                            <input type="hidden" id="nominal" name="nominal" value="{{ old('nominal') }}" />
                            @error('nominal')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="transactionType" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tipe Transaksi
                            </label>
                            <select id="transactionType" name="transactionType"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">Pilih tipe transaksi...</option>
                                @if ($cekDefault && $cekDefault->status == 1)
                                    <option value="topup" {{ old('transactionType') == 'topup' ? 'selected' : '' }}>
                                        Top Up / Deposit
                                    </option>
                                @endif
                                <option value="payment" {{ old('transactionType') == 'payment' ? 'selected' : '' }}>
                                    Pembayaran / Pembelian
                                </option>
                            </select>
                            @error('transactionType')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Deskripsi (Opsional)
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Contoh: Pembelian produk..."
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="pin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                PIN Member
                            </label>
                            <input type="password" id="pin" name="pin" placeholder="Masukkan pin member"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                            @error('pin')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3 ">
                            <button type="reset"
                                class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                                Reset
                            </button>
                            <button type="submit"
                                class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-400">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode/min_s.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nominalDisplay = document.getElementById('nominal_display');
            const nominalHidden = document.getElementById('nominal');

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
                if (nominalHidden.value) {
                    nominalDisplay.value = formatter.format(parseInt(nominalHidden.value, 10));
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startButton = document.getElementById('start-scan-btn');
            const qrReaderDiv = document.getElementById('qr-reader');

            if (!startButton || !qrReaderDiv) return;

            let html5QrCode;

            function onScanSuccess(decodedText, decodedResult) {
                console.log(`Scan berhasil: ${decodedText}`);

                if (html5QrCode && html5QrCode.isScanning) {
                    html5QrCode.stop().then(() => {
                        console.log("Scanner dihentikan.");
                    }).catch(err => {
                        console.error("Gagal menghentikan scanner.", err);
                    });
                }

                qrReaderDiv.innerHTML =
                    `<p class="p-4 text-green-600">Scan Berhasil: ${decodedText}. Mencari data...</p>`;

                const searchUrl = `{{ route('transaction.create') }}?qrCode=${decodedText}`;
                window.location.href = searchUrl;
            }

            function onScanFailure(error) {}

            startButton.addEventListener('click', () => {
                html5QrCode = new Html5Qrcode("qr-reader");

                startButton.textContent = "Mengaktifkan kamera...";
                startButton.disabled = true;

                html5QrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },
                    onScanSuccess,
                    onScanFailure
                ).catch(err => {
                    qrReaderDiv.innerHTML =
                        `<p class="p-4 text-red-600">Gagal memulai kamera: ${err}</p>`;
                    startButton.textContent = "Mulai Scan";
                    startButton.disabled = false;
                });
            });
        });
    </script>
@endpush
