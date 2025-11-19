<div x-data="{
    expiryTimestamp: null,
    timerDisplay: '00:00',
    timerInterval: null,
    transactionSuccess: @entangle('transactionSuccessful'),

    startTimer(isoTimestamp) {
        if (this.timerInterval) { clearInterval(this.timerInterval); }
        this.expiryTimestamp = new Date(isoTimestamp);
        this.updateTimer();
        this.timerInterval = setInterval(() => { this.updateTimer(); }, 1000);
    },

    updateTimer() {
        const now = new Date();
        const secondsRemaining = Math.max(0, Math.floor((this.expiryTimestamp - now) / 1000));

        if (secondsRemaining <= 0) {
            this.timerDisplay = '00:00';
            clearInterval(this.timerInterval);
            return;
        }
        const minutes = Math.floor(secondsRemaining / 60);
        const seconds = secondsRemaining % 60;
        this.timerDisplay = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }
}" x-init="startTimer('{{ $expiresAt }}')"
    x-on:qr-generated.window="transactionSuccess = false; startTimer($event.detail.expiresAt)"
    x-on:transaction-success.window="
        transactionSuccess = true;
        if (timerInterval) { clearInterval(timerInterval); }
        timerDisplay = 'Terpakai';
    ">

    <div x-show="!transactionSuccess" x-transition>
        <div class="flex flex-col items-center justify-center space-y-4" wire:poll.3s="checkStatus">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Berlaku untuk:
            </p>

            <p class="text-3xl font-bold text-red-600 dark:text-red-500" x-text="timerDisplay">
            </p>

            <div class="relative p-4 bg-white rounded-lg shadow">
                @if ($qrString)
                    {!! QrCode::size(250)->generate($qrString) !!}
                @else
                    <div class="w-[250px] h-[250px] flex items-center justify-center">
                        <p>Memuat...</p>
                    </div>
                @endif
            </div>

            <button wire:click="generate" wire:loading.attr="disabled" type="button"
                class="inline-flex gap-2 items-center justify-center rounded-lg bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-all duration-200 ease-in-out hover:bg-gray-700 focus:outline-none focus:ring-2 dark:bg-gray-500 dark:hover:bg-gray-400">
                Refresh Manual
            </button>
        </div>
    </div>

    <div x-show="transactionSuccess" x-transition style="display: none;">
        <div class="flex flex-col items-center justify-center space-y-4 text-center">

            <div class="w-24 h-24 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                <i class="fa-solid fa-check text-5xl text-green-500"></i>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                Transaksi Berhasil!
            </h3>

            <div class="py-2">
                @if ($successType == 'topup')
                    <p class="text-lg text-gray-700 dark:text-gray-300">Anda berhasil Top Up</p>
                    <p class="text-3xl font-bold text-green-600">
                        Rp {{ number_format($successAmount, 0, ',', '.') }}
                    </p>
                @elseif($successType == 'payment')
                    <p class="text-lg text-gray-700 dark:text-gray-300">Anda berhasil melakukan Pembayaran</p>
                    <p class="text-3xl font-bold text-red-600">
                        Rp {{ number_format($successAmount, 0, ',', '.') }}
                    </p>
                @else
                    <p class="text-lg text-gray-700 dark:text-gray-300">Nominal Transaksi:</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">
                        Rp {{ number_format($successAmount, 0, ',', '.') }}
                    </p>
                @endif
            </div>

            <p class="text-gray-600 dark:text-gray-400">
                Pembayaran Anda telah dikonfirmasi.
            </p>

            <button wire:click="generate" type="button"
                class="mt-4 inline-flex gap-2 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-all duration-200 ease-in-out hover:bg-blue-700 focus:outline-none focus:ring-2 dark:bg-blue-500 dark:hover:bg-blue-400">
                Buat Transaksi Baru
            </button>
        </div>
    </div>

</div>
