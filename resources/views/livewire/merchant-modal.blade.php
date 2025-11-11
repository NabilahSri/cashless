<div>
    <!-- Triggered Modal -->
    @if ($show)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 w-full max-w-lg">
                <h2 class="text-lg font-semibold mb-4">{{ $mode === 'create' ? 'Tambah Lokasi' : 'Edit Lokasi' }}</h2>
                <form wire:submit.prevent="save" class="space-y-4">

                    <!-- Partner ID -->
                    <div>
                        <label class="block text-sm mb-1">Partner</label>
                        <!-- Select -->
                        <select wire:model.defer="partner_id" wire:key="select-partner"
                            data-hs-select='{
                                            "hasSearch": true,
                                            "searchPlaceholder": "Search...",
                                            "searchClasses": "block w-full sm:text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-1.5 sm:py-2 px-3",
                                            "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
                                            "placeholder": "Select partner...",
                                            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200 \" data-title></span></button>",
                                            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
                                            "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
                                            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
                                            "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200 \" data-title></div></div></div>",
                                            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
                                            }'
                            class="hidden">
                            <option value="">Choose</option>
                            @foreach ($partner as $item)
                                <option value="{{ $item->id }}" {{ $partner_id = $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('partner_id')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                        <!-- End Select -->
                    </div>

                    <!-- Name -->
                    <div>
                        <label class="block text-sm mb-1">Nama</label>
                        <input wire:model.defer="name" type="text"
                            class="w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-700" />
                        @error('name')
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Device ID -->
                    <div>
                        <label class="block text-sm mb-1">Device ID</label>
                        <input wire:model.defer="device_id" type="number"
                            class="w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-700" />
                        @error('device_id')
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
