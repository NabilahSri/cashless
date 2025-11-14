<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
        PaySaku - Sistem Manajemen Transaksi Cashless
    </title>
    <link rel="icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @livewireStyles
</head>

<body x-data="{ selected: '{{ $selected ?? 'Dashboard' }}', page: '{{ $page ?? 'dashboard' }}', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false, 'menuToggle': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }">
    <!-- ===== Preloader Start ===== -->
    <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => { setTimeout(() => loaded = false, 500) })"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent">
        </div>
    </div>

    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->

        @include('v_layout.sidebar.base-sidebar')

        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
            <!-- ===== Header Start ===== -->
            @include('v_layout.header.base-header')
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main>
                <div class="mx-auto max-w-(--breakpoint-2xl) p-4 pb-20 md:p-6 md:pb-6">
                    <!-- Breadcrumb Start -->
                    <div x-data="{ pageName: `{{ $pageName ?? '' }}` }">
                        <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName"></h2>
                            <nav>
                                <ol class="flex items-center gap-1.5">
                                    <li>
                                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                                            href="index-2.html">
                                            Dashboard
                                            <svg class="stroke-current" width="17" height="16"
                                                viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke=""
                                                    stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName"></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Breadcrumb End -->
                    @yield('content')
                </div>
            </main>
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
    {{-- <script src="{{ asset('js/bundle.js') }}"></script> --}}
    <script data-cfasync="false" src="{{ asset('cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}">
    </script>
    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-delete-confirmation', (payload) => {

                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6B7281',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete-confirmed', {
                            id: payload.id
                        });
                    }
                });
            });
            Livewire.on('success', (event) => {
                Swal.fire({
                    icon: 'success',
                    text: event.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            });
            Livewire.on('failed', (event) => {
                Swal.fire({
                    icon: 'error',
                    text: event.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });
    </script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                duration: 1500
            });
        @endif
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}'
            });
        @endif
        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: '{{ session('warning') }}'
            });
        @endif
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                text: '{{ $errors->first() }}'
            });
        @endif
    </script>

    <script>
        window.addEventListener('reinit-hs-select', event => {
            setTimeout(() => {
                HSStaticMethods.autoInit();
            }, 50);
        });
    </script>
</body>

</html>
@stack('modals')
@stack('scripts')
</body>

</html>
