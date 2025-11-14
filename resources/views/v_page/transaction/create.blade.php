{{-- Asumsikan Anda memiliki layout utama, sesuaikan jika perlu --}}
@extends('template') {{-- Sesuai file Anda --}}

@section('content') {{-- Sesuai file Anda --}}
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Tambah Data {{ $pageName }}
                </h3>
            </div>
            {{-- Body Form --}}
            <div class="py-5 space-y-4 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

                {{-- Menampilkan pesan error atau sukses dari session --}}
                @if (session('error'))
                    <div class="rounded-lg bg-red-100 p-3 text-sm text-red-700 dark:bg-red-900 dark:text-red-200">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="rounded-lg bg-green-100 p-3 text-sm text-green-700 dark:bg-green-900 dark:text-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- FORM UNTUK MENCARI MEMBER (Langkah 1) --}}
                <form action="{{ route('transaction.create') }}" method="GET">
                    <div>
                        <label for="memberId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nomor Member
                        </label>
                        <div class="mt-1 flex gap-2">
                            <input type="text" id="memberId" name="memberId" value="{{ old('memberId', $memberId) }}"
                                {{-- $memberId di-pass dari controller --}} placeholder="Masukkan No. Member"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <button type="submit"
                                class="flex-shrink-0 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400">
                                Cari
                            </button>
                        </div>
                        @error('memberId')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </form>

                {{-- Menampilkan Data Member Jika Ditemukan --}}
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
                @endif

                {{-- FORM UTAMA UNTUK MENYIMPAN TRANSAKSI (Langkah 2) --}}
                {{-- Hanya tampil jika member ditemukan --}}
                @if ($member)
                    <form action="{{ route('transaction.store') }}" method="POST" class="space-y-4">
                        @csrf
                        {{-- Simpan memberId yang valid di hidden input --}}
                        <input type="hidden" name="memberId" value="{{ $member->member_no }}">



                        {{-- Input Nominal (Baru dengan pemformatan) --}}
                        <div>
                            <label for="nominal_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nominal Transaksi
                            </label>

                            {{-- Input yang dilihat pengguna (display) --}}
                            <input type="text" id="nominal_display" placeholder="Contoh: Rp 50.000"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />

                            {{-- Input yang dikirim ke server (hidden) --}}
                            <input type="hidden" id="nominal" name="nominal" value="{{ old('nominal') }}" />

                            @error('nominal')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Input Tipe Transaksi --}}
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

                        {{-- Input Deskripsi --}}
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

                        {{-- Input PIN --}}
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


                        {{-- Footer Form --}}
                        <div class="flex justify-end gap-3 ">
                            {{-- Tombol Batal diganti menjadi Reset Form --}}
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
    {{-- Asumsikan layout 'template' Anda memiliki @stack('scripts') --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nominalDisplay = document.getElementById('nominal_display');
            const nominalHidden = document.getElementById('nominal');

            if (!nominalDisplay || !nominalHidden) return;

            // Formatter untuk Rupiah
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });

            // Fungsi untuk menangani input
            function handleInput(e) {
                // 1. Ambil nilai, bersihkan dari selain angka
                let rawValue = e.target.value.replace(/\D/g, '');

                // 2. Update input tersembunyi dengan nilai mentah
                nominalHidden.value = rawValue;

                // 3. Format nilai dan tampilkan di input display
                if (rawValue) {
                    // Konversi ke angka dulu untuk formatting
                    let numberValue = parseInt(rawValue, 10);
                    let formattedValue = formatter.format(numberValue);

                    // Set nilai display
                    e.target.value = formattedValue;
                } else {
                    e.target.value = '';
                }
            }

            // Tambahkan event listener
            nominalDisplay.addEventListener('input', handleInput);

            // Cek jika ada nilai lama (misal dari validasi error)
            if (nominalHidden.value) {
                let rawValue = nominalHidden.value;
                let numberValue = parseInt(rawValue, 10);
                nominalDisplay.value = formatter.format(numberValue);
            }
        });
    </script>
@endpush
