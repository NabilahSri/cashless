@extends('template')

@section('content')
    {{-- WRAPPER UTAMA UNTUK ALPINE.JS DAN KONTEN PROFIL --}}
    {{-- Ini menginisialisasi variabel isProfileInfoModal yang digunakan oleh tombol 'Edit' dan Modal --}}
    <div x-data="{ isProfileInfoModal: false }">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="mb-5 text-lg font-semibold text-gray-800 lg:mb-7 dark:text-white/90">
                Informasi akun
            </h3>

            {{-- BLOK PROFIL UTAMA (NAMA, USERNAME, ROLE) --}}
            <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
                    <div class="flex w-full flex-col items-center gap-6 xl:flex-row">
                        <div class="h-20 w-20 overflow-hidden rounded-full border border-gray-200 dark:border-gray-800">
                            <img src="src/images/user/owner.jpg" alt="user" />
                        </div>
                        <div class="order-3 xl:order-2">
                            <h4
                                class="mb-2 text-center text-lg font-semibold text-gray-800 xl:text-left dark:text-white/90">
                                {{ auth()->user()->name }}
                            </h4>
                            <div class="flex flex-col items-center gap-1 text-center xl:flex-row xl:gap-3 xl:text-left">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ auth()->user()->role }}
                                </p>
                                <div class="hidden h-3.5 w-px bg-gray-300 xl:block dark:bg-gray-700"></div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ auth()->user()->username }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL EDIT AKUN (Membuka Modal) --}}
                    <button @click="isProfileInfoModal = true"
                        class="shadow-theme-xs flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 lg:inline-flex lg:w-auto dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"
                                fill="" />
                        </svg>
                        Edit
                    </button>
                </div>
            </div>

            {{-- BLOK INFORMASI PERSONAL TAMBAHAN (Hanya untuk member) --}}
            @if (auth()->user()->role == 'member')
                <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 lg:mb-6 dark:text-white/90">
                                Personal Information
                            </h4>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        First Name
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        Chowdury
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Last Name
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        Musharof
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Email address
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        <a href="cdn-cgi/l/email-protection.html" class="__cf_email__"
                                            data-cfemail="94e6f5faf0fbf9e1e7f1e6d4e4fdf9fefbbaf7fbf9">[email&#160;protected]</a>
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Phone
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        +09 363 398 46
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Bio
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        Team Manager
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL EDIT INFORMASI PERSONAL --}}
                        <button @click="isProfileInfoModal = true" {{-- Menggunakan modal yang sama, Anda mungkin ingin membuat modal terpisah untuk "Personal Information" --}}
                            class="shadow-theme-xs flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 lg:inline-flex lg:w-auto dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                            <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206ZM12.9698 3.84272C13.2627 3.54982 13.7376 3.54982 14.0305 3.84272L14.6934 4.50563C14.9863 4.79852 14.9863 5.2734 14.6934 5.56629L14.044 6.21573L12.3204 4.49215L12.9698 3.84272ZM11.2597 5.55281L5.6359 11.1766C5.53309 11.2794 5.46238 11.4099 5.43238 11.5522L5.01758 13.5185L6.98394 13.1037C7.1262 13.0737 7.25666 13.003 7.35947 12.9002L12.9833 7.27639L11.2597 5.55281Z"
                                    fill="" />
                            </svg>
                            Edit
                        </button>
                    </div>
                </div>
            @endif
        </div>

        {{-- --------------------------------------------------------------------------------------------------------------------- --}}
        {{-- MODAL EDIT AKUN (Ditempatkan di dalam x-data utama agar dapat diakses) --}}
        {{-- --------------------------------------------------------------------------------------------------------------------- --}}
        <div x-show="isProfileInfoModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">
            {{-- Tambahkan style="display: none;" agar tidak terlihat sebelum Alpine.js memuat --}}

            <div x-show="isProfileInfoModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @click.outside="isProfileInfoModal = false"
                class="w-full max-w-lg rounded-xl bg-white shadow-2xl dark:bg-gray-800 transition-all transform p-6 sm:p-8">

                {{-- Header Modal --}}
                <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Edit Informasi Akun
                    </h3>
                    <button @click="isProfileInfoModal = false"
                        class="p-1 rounded-full text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Form Edit Akun --}}
                <form action="{{ route('akun.update', auth()->user()->id) }}" method="POST" class="mt-6 space-y-5">
                    @csrf
                    @method('PUT') {{-- Gunakan method PUT/PATCH untuk pembaruan --}}

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                            Lengkap</label>
                        <input type="text" name="name" id="name" required
                            value="{{ old('name', auth()->user()->name) }}"
                            class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Masukkan Nama Lengkap">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Username</label>
                        <input type="text" name="username" id="username" required
                            value="{{ old('username', auth()->user()->username) }}"
                            class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Masukkan Username">
                        @error('username')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Separator untuk Password --}}
                    <hr class="border-gray-200 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">Ubah Password</p>

                    <div>
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Password Baru">
                        <p class="mt-1 text-xs text-red-500 dark:text-red-400">Kosongkan jika tidak ingin mengubah
                            password.</p>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Footer Modal (Tombol Aksi) --}}
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="isProfileInfoModal = false"
                            class="rounded-full px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 bg-white hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-full px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection
