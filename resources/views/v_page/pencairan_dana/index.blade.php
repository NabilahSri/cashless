@extends('template')

@section('content')
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-md">
            {{-- Card Header --}}
            <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-200 dark:border-gray-800 dark:border-white/[0.03]">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white/90">
                    {{ $pageName }}
                </h3>
            </div>

            <div class="p-5 sm:p-6 space-y-6">

                @if (isset($selectedPartner))
                    {{-- Tampilkan Formulir Pencairan untuk Partner yang Dipilih --}}
                    @include('v_page.pencairan_dana._withdrawal_form', [
                        'partner' => $selectedPartner,
                        'balance' => $balance,
                        'withdrawals' => $withdrawals,
                    ])
                @else
                    {{-- Tampilkan Daftar Partner untuk Dipilih --}}
                    @include('v_page.pencairan_dana._partner_list', ['partners' => $partners])
                @endif

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const amountDisplay = document.getElementById('amount_display');
            const amountHidden = document.getElementById('amount');
            const maxBalance = {{ $balance ?? 0 }}; // Ambil nilai saldo maksimal

            if (amountDisplay && amountHidden) {
                // Menggunakan formatter standar Indonesia (IDR)
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });

                // Fungsi untuk membersihkan string Rupiah menjadi angka murni
                function cleanRupiah(rupiahString) {
                    // Hapus semua karakter non-digit
                    const cleaned = rupiahString.replace(/[^0-9]/g, '');
                    return parseInt(cleaned, 10) || 0;
                }

                function handleInput(e) {
                    let rawValue = cleanRupiah(e.target.value);

                    // Cek batasan maksimal (optional, tapi disarankan)
                    if (rawValue > maxBalance) {
                        rawValue = maxBalance;
                    }

                    // Simpan nilai angka murni ke input hidden
                    amountHidden.value = rawValue;

                    // Tampilkan nilai terformat ke input display
                    if (rawValue) {
                        e.target.value = formatter.format(rawValue);
                    } else {
                        e.target.value = '';
                    }
                }

                amountDisplay.addEventListener('input', handleInput);

                // Inisialisasi: Format nilai yang mungkin sudah ada (old('amount')) saat load
                if (amountHidden.value) {
                    amountDisplay.value = formatter.format(parseInt(amountHidden.value, 10));
                }
            }
        });
    </script>
@endpush
