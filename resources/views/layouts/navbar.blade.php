<header class="header-nav">
    <div class="logo-wrapper">
        <img src="{{ asset('images/logo kambiang.png') }}" alt="Goat Logo" class="goat-icon">
        <div class="logo-text-stack">
            <span class="logo-main">Peternakan Kambing</span>
            <span class="logo-main">Pak Tarno</span>
        </div>
    </div>

    <nav>
        <ul class="nav-links" id="mainNav">
            <li><a href="/dashboard" onclick="moveActive(this)">Dashboard</a></li>
            <li><a href="/katalog" onclick="moveActive(this)">Monitoring Kambing</a></li>
            <li><a href="#" onclick="moveActive(this)">Penggemukan</a></li>
            <li id="medicalNav" style="display:none;"><a href="/admin/medis" onclick="moveActive(this)">Medical Schedule</a></li>
            <div class="nav-indicator"></div>
        </ul>
    </nav>

    <div class="header-right d-flex align-items-center gap-3">
    @if(Request::is('katalog*'))
    <div class="search-wrapper" id="searchWrapper">
        <input type="text" class="search-input" placeholder="Cari data kambing..." id="searchInput">
        <button class="search-pill" id="searchPill" onclick="toggleSearch()">search</button>
        <span class="close-search" onclick="toggleSearch()" id="closeSearch">&times;</span>
    </div>
    @endif
    <div id="userDropdown" class="dropdown" style="display:none;">
        <button class="btn btn-dark rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Akun" style="width: 38px; height: 38px; border: 1px solid rgba(255,255,255,0.2);">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
            </svg>
        </button>
        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow border-secondary" style="min-width: 160px; border-radius: 12px; margin-top: 10px;">
            <li class="px-3 py-2 text-center border-bottom border-secondary mb-1">
                <span class="text-info fw-bold d-block" id="usernameDisplay" style="font-size: 0.9rem;">User</span>
                <span class="text-secondary" id="roleDisplay" style="font-size: 0.7rem; text-transform: uppercase;">Role</span>
            </li>
            <li>
                <a class="dropdown-item text-danger d-flex align-items-center gap-2 py-2" href="#" id="logoutBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                    </svg>
                    <span style="font-size: 0.85rem; font-weight: 600;">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<script>
    // Sidebar/Topbar user logic
    document.addEventListener('DOMContentLoaded', function() {
        const user = localStorage.getItem('user');
        if(user) {
            const userObj = JSON.parse(user);
            document.getElementById('userDropdown').style.display = 'block';
            document.getElementById('usernameDisplay').innerText = userObj.username || 'User';
            
            const roleEl = document.getElementById('roleDisplay');
            if (roleEl) roleEl.innerText = userObj.role || 'Admin';

            if(userObj.role === 'Admin') {
                const mn = document.getElementById('medicalNav');
                if(mn) mn.style.display = '';
            }
        }
        const logoutBtn = document.getElementById('logoutBtn');
        if(logoutBtn) {
            logoutBtn.onclick = function(e) {
                e.preventDefault();
                localStorage.removeItem('token_sakti');
                localStorage.removeItem('user');
                window.location.href = '/login';
            };
        }
    });
</script>
</header>