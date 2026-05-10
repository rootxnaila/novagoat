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
            <li id="dashboardNav" style="display:none;"><a href="/dashboard" onclick="moveActive(this)">Dashboard</a></li>
            <li><a href="/katalog" onclick="moveActive(this)">Monitoring Kambing</a></li>
            <li><a href="/admin/medis" onclick="moveActive(this)">Perawatan & Medis</a></li>
            <li id="manajemenNav" style="display:none;"><a href="/admin/karyawan" onclick="moveActive(this)">Manajemen Karyawan</a></li>
            <div class="nav-indicator"></div>
        </ul>
    </nav>

    
    <div id="userDropdown" class="dropdown" style="display:none;">
        <button class="btn rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menu Akun" style="width: 38px; height: 38px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
            </svg>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0 animate-premium-entry" style="min-width: 170px; border-radius: 18px; margin-top: 15px; overflow: hidden; background: #ffffff; box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;">
            <li class="px-3 py-3 text-center" style="background: linear-gradient(135deg, #f0fdf4 0%, #e8f5e9 100%);">
                <div class="mb-2 mx-auto d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; background: #ffffff; border-radius: 14px; color: #2E7D32;">
                    <i class="bi bi-person-badge-fill" style="font-size: 1.3rem;"></i>
                </div>
                <span class="fw-bold d-block" id="usernameDisplay" style="font-size: 0.9rem; color: #1A2E1A; letter-spacing: -0.2px;">User</span>
                <span class="opacity-50" id="roleDisplay" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px; color: #4A6B4C; font-weight: 700;">Admin</span>
            </li>
            
            <li class="p-2">
                <a class="dropdown-item d-flex align-items-center gap-2 py-2 px-2 rounded-3 tactile-btn" href="#" id="logoutBtn" style="color: #dc3545; background: #fff5f5; border: 1px solid rgba(220, 53, 69, 0.1);">
                    <div class="d-flex align-items-center justify-content-center rounded-circle shadow-sm bg-white" style="width: 28px; height: 28px;">
                        <i class="bi bi-box-arrow-right" style="font-size: 0.9rem;"></i>
                    </div>
                    <span style="font-size: 0.8rem; font-weight: 700;">Keluar</span>
                </a>
            </li>
        </ul>

        <style>
            @keyframes premiumPopIn {
                from { opacity: 0; transform: scale(0.9) translateY(-10px); }
                to { opacity: 1; transform: scale(1) translateY(0); }
            }

            .dropdown-menu.show {
                display: block !important;
                animation: premiumPopIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
                pointer-events: auto !important;
            }

            .dropdown-menu {
                border: none;
                background: #ffffff;
                pointer-events: none;
            }
            
            .tactile-btn {
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .tactile-btn:hover {
                background: #dc3545 !important;
                color: #ffffff !important;
                transform: scale(0.96) !important;
                box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2);
            }
            .tactile-btn:hover i {
                color: #dc3545;
            }
        </style>
    </div>

    <button class="mobile-toggle" onclick="toggleMobileMenu()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
    </button>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const user = localStorage.getItem('user');
        if(user) {
            const userObj = JSON.parse(user);
            document.getElementById('userDropdown').style.display = 'block';
            document.getElementById('usernameDisplay').innerText = userObj.username || 'User';
            
            const roleEl = document.getElementById('roleDisplay');
            if (roleEl) roleEl.innerText = userObj.role || '-';

            if(userObj.role && userObj.role.toLowerCase() === 'admin') {
                const dn = document.getElementById('dashboardNav');
                if(dn) dn.style.display = '';

                const mn = document.getElementById('manajemenNav');
                if(mn) mn.style.display = '';
            }

            window.__userRole = userObj.role;
        }

        const logoutBtn = document.getElementById('logoutBtn');
        if(logoutBtn) {
            logoutBtn.onclick = function(e) {
                e.preventDefault();
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.href = '/login';
            };
        }
    });
</script>
</header>