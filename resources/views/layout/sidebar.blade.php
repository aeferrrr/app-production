<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <div>
                @props(['width' => '75px', 'height' => 'auto'])

                <a href="/">
                    <img src="{{ asset('assets/img/illustrations/nuraisah.png') }}"
                        style="width: {{ $width }}; height: {{ $height }};" {{ $attributes }}
                        alt="Application Logo">
                </a>
            </div>
            <span class="app-brand-text demo menu-text fw-bolder ms-2"
                style="word-wrap: break-word; white-space: normal; text-transform: capitalize;">
                produksi
            </span>



        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        {{-- sidebar karyawan --}}
        @if (Auth()->user()->role === 'karyawan')
            <li class="menu-item">
                <a href="{{ route('karyawan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Transaksi</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Masukan Penjadwalan">Transaksi</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="pages-account-settings-account.html" class="menu-link">
                            <div data-i18n="Lihat Penjadwalan">Masukan Penjadwalan</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="pages-account-settings-notifications.html" class="menu-link">
                            <div data-i18n="Notifications">Lihat Penjadwalan</div>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- sidebar admin --}}
        @elseif (Auth()->user()->role === 'admin')
            <li class="menu-item {{ Request::is('admin') ? 'active' : '' }}">
                <a href="{{ route('admin.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div data-i18n="Analytics">Dashboard</div>
                </a>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Layouts">Data Master</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="layouts-without-menu.html" class="menu-link">
                            <div data-i18n="Item">Item</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('admin.item-karyawan') }}" class="menu-link">
                            <div data-i18n="Karyawan">Karyawan</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="layouts-container.html" class="menu-link">
                            <div data-i18n="Lokasi">Lokasi</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="layouts-fluid.html" class="menu-link">
                            <div data-i18n="Rencana Penjadwalan">Rencana Penjadwalan</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Transaksi</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Masukan Penjadwalan">Transaksi</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="pages-account-settings-account.html" class="menu-link">
                            <div data-i18n="Lihat Penjadwalan">Masukan Penjadwalan</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="pages-account-settings-notifications.html" class="menu-link">
                            <div data-i18n="Notifications">Lihat Penjadwalan</div>
                        </a>
                    </li>
                </ul>
            </li>
            </li>
            <!-- Misc -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
            <li class="menu-item">
                <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank"
                    class="menu-link">
                    <i class="menu-icon tf-icons bx bx-support"></i>
                    <div data-i18n="Support">Support</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="Documentation">Documentation</div>
                </a>
            </li>
    </ul>
    @endif

</aside>
