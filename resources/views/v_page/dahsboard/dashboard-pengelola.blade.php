@extends('template')
@section('content')
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12">
            <!-- Metric Group Four -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-3">
                @if ($partner->is_admin == true)
                    <!-- Metric Item Start -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                        <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
                            {{ $total_pengelola }}
                        </h4>

                        <div class="mt-4 flex items-end justify-between sm:mt-5">
                            <div>
                                <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                    Total Pengelola
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Metric Item End -->
                @endif

                @if ($status_partner == false)
                    <!-- Metric Item Start -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                        <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
                            {{ 'Rp ' . number_format($saldo->balance, 0, ',', '.') }}
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
                            {{ 'Rp ' . number_format($penarikan, 0, ',', '.') }}
                        </h4>

                        <div class="mt-4 flex items-end justify-between sm:mt-5">
                            <div>
                                <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                    Jumlah Penarikan Dana
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Metric Item End -->

                    <!-- Metric Item Start -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                        <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
                            {{ 'Rp ' . number_format($pemasukan_hari_ini, 0, ',', '.') }}
                        </h4>

                        <div class="mt-4 flex items-end justify-between sm:mt-5">
                            <div>
                                <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                    Pemasukan Hari Ini
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
                                    Total Pemasukan
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Metric Item End -->
                @endif

                @if ($status_partner == true)
                    <!-- Metric Item Start -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                        <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
                            {{ 'Rp ' . number_format($total_topup, 0, ',', '.') }}
                        </h4>

                        <div class="mt-4 flex items-end justify-between sm:mt-5">
                            <div>
                                <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                    Total Pemasukan / Top Up
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Metric Item End -->

                    <!-- Metric Item Start -->
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                        <h4 class="text-title-sm font-bold text-gray-800 dark:text-white/90">
                            {{ 'Rp ' . number_format($total_pencairan, 0, ',', '.') }}
                        </h4>

                        <div class="mt-4 flex items-end justify-between sm:mt-5">
                            <div>
                                <p class="text-theme-sm text-gray-700 dark:text-gray-400">
                                    Total Pencairan
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Metric Item End -->
                @endif
            </div>
            <!-- Metric Group Four -->
        </div>
    </div>
    </div>
@endsection
