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
    <div class="search-wrapper" id="searchWrapper">
        <input type="text" class="search-input" placeholder="Cari data kambing..." id="searchInput">
        <button class="search-pill" id="searchPill" onclick="toggleSearch()">search</button>
        <span class="close-search" onclick="toggleSearch()" id="closeSearch">&times;</span>
    </div>
    <div id="userDropdown" class="dropdown" style="display:none;">
        <button class="btn btn-dark dropdown-toggle px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span id="usernameDisplay">User</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="#" id="logoutBtn">Logout</a></li>
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