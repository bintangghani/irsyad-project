<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('variables.templateName') }}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @foreach ($menuData[0]->menu as $menu)
            @if (haveAccessTo($menu->permissions))
                @php
                    $currentRouteName = Route::currentRouteName();
                    $isMenuActive = false;

                    // Cek jika salah satu submenu aktif (recursive)
                    if (isset($menu->submenu)) {
                        foreach ($menu->submenu as $submenu) {
                            if (
                                (is_array($submenu->slug) &&
                                    collect($submenu->slug)->contains(
                                        fn($slug) => str_contains($currentRouteName, $slug),
                                    )) ||
                                (is_string($submenu->slug) && str_contains($currentRouteName, $submenu->slug))
                            ) {
                                $isMenuActive = true;
                                break;
                            }

                            // Cek lebih dalam jika nested submenu
                            if (isset($submenu->submenu)) {
                                foreach ($submenu->submenu as $nested) {
                                    if (
                                        (is_array($nested->slug) &&
                                            collect($nested->slug)->contains(
                                                fn($slug) => str_contains($currentRouteName, $slug),
                                            )) ||
                                        (is_string($nested->slug) && str_contains($currentRouteName, $nested->slug))
                                    ) {
                                        $isMenuActive = true;
                                        break 2;
                                    }
                                }
                            }
                        }
                    }

                    // Cek slug langsung di menu utama
                    if (
                        (is_array($menu->slug) &&
                            collect($menu->slug)->contains(fn($slug) => str_contains($currentRouteName, $slug))) ||
                        (is_string($menu->slug) && str_contains($currentRouteName, $menu->slug))
                    ) {
                        $isMenuActive = true;
                    }
                @endphp

                <li class="menu-item {{ $isMenuActive ? 'active open' : '' }}">
                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                        class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}">
                        @isset($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                        @endisset
                        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                    </a>

                    @if (isset($menu->submenu) && count($menu->submenu) > 0)
                        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                    @endif
                </li>
            @endif
        @endforeach

    </ul>
</aside>
