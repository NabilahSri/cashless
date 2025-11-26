<div class="bg-indigo-600 text-white p-6 rounded-2xl shadow-xl dark:bg-indigo-800">
    <h5 class="text-lg font-semibold opacity-90">Saldo Partner: {{ $partner->name }}</h5>
    <h1 class="text-5xl font-extrabold mt-2">
        Rp {{ number_format($balance ?? 0, 0, ',', '.') }}
    </h1>
</div>

<div class="flex flex-wrap -mx-3">

    <div class="w-full lg:w-5/12 px-3 mb-6 lg:mb-0">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-md">

            <div
                class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-200 dark:border-gray-800 dark:border-white/[0.03]">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white/90">
                    Formulir Pencairan Dana
                </h3>
            </div>

            <div class="p-5 sm:p-6">
                <form action="{{ route('pencairanDana.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="partner_id" value="{{ $partner->id }}">

                    <div class="mb-4">
                        <label for="amount"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah
                            Pencairan</label>
                        <input type="text" id="amount_display"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                            required max="{{ $balance ?? 0 }}" placeholder="Masukkan jumlah pencairan">

                        <input type="hidden" name="amount" id="amount" value="{{ old('amount') }}">
                    </div>

                    <button type="submit"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-150"
                        id="submit_button">
                        Proses Pencairan Dana
                    </button>
                    <a href="{{ route('pencairanDana.index') }}"
                        class="w-full block text-center mt-2 text-sm text-indigo-600 hover:text-indigo-800">← Kembali ke
                        Daftar Partner</a>
                </form>
            </div>
        </div>
    </div>

    <div class="w-full lg:w-7/12 px-3">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] shadow-md">

            <div
                class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-200 dark:border-gray-800 dark:border-white/[0.03]">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white/90">
                    Riwayat Pencairan Partner ({{ $partner->name }})
                </h3>
            </div>

            <div class="p-5 sm:p-6">
                {{-- Tabel riwayat pencairan, sama seperti sebelumnya --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Kode Trx</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Jumlah</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($withdrawals as $w)
                                <tr>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $w->withdrawal_code }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 font-bold">
                                        Rp {{ number_format($w->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">BERHASIL</span>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $w->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Partner
                                        ini belum memiliki riwayat pencairan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
