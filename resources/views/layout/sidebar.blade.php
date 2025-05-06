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
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Data Utama</span>
            </li>
            <li
                class="menu-item {{ Request::is('admin/item-karyawan', 'admin/item-produk', 'admin/item-bahan', 'admin/item-overhead', 'admin/item-rencana-penjadwalan') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Layouts">Data Master</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Request::is('admin/item-karyawan') ? 'active' : '' }}">
                        <a href="{{ route('admin.item-karyawan') }}" class="menu-link">
                            <div data-i18n="Karyawan">Karyawan</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('admin/item-produk') ? 'active' : '' }}">
                        <a href="{{ route('admin.produk.item-produk') }}" class="menu-link">
                            <div data-i18n="Produk">Produk</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('admin/item-bahan') ? 'active' : '' }}">
                        <a href="{{ route('admin.bahan.item-bahan') }}" class="menu-link">
                            <div data-i18n="Bahan">Bahan</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('admin/item-overhead') ? 'active' : '' }}">
                        <a href="{{ route('admin.overhead.item-overhead') }}" class="menu-link">
                            <div data-i18n="Overhead">Overhead</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('admin/item-overhead') ? 'active' : '' }}">
                        <a href="{{ route('admin.lokasi.item-lokasi') }}" class="menu-link">
                            <div data-i18n="Lokasi">Lokasi</div>
                        </a>
                    </li>

            </li>
    </ul>
    </li>
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Produksi</span>
    </li>
    {{-- <li
        class="menu-item {{ Request::is('admin/produk-bahan', 'admin/harga-bahan', 'admin/status-produksi', 'admin/item-lokasi') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-cog"></i>
            <div data-i18n="Layouts">Produksi</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ Request::is('admin/produk-bahan') ? 'active' : '' }}">
                <a href="#" class="menu-link">
                    <div data-i18n="Produk Bahan">Produk Bahan</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/harga-bahan') ? 'active' : '' }}">
                <a href="#" class="menu-link">
                    <div data-i18n="Harga Bahan">Harga Bahan</div>
                </a>

            </li> --}}
    {{-- <li class="menu-item {{ Request::is('admin/status-produksi') ? 'active' : '' }}">
                        <a href="#" class="menu-link">
                            <div data-i18n="Status Produksi">Status Produksi</div>
                        </a>
                    </li> --}}
    {{-- <li class="menu-item {{ Request::is('admin/item-lokasi') ? 'active' : '' }}">
                        <a href="#" class="menu-link">
                            <div data-i18n="Lokasi">Lokasi</div>
                        </a>
                    </li> --}}
    {{-- <li class="menu-item {{ Request::is('admin/item-rencana-penjadwalan') ? 'active' : '' }}">
                <a href="#" class="menu-link">
                    <div data-i18n="Rencana Penjadwalan">Rencana Penjadwalan</div>
                </a>

        </ul> --}}
    <li class="menu-item ">
        <a href="{{ route('admin.produksi.item-produksi') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-box"></i>
            <div data-i18n="Analytics">Produk Bahan</div>
        </a>
    </li>

    <li class="menu-item ">
        <a href="{{ route('admin.produksi.item-pesanan') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-receipt"></i>
            <div data-i18n="Analytics">Pencatatan Pesanan</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('admin.produksi.item-penjadwalan') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calendar-check"></i>
            <div data-i18n="Analytics">Buat Penjadwalan</div>
        </a>
    </li>
    <li class="menu-item ">
        <a href="{{ route('admin.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calculator"></i>
            <div data-i18n="Analytics">Perhitungan HPP</div>
        </a>
    </li>

    </li>
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Laporan Transaksi</span></li>
    <li class="menu-item ">
        <a href="{{ route('admin.transaksi.item-laporan') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-calculator"></i>
            <div data-i18n="Analytics">Laporan Transaksi</div>
        </a>
    </li>
    {{-- <li
        class="menu-item {{ Request::is('admin/produk-bahan', 'admin/harga-bahan', 'admin/status-produksi', 'admin/item-lokasi') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-time"></i>
            <div data-i18n="Layouts">Transaksi</div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item {{ Request::is('admin/produk-bahan') ? 'active' : '' }}">
                <a href="#" class="menu-link">
                    <div data-i18n="Transaksi Produksi">Transaksi Produksi</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/harga-bahan') ? 'active' : '' }}">
                <a href="#" class="menu-link">
                    <div data-i18n="Detail Produksi">Detail Produksi</div>
                </a>
            </li>
        </ul>
    </li> --}}
    {{-- <li
                class="menu-item {{ Request::is('admin/produk-bahan', 'admin/harga-bahan', 'admin/status-produksi', 'admin/item-lokasi') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-spreadsheet "></i>
                    <div data-i18n="Layouts">Harga Pokok Produksi</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ Request::is('admin/produk-bahan') ? 'active' : '' }}">
                        <a href="#" class="menu-link">
                            <div data-i18n="HPP ">HPP </div>
                        </a>
                    </li>
                </ul>
            </li> --}}
    <!-- Misc -->
    {{-- <li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
    <li class="menu-item">
        <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/" target="_blank"
            class="menu-link">
            <i class="menu-icon tf-icons bx bx-file"></i>
            <div data-i18n="Documentation">Documentation</div>
        </a>
    </li> --}}
    </ul>
    @endif
</aside>
