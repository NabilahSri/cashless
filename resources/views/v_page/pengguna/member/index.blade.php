@extends('template')
@section('content')
    <div class="space-y-5 sm:space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                    Datatable 1
                </h3>
            </div>
            <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                <!-- ====== DataTable One Start -->
                <div>
                    <livewire:member-table />
                </div>
                <!-- ====== DataTable One End -->
            </div>
        </div>
    </div>
@endsection
