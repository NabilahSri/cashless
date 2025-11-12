<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 w-full max-w-lg">
                <div class="flex items-center justify-between pb-4 border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fa-solid fa-cash-register mr-2"></i>
                        Form Transaksi
                    </h3>
                </div>

                <div class="py-5 space-y-4">

                    @if (session()->has('error'))
                        <div class="rounded-lg bg-red-100 p-3 text-sm text-red-700 dark:bg-red-900 dark:text-red-200">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div
                            class="rounded-lg bg-green-100 p-3 text-sm text-green-700 dark:bg-green-900 dark:text-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div>
                        <label for="memberId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nomor Member
                        </label>
                        <div class="mt-1 flex gap-2">
                            <input type="text" id="memberId" wire:model.defer="memberId"
                                placeholder="Masukkan No. Member"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <button type="button" wire:click="findMember"
                                class="flex-shrink-0 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-400">
                                <span wire:loading.remove wire:target="findMember">Cari</span>
                                <span wire:loading wire:target="findMember">Mencari...</span>
                            </button>
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
                    @endif

                    @if ($member)
                        <div class="space-y-4 border-t pt-4 dark:border-gray-700">

                            <div>
                                <label for="nominal"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nominal Transaksi
                                </label>
                                <input type="text" id="nominal" x-data x-init="$watch('value', v => $wire.set('nominal', v.replace(/\D/g, '')))"
                                    x-on:input="
                                                    let raw = $event.target.value.replace(/\D/g, '');
                                                    if (raw) {
                                                        $event.target.value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(raw);
                                                    } else {
                                                        $event.target.value = '';
                                                    }
                                                    $wire.set('nominal', raw);
                                                "
                                    placeholder="Contoh: 50.000"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white" />

                                @error('nominal')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="transactionType"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tipe Transaksi
                                </label>
                                <select id="transactionType" wire:model.defer="transactionType"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    <option value="">Pilih tipe transaksi...</option>
                                    @if ($cekDefault->status == 1)
                                        <option value="topup">Top Up / Deposit</option>
                                    @endif
                                    <option value="payment">Pembayaran / Pembelian</option>
                                </select>
                                @error('transactionType')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="deskripsi"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Deskripsi (Opsional)
                                </label>
                                <textarea id="deskripsi" wire:model.defer="deskripsi" rows="3" placeholder="Contoh: Pembelian produk..."
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"></textarea>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="flex justify-end gap-3 border-t pt-4 dark:border-gray-700">
                    <button type="button" wire:click="close"
                        class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500">
                        Batal
                    </button>
                    <button type="button" wire:click="saveTransaction"
                        @if (!$member) disabled @endif
                        class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-green-500 dark:hover:bg-green-400">
                        <span wire:loading.remove wire:target="saveTransaction">Simpan Transaksi</span>
                        <span wire:loading wire:target="saveTransaction">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
