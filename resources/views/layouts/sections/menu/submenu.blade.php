<ul class="menu-sub">
  @if (isset($menu))
      @foreach ($menu as $submenu)
          @if (haveAccessTo($submenu->permissions))

              @php
                  $currentRouteName = Route::currentRouteName();
                  $isActive = false;

                  if (is_array($submenu->slug)) {
                      foreach ($submenu->slug as $slug) {
                          if (str_contains($currentRouteName, $slug)) {
                              $isActive = true;
                              break;
                          }
                      }
                  } elseif (is_string($submenu->slug) && str_contains($currentRouteName, $submenu->slug)) {
                      $isActive = true;
                  }

                  // Cek nested submenu
                  if (!$isActive && isset($submenu->submenu)) {
                      foreach ($submenu->submenu as $nested) {
                          if (is_array($nested->slug)) {
                              foreach ($nested->slug as $slug) {
                                  if (str_contains($currentRouteName, $slug)) {
                                      $isActive = true;
                                      break 2;
                                  }
                              }
                          } elseif (str_contains($currentRouteName, $nested->slug)) {
                              $isActive = true;
                              break;
                          }
                      }
                  }
              @endphp

              <li class="menu-item {{ $isActive ? 'active open' : '' }}">
                  <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0)' }}"
                      class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                      @if (!empty($submenu->target)) target="_blank" @endif>
                      @if (isset($submenu->icon))
                          <i class="{{ $submenu->icon }}"></i>
                      @endif
                      <div>{{ isset($submenu->name) ? __($submenu->name) : '' }}</div>
                      @isset($submenu->badge)
                          <div class="badge rounded-pill bg-{{ $submenu->badge[0] }} text-uppercase ms-auto">
                              {{ $submenu->badge[1] }}
                          </div>
                      @endisset
                  </a>

                  @if (isset($submenu->submenu) && count($submenu->submenu) > 0)
                      @include('layouts.sections.menu.submenu', ['menu' => $submenu->submenu])
                  @endif
              </li>
          @endif
      @endforeach
  @endif
</ul>