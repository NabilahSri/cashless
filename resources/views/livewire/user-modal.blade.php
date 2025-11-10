<div>
    <!-- Triggered Modal -->
    @if ($show)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 w-full max-w-lg">
                <h2 class="text-lg font-semibold mb-4">{{ $mode === 'create' ? 'Tambah User' : 'Edit User' }}</h2>
                <form wire:submit.prevent="save" class="space-y-4">

                    <!-- Name -->
                    <div>
                        <label class="block text-sm mb-1">Nama</label>
                        <input wire:model.defer="name" type="text"
                            class="w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-700" />
                        @error('name')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label class="block text-sm mb-1">Username</label>
                        <input wire:model.defer="username" type="text"
                            class="w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-700" />
                        @error('username')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm mb-1">Role</label>
                        <select wire:model.defer="role"
                            class="w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                            <option value="">-- Pilih Hak Akses --</option>
                            <option value="admin">Admin</option>
                            <option value="pengelola">Pengelola</option>
                        </select>
                        @error('role')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 mt-4">
                        <button type="button" wire:click="$set('show', false)"
                            class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                            Batal
                        </button>
                        <button type="submit" wire:target="save" wire:loading.attr="disabled"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">

                            <!-- Text normal -->
                            <span wire:loading.remove wire:target="save">
                                {{ $mode === 'create' ? 'Simpan' : 'Simpan Perubahan' }}
                            </span>


                            <!-- Loading spinner -->
                            <span wire:loading wire:target="save" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </span>

                        </button>

                    </div>

                </form>
            </div>
        </div>
    @endif
</div>
