@extends('template')

@section('content')
    <div x-data="{ isProfileInfoModal: false, isPersonalInfoModal: false }">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 lg:p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h3 class="mb-5 text-lg font-semibold text-gray-800 lg:mb-7 dark:text-white/90">
                Informasi Profil
            </h3>

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

            @if (auth()->user()->role == 'member')
                <div class="mb-6 rounded-2xl border border-gray-200 p-5 lg:p-6 dark:border-gray-800">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 lg:mb-6 dark:text-white/90">
                                Informasi Pribadi
                            </h4>

                            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        No Member
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $member->member_no }}
                                    </p>
                                </div>
                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Nama
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ auth()->user()->name }}
                                    </p>
                                </div>
                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Email
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $member->email }}
                                    </p>
                                </div>
                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        No.Telp
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $member->phone }}
                                    </p>
                                </div>
                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Status PIN
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ ucfirst($member->status_pin == 'active' ? 'Aktif' : 'Tidak Aktif') }}
                                    </p>
                                </div>
                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Limit Transaksi
                                        ({{ (($member->status_limit == 'daily' ? 'Harian' : $member->status_limit == 'weekly') ? 'Mingguan' : $member->status_limit == 'monthly') ? 'Bulanan' : 'Tidak Ada Limit' }})
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        @if ($member->status_limit != 'no_limit')
                                            {{ 'Rp ' . number_format($member->limit_transaction ?? 0, 0, ',', '.') }}
                                        @else
                                            Tidak Ada Limit
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Tanggal Bergabung
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ Carbon\Carbon::parse($member->created_at)->format('d F Y') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                        Alamat
                                    </p>
                                    <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                        {{ $member->address }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button @click="isPersonalInfoModal = true"
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

        <hr class="border-gray-200 dark:border-gray-700 my-4">

        <div x-show="isPersonalInfoModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">

            <div x-show="isPersonalInfoModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @click.outside="isPersonalInfoModal = false"
                class="w-full max-w-lg rounded-xl bg-white shadow-2xl dark:bg-gray-800 transition-all transform p-6 sm:p-8">

                <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Edit Informasi Pribadi
                    </h3>
                    <button @click="isPersonalInfoModal = false"
                        class="p-1 rounded-full text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('personalInformation', auth()->user()->id) }}" method="POST" class="mt-6 space-y-5"
                    x-data="{
                        pinStatus: '{{ old('status_pin', $member->status_pin ?? 'inactive') }}',
                        limitStatus: '{{ old('status_limit', $member->status_limit ?? 'no_limit') }}',
                        limitTransaction: '{{ old('limit_transaction', number_format($member->limit_transaction ?? 0, 0, ',', '.')) }}',
                    
                        // Function untuk memformat angka menjadi format Rupiah (dengan titik)
                        formatRupiah(value) {
                            if (!value) return '';
                            let number_string = value.replace(/[^,\d]/g, '').toString(),
                                split = number_string.split(','),
                                sisa = split[0].length % 3,
                                rupiah = split[0].substr(0, sisa),
                                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                    
                            if (ribuan) {
                                separator = sisa ? '.' : '';
                                rupiah += separator + ribuan.join('.');
                            }
                            return rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                        },
                    
                        // Fungsi yang dijalankan saat input berubah
                        updateLimit(event) {
                            let value = event.target.value;
                            this.limitTransaction = this.formatRupiah(value);
                            // Karena input type text, kita perlu menyimpan nilai murni tanpa format ke hidden input
                            // Namun di Laravel, Anda harus menghapus titik/koma ini di sisi Controller/Backend.
                        }
                    }">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required
                                value="{{ old('name', auth()->user()->name) }}"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Masukkan Nama Lengkap">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" name="email" id="email" required
                                value="{{ old('email', $member->email) }}"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Masukkan Email">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="phone"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor
                                Telepon</label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone', $member->phone) }}"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Masukkan Nomor Telepon">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status_pin"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status PIN</label>
                            <select name="status_pin" id="status_pin" required x-model="pinStatus"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="inactive" :selected="pinStatus == 'inactive'">Tidak Aktif</option>
                                <option value="active" :selected="pinStatus == 'active'">Aktif</option>
                            </select>
                            @error('status_pin')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div x-show="pinStatus === 'active'">
                            <label for="pin"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ubah PIN</label>
                            <input type="password" name="pin" id="pin"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Masukkan Nomor Pin Baru (6 digit)">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah
                                pin.</p>
                            @error('pin')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div :class="{ 'md:col-span-2': pinStatus !== 'active' }">
                            <label for="status_limit"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status
                                Limit</label>
                            <select name="status_limit" id="status_limit" required x-model="limitStatus"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="no_limit" :selected="limitStatus == 'no_limit'">Tidak Ada Limit</option>
                                <option value="daily" :selected="limitStatus == 'daily'">Harian</option>
                                <option value="weekly" :selected="limitStatus == 'weekly'">Mingguan</option>
                                <option value="monthly" :selected="limitStatus == 'monthly'">Bulanan</option>
                            </select>
                            @error('status_limit')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div x-show="limitStatus !== 'no_limit'">
                        <label for="limit_transaction"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Limit Transaksi
                            (Rp)</label>

                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 dark:text-gray-400 text-sm">
                                Rp
                            </span>

                            <input type="text" name="limit_transaction" id="limit_transaction"
                                x-model="limitTransaction" @input="updateLimit" :required="limitStatus !== 'no_limit'"
                                class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 pl-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Cth: 1.000.000">
                            <input type="hidden" name="limit_transaction" :value="limitTransaction.replace(/\./g, '')">
                        </div>

                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nilai limit wajib diisi jika Anda memilih
                            limit harian/mingguan/bulanan. Format akan otomatis menggunakan titik.</p>
                        @error('limit_transaction')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat Lengkap</label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Masukkan Alamat">{{ old('address', $member->address) }}</textarea>
                        @error('address')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" @click="isPersonalInfoModal = false"
                            class="rounded-full px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 bg-white hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit"
                            class="rounded-full px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800">
                            Simpan Data Pribadi
                        </button>
                    </div>
                </form>

            </div>
        </div>

        <div x-show="isProfileInfoModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">

            <div x-show="isProfileInfoModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @click.outside="isProfileInfoModal = false"
                class="w-full max-w-lg rounded-xl bg-white shadow-2xl dark:bg-gray-800 transition-all transform p-6 sm:p-8">

                <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                        Edit Akun (Username & Password)
                    </h3>
                    <button @click="isProfileInfoModal = false"
                        class="p-1 rounded-full text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form action="{{ route('akun.update', auth()->user()->id) }}" method="POST" class="mt-6 space-y-5">
                    @csrf
                    @method('PUT')

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

                    <hr class="border-gray-200 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-600 dark:text-gray-300">Ubah Password</p>

                    <div>
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full rounded-lg border border-gray-300 p-3 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Password Baru">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah
                            password.</p>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

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
