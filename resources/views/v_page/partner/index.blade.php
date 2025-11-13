@extends('template')
@section('content')
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5 flex justify-between">
                <div class="flex items-center space-x-3">
                    {{-- @if (auth()->user()->role == 'admin') --}}
                    <a href="{{ route('partner.create') }}"
                        class="inline-flex gap-2 items-center justify-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-all duration-200 ease-in-out hover:scale-105 hover:bg-blue-700 focus:outline-none focus:ring-2  dark:bg-blue-500 dark:hover:bg-blue-400 dark:hover:scale-105">
                        <i class="fa-solid fa-plus"></i>
                        Tambah Data
                    </a>
                    {{-- @endif --}}

                </div>
            </div>
            <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                <!-- ====== DataTable One Start -->
                <div>
                    <livewire:partner-table />
                </div>
                <!-- ====== DataTable One End -->
            </div>
        </div>
    </div>
@endsection
@push('modals')
    <livewire:partner-modal />
@endpush
