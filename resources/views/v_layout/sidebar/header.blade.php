<div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="sidebar-header flex items-center gap-2 pt-8 pb-7">
    <a href="{{ route('dashboard') }}">
        <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
            <img class="dark:hidden" src="{{ asset('src/images/logo/logo.png') }}" alt="Logo" />
            <img class="hidden dark:block" src="{{ asset('src/images/logo/auth-logo.png') }}" alt="Logo" />
        </span>

        <img class="logo-icon" :class="sidebarToggle ? 'xl:block' : 'hidden'"
            src="{{ asset('src/images/logo/logo.png') }}" alt="Logo" />
    </a>
</div>
