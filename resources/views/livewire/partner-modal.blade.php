<div>
    @if ($show)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 w-full max-w-lg">
                <div class="p-4 border-b dark:border-neutral-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        @if ($partner)
                            Daftar Pengelola untuk: {{ $partner->name }}
                        @else
                            Memuat...
                        @endif
                    </h2>
                </div>

                <div class="p-6">
                    @if (!empty($users) && count($users) > 0)
                        <ul class="space-y-3">
                            @foreach ($users as $user)
                                <li
                                    class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-neutral-700">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-200">
                                        {{ $user->role }} </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-gray-500 dark:text-neutral-400">
                            Belum ada pengelola yang ditugaskan untuk partner ini.
                        </p>
                    @endif
                </div>

                <div
                    class="px-4 py-3 text-right bg-gray-50 border-t rounded-b-lg dark:bg-neutral-800 dark:border-neutral-700">
                    <button type="button" wire:click="$set('show', false)"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
