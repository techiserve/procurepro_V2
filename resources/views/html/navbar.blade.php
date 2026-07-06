     <style>
        /* Ensure the dropdown isn't clipped by header wrappers */
.page-header, .header-right { overflow: visible !important; }

/* Container */
.user-dropdown { position: relative; z-index: 2000; }

/* Toggle */
.user-dropdown__image {
  display: flex; align-items: center; gap: 8px;
  cursor: pointer; user-select: none;
}
.user-dropdown__image img { width: 28px; height: 28px; border-radius: 50%; object-fit: cover; }
.user-dropdown__image .caret { opacity: .7; }

/* Menu */
.user-dropdown__menu {
  position: absolute; top: calc(100% + 8px); right: 0;
  min-width: 180px; list-style: none; margin: 0; padding: 6px 0;
  background: #fff; border: 1px solid #e6e6e6; border-radius: 8px;
  box-shadow: 0 8px 24px rgba(0,0,0,.08);
  display: none;
}
.user-dropdown.open .user-dropdown__menu { display: block; }

.user-dropdown__menu a,
.user-dropdown__menu button {
  display: block; width: 100%;
  padding: 8px 12px; text-align: left;
  background: none; border: 0; color: inherit; text-decoration: none; cursor: pointer;
}
.user-dropdown__menu a:hover,
.user-dropdown__menu button:hover { background: #f5f5f5; }

.user-dropdown__divider {
  border: 0; border-top: 1px solid #eee; margin: 6px 0;
}

        </style>      
      
      <div class="body-section">
        <div class="page-header">
            <button class="toggle-btn dextop"><i class="icon-2"></i></button>
            <div class="header-right">
                <ul class="header-right__icon">
                    <li>
                        <a href="#"><i class="icon-16"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-17"></i></a>
                    </li>
                </ul>
                        <div class="user-dropdown" id="userDropdown">
                        <div class="user-dropdown__image" id="userDropdownToggle" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
                            {{-- NOTE: fix the image extension if needed (.ng -> .png) --}}
                            <img src="{{ asset('assets/img/user-dropdown__image.png') }}" alt="" />
                            <p class="m-0">{{ Auth::user()->name }}</p>
                            <svg class="caret" width="12" height="8" viewBox="0 0 12 8" aria-hidden="true"><path d="M1 1l5 5 5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                        </div>

                        <ul class="user-dropdown__menu" id="userDropdownMenu">
                            @if(session('impersonator_id'))
                            <li>
                            <form method="POST" action="{{ route('users.stopImpersonating') }}">
                                @csrf
                                <button type="submit">Return to Vincent Admin</button>
                            </form>
                            </li>
                            <li><hr class="user-dropdown__divider"></li>
                            @endif
                            <li><a href="/profile/{{Auth::user()->id}}">Edit Profile</a></li>
                            <li><hr class="user-dropdown__divider"></li>
                            <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                            </li>
                        </ul>
                        </div>
            </div>
            <div class="toggle-btn">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
        </div>

        <script>
   
document.addEventListener('DOMContentLoaded', function () {
  const wrap   = document.getElementById('userDropdown');
  const toggle = document.getElementById('userDropdownToggle');
  const menu   = document.getElementById('userDropdownMenu');
  if (!wrap || !toggle || !menu) return;

  function openMenu() {
    wrap.classList.add('open');
    toggle.setAttribute('aria-expanded', 'true');
  }
  function closeMenu() {
    wrap.classList.remove('open');
    toggle.setAttribute('aria-expanded', 'false');
  }
  function toggleMenu() {
    wrap.classList.contains('open') ? closeMenu() : openMenu();
  }

  // Toggle on click/keyboard
  toggle.addEventListener('click', function (e) { e.stopPropagation(); toggleMenu(); });
  toggle.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggleMenu(); }
    if (e.key === 'Escape') { closeMenu(); }
  });

  // Clicks inside menu shouldn’t close before action
  menu.addEventListener('click', function (e) { e.stopPropagation(); });

  // Click anywhere else closes
  document.addEventListener('click', closeMenu);
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMenu(); });
});
</script>

    
