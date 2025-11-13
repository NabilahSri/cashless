@extends('template')
@section('content')
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12">
            <!-- Metric Group Four -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-3">
                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
                        {{ 'Rp ' . number_format($wallet->balance, 0, ',', '.') }}
                    </h4>

                    <div class="mt-4 flex items-end justify-between sm:mt-5">
                        <div>
                            <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                Sisa Saldo
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->

                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
                        {{ 'Rp ' . number_format($pemasukan, 0, ',', '.') }}
                    </h4>

                    <div class="mt-4 flex items-end justify-between sm:mt-5">
                        <div>
                            <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                Pemasukan
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->

                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
                        {{ 'Rp ' . number_format($pengeluaran, 0, ',', '.') }}
                    </h4>

                    <div class="mt-4 flex items-end justify-between sm:mt-5">
                        <div>
                            <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                Pengeluaran
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->
            </div>
            <!-- Metric Group Four -->
        </div>

        <div class="col-span-12">
            <!-- Table Four -->
            <div
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white pt-4 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex flex-col gap-5 px-6 mb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Transaksi Terbaru
                        </h3>
                    </div>
                </div>

                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <table class="min-w-full">
                        <!-- table header start -->
                        <thead class="border-gray-100 border-y bg-gray-50 dark:border-gray-800 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Tanggal
                                        </p>
                                    </div>
                                </th>
                                <th class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Nama Member
                                        </p>
                                    </div>
                                </th>
                                <th class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Transaksi ID
                                        </p>
                                    </div>
                                </th>
                                <th class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Pengelola
                                        </p>
                                    </div>
                                </th>
                                <th class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Tipe
                                        </p>
                                    </div>
                                </th>
                                <th class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Nominal
                                        </p>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <!-- table header end -->

                        <!-- table body start -->
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach ($transaksi as $item)
                                <tr>

                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $item->created_at }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $item->wallet->member->name }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $item->trx_id }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $item->user->name }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <p class="text-gray-700 text-theme-sm dark:text-gray-400">
                                                {{ $item->type == 'topup' ? 'Top Up' : 'Pembayaran' }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($item->type == 'topup')
                                                <p
                                                    class="bg-success-50 text-theme-xs text-success-600 dark:bg-success-500/15 dark:text-success-500 rounded-full px-2 py-0.5 font-medium">
                                                    {{ 'Rp' . number_format($item->amount, 0, ',', '.') }}
                                                </p>
                                            @else
                                                <p
                                                    class="bg-red-50 text-theme-xs text-red-600 dark:bg-red-500/15 dark:text-red-500 rounded-full px-2 py-0.5 font-medium">
                                                    {{ 'Rp' . number_format($item->amount, 0, ',', '.') }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!-- table body end -->
                    </table>
                </div>
            </div>
            <!-- Table Four -->
        </div>
    </div>
    </div>
@endsection
