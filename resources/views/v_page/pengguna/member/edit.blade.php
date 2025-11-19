@extends('template')

@section('content')
    <div class="space-y-5 sm:space-y-6">
        <form action="{{ route('member.update', $member) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

                {{-- Card Header --}}
                <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
                    <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                        Edit Data {{ $pageName }}
                    </h3>
                    <div class="px-2.5">
                        <input type="text" name="member_no" value="{{ $member->member_no }}"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            readonly />
                    </div>
                </div>

                {{-- Card Body (Memuat Alpine.js State dan Fungsi) --}}
                <div x-data="{
                    pinStatus: '{{ old('status_pin', $member->status_pin) }}',
                    limitStatus: '{{ old('status_limit', $member->status_limit) }}',
                    // Memuat nilai limit lama ke variabel Rupiah (format: X.XXX.XXX)
                    limitRupiah: '{{ old('limit_transaction', $member->limit_transaction) > 0 ? number_format(old('limit_transaction', $member->limit_transaction), 0, ',', '.') : '' }}',
                
                    // Fungsi untuk format mata uang (SAMA seperti di form Tambah)
                    formatRupiah(value) {
                        let number_string = value.replace(/[^,\d]/g, '').toString(),
                            split = number_string.split(','),
                            sisa = split[0].length % 3,
                            rupiah = split[0].substr(0, sisa),
                            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                
                        if (ribuan) {
                            separator = sisa ? '.' : '';
                            rupiah += separator + ribuan.join('.');
                        }
                
                        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                
                        return rupiah;
                    },
                    // Fungsi untuk mendapatkan nilai bersih (angka saja) untuk submission
                    getCleanValue(formattedValue) {
                        return formattedValue.replace(/[^0-9]/g, '');
                    }
                }" class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                    <div class="-mx-2.5 flex flex-wrap gap-y-5">

                        {{-- Nama --}}
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Nama
                            </label>
                            <input type="text" placeholder="Masukkan nama" name="name"
                                value="{{ old('name', $member->name) }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required />
                        </div>

                        {{-- Username --}}
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Username
                            </label>
                            <input type="text" placeholder="Masukkan username" name="username"
                                value="{{ old('username', $member->user->username) }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required />
                        </div>

                        {{-- Email --}}
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email
                            </label>
                            <input type="email" placeholder="Masukkan email" name="email"
                                value="{{ old('email', $member->email) }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required />
                        </div>

                        {{-- No. Telp --}}
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                No. Telp
                            </label>
                            <input type="text" placeholder="Masukkan no. telp" name="phone"
                                value="{{ old('phone', $member->phone) }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required />
                        </div>

                        {{-- Status PIN --}}
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Status PIN
                            </label>
                            {{-- Mengikat nilai select ke Alpine.js pinStatus dan memuat nilai lama --}}
                            <select name="status_pin" x-model="pinStatus"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required>
                                <option value="active" :selected="pinStatus === 'active'">Aktif</option>
                                <option value="inactive" :selected="pinStatus === 'inactive'">Tidak Aktif</option>
                            </select>
                        </div>

                        {{-- PIN (Muncul HANYA JIKA pinStatus adalah 'active') --}}
                        <div x-show="pinStatus === 'active'" class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                PIN (6 Digit)
                            </label>
                            <input type="password" placeholder="Masukkan PIN baru jika ingin diubah" name="pin"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                maxlength="6" />
                            {{-- Catatan: Untuk input PIN/Password di form Edit, umumnya kita tidak mengisi field value dari database untuk keamanan. --}}
                        </div>

                        {{-- Placeholder jika PIN tidak aktif --}}
                        <div x-show="pinStatus !== 'active'" class="w-full px-2.5 xl:w-1/2"></div>

                        {{-- Status Limit --}}
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Status Limit
                            </label>
                            {{-- Mengikat nilai select ke Alpine.js limitStatus dan memuat nilai lama --}}
                            <select name="status_limit" x-model="limitStatus"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required>
                                <option value="daily" :selected="limitStatus === 'daily'">Harian</option>
                                <option value="weekly" :selected="limitStatus === 'weekly'">Mingguan</option>
                                <option value="monthly" :selected="limitStatus === 'monthly'">Bulanan</option>
                                <option value="no_limit" :selected="limitStatus === 'no_limit'">Tidak Ada Limit</option>
                            </select>
                        </div>

                        {{-- Limit Transaksi (Muncul HANYA JIKA limitStatus BUKAN 'no_limit') --}}
                        <div x-show="limitStatus !== 'no_limit'" class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Limit Transaksi
                            </label>

                            {{-- Input yang ditampilkan ke pengguna (Format Rupiah) --}}
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-500 dark:text-gray-400">Rp</span>
                                <input type="text" placeholder="Contoh: 500.000" x-model="limitRupiah"
                                    x-on:input="limitRupiah = formatRupiah($event.target.value)"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-4 pl-10 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    :required="limitStatus !== 'no_limit'" />
                            </div>

                            {{-- Input tersembunyi untuk mengirim nilai bersih ke Laravel (Angka saja) --}}
                            <input type="hidden" name="limit_transaction" :value="getCleanValue(limitRupiah)">
                        </div>

                        {{-- Placeholder jika Tidak Ada Limit --}}
                        <div x-show="limitStatus === 'no_limit'" class="w-full px-2.5 xl:w-1/2"></div>

                        {{-- Card UID --}}
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                UID Kartu
                            </label>
                            <input type="password" placeholder="Tempelkan kartu atau masukkan UID" name="card_uid"
                                value="{{ old('card_uid', $member->card_uid) }}"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                required />
                        </div>

                        {{-- Password --}}
                        <div class="w-full px-2.5 xl:w-1/2">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Password
                            </label>
                            <div x-data="{ showPassword: false }" class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password"
                                    placeholder="Masukkan password baru jika ingin diubah"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                <span @click="showPassword = !showPassword"
                                    class="absolute top-1/2 right-4 z-30 -translate-y-1/2 cursor-pointer text-gray-500 dark:text-gray-400">
                                    <svg x-show="!showPassword" class="fill-current" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M10.0002 13.8619C7.23361 13.8619 4.86803 12.1372 3.92328 9.70241C4.86804 7.26761 7.23361 5.54297 10.0002 5.54297C12.7667 5.54297 15.1323 7.26762 16.0771 9.70243C15.1323 12.1372 12.7667 13.8619 10.0002 13.8619ZM10.0002 4.04297C6.48191 4.04297 3.49489 6.30917 2.4155 9.4593C2.3615 9.61687 2.3615 9.78794 2.41549 9.94552C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C13.5184 15.3619 16.5055 13.0957 17.5849 9.94555C17.6389 9.78797 17.6389 9.6169 17.5849 9.45932C16.5055 6.30919 13.5184 4.04297 10.0002 4.04297ZM9.99151 7.84413C8.96527 7.84413 8.13333 8.67606 8.13333 9.70231C8.13333 10.7286 8.96527 11.5605 9.99151 11.5605H10.0064C11.0326 11.5605 11.8646 10.7286 11.8646 9.70231C11.8646 8.67606 11.0326 7.84413 10.0064 7.84413H9.99151Z"
                                            fill="#98A2B3" />
                                    </svg>
                                    <svg x-show="showPassword" class="fill-current" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M4.63803 3.57709C4.34513 3.2842 3.87026 3.2842 3.57737 3.57709C3.28447 3.86999 3.28447 4.34486 3.57737 4.63775L4.85323 5.91362C3.74609 6.84199 2.89363 8.06395 2.4155 9.45936C2.3615 9.61694 2.3615 9.78801 2.41549 9.94558C3.49488 13.0957 6.48191 15.3619 10.0002 15.3619C11.255 15.3619 12.4422 15.0737 13.4994 14.5598L15.3625 16.4229C15.6554 16.7158 16.1302 16.7158 16.4231 16.4229C16.716 16.13 16.716 15.6551 16.4231 15.3622L4.63803 3.57709ZM12.3608 13.4212L10.4475 11.5079C10.3061 11.5423 10.1584 11.5606 10.0064 11.5606H9.99151C8.96527 11.5606 8.13333 10.7286 8.13333 9.70237C8.13333 9.5461 8.15262 9.39434 8.18895 9.24933L5.91885 6.97923C5.03505 7.69015 4.34057 8.62704 3.92328 9.70247C4.86803 12.1373 7.23361 13.8619 10.0002 13.8619C10.8326 13.8619 11.6287 13.7058 12.3608 13.4212ZM16.0771 9.70249C15.7843 10.4569 15.3552 11.1432 14.8199 11.7311L15.8813 12.7925C16.6329 11.9813 17.2187 11.0143 17.5849 9.94561C17.6389 9.78803 17.6389 9.61696 17.5849 9.45938C16.5055 6.30925 13.5184 4.04303 10.0002 4.04303C9.13525 4.04303 8.30244 4.17999 7.52218 4.43338L8.75139 5.66259C9.1556 5.58413 9.57311 5.54303 10.0002 5.54303C12.7667 5.54303 15.1323 7.26768 16.0771 9.70249Z"
                                            fill="#98A2B3" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="w-full px-2.5">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Alamat
                            </label>
                            <textarea placeholder="Masukkan alamat" name="address"
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                rows="3" required>{{ old('address', $member->address) }}</textarea>
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="w-full px-2.5">
                            <div class="mt-1 flex items-center gap-3 justify-end">
                                <button type="submit"
                                    class="bg-brand-500 hover:bg-brand-600 flex items-center justify-center gap-2 rounded-lg px-4 py-3 text-sm font-medium text-white">
                                    <i class="fa-solid fa-floppy-disk"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
