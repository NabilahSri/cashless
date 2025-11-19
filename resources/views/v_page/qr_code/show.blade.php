{{-- resources/views/member/qr-show.blade.php --}}
@extends('template') {{-- Sesuaikan dengan template utama Anda --}}

@section('content')
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                    Tunjukkan Kode Ini ke Pengelola
                </h3>
            </div>
            <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">

                {{-- Di sinilah komponen Livewire kita akan bekerja --}}
                <livewire:show-member-qr />

            </div>
        </div>
    </div>
@endsection
