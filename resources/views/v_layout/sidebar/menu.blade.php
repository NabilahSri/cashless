<nav>
    <!-- Menu Group -->
    <div>
        <h3 class="mb-4 text-xs leading-[20px] text-gray-400 uppercase">
            <span class="menu-group-title" :class="sidebarToggle ? 'xl:hidden' : ''">
                MENU
            </span>

            <svg :class="sidebarToggle ? 'xl:block hidden' : 'hidden'" class="menu-group-icon mx-auto fill-current"
                width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                    fill="currentColor" />
            </svg>
        </h3>

        <ul class="mb-6 flex flex-col gap-1">
            <!-- Menu Item Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                    class="menu-item group"
                    :class="(selected === 'Dashboard') && (page === 'dashboard') ? 'menu-item-active' : 'menu-item-inactive'">
                    <i class="fa-solid fa-table-columns text-xl"></i>
                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                        Dashboard
                    </span>
                </a>
            </li>
            <!-- Menu Item Dashboard -->

            <!-- Menu Item Pengguna -->
            <li>
                <a href="#" @click.prevent="selected = (selected === 'Pengguna' ? '':'Pengguna')"
                    class="menu-item group"
                    :class="(selected === 'Pengguna') || (page === 'user') ? 'menu-item-active' :
                    'menu-item-inactive'">
                    <i class="fa-solid fa-circle-user text-xl"></i>
                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                        Pengguna
                    </span>
                    <svg class="menu-item-arrow"
                        :class="[(selected === 'Pengguna') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive',
                            sidebarToggle ? 'xl:hidden' : ''
                        ]"
                        width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                <!-- Dropdown Menu Start -->
                <div class="translate transform overflow-hidden"
                    :class="(selected === 'Pengguna') ? 'block' : 'hidden'">
                    <ul :class="sidebarToggle ? 'xl:hidden' : 'flex'"
                        class="menu-dropdown mt-2 flex flex-col gap-1 pl-9">
                        <li>
                            <a href="{{ route('user.index') }}" class="menu-dropdown-item group"
                                :class="(page === 'user') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                User (admin & pengelola)
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.index') }}" class="menu-dropdown-item group"
                                :class="(page === 'member') ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                                Member
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Dropdown Menu End -->
            </li>
            <!-- Menu Item Pengguna -->

            <!-- Menu Item Partner -->
            <li>
                <a href="{{ route('wallet.index') }}" @click="selected = (selected === 'Dompet' ? '':'Dompet')"
                    class="menu-item group"
                    :class="(selected === 'Dompet') && (page === 'dompet') ? 'menu-item-active' : 'menu-item-inactive'">
                    <i class="fa-solid fa-wallet text-xl"></i>

                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                        Dompet
                    </span>
                </a>
            </li>
            <!-- Menu Item Dashboard -->

            <!-- Menu Item Partner -->
            <li>
                <a href="{{ route('partner.index') }}" @click="selected = (selected === 'Partner' ? '':'Partner')"
                    class="menu-item group"
                    :class="(selected === 'Partner') && (page === 'partner') ? 'menu-item-active' : 'menu-item-inactive'">
                    <i class="fa-solid fa-handshake text-xl"></i>

                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                        Partner
                    </span>
                </a>
            </li>
            <!-- Menu Item Dashboard -->

            <!-- Menu Item Partner -->
            <li>
                <a href="{{ route('merchant.index') }}" @click="selected = (selected === 'Lokasi' ? '':'Lokasi')"
                    class="menu-item group"
                    :class="(selected === 'Lokasi') && (page === 'lokasi') ? 'menu-item-active' : 'menu-item-inactive'">
                    <i class="fa-solid fa-location-dot text-xl"></i>

                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                        Lokasi
                    </span>
                </a>
            </li>
            <!-- Menu Item Dashboard -->

            <!-- Menu Item Partner -->
            <li>
                <a href="{{ route('transaction.index') }}"
                    @click="selected = (selected === 'Histori Transaksi' ? '':Histori 'Transaksi')"
                    class="menu-item group"
                    :class="(selected === 'Histori Transaksi') && (page === 'history-transaksi') ? 'menu-item-active' :
                    'menu-item-inactive'">
                    <i class="fa-solid fa-dollar-sign text-xl"></i>

                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                        Histori Transaksi
                    </span>
                </a>
            </li>
            <!-- Menu Item Dashboard -->

            <!-- Menu Item Partner -->
            <li>
                <a href="{{ route('log-activity.index') }}"
                    @click="selected = (selected === 'Aktivitas Log' ? '':'Aktivitas Log')" class="menu-item group"
                    :class="(selected === 'Aktivitas Log') && (page === 'aktivitas-log') ? 'menu-item-active' :
                    'menu-item-inactive'">
                    <i class="fa-solid fa-gear text-xl"></i>

                    <span class="menu-item-text" :class="sidebarToggle ? 'xl:hidden' : ''">
                        Aktivitas Log
                    </span>
                </a>
            </li>
            <!-- Menu Item Dashboard -->
        </ul>
    </div>
</nav>
