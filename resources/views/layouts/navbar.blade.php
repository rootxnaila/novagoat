<header>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-lg py-2 floating-nav">
        <div class="container-fluid px-3">
            <a class="navbar-brand d-flex align-items-center gap-2" href="/dashboard">
                <img src="{{ asset('images/logo kambiang.png') }}" alt="Goat Logo" style="width: 35px; height: 35px; object-fit: contain;">
                <div class="d-flex flex-column" style="line-height: 1.1;">
                    <span class="fw-bold" style="font-size: 0.95rem; color: #FFFFFF;">Peternakan Kambing</span>
                    <span style="font-size: 0.75rem; color: #D6EDD7;">Pak Tarno</span>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarMenu" aria-controls="mainNavbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="mainNavbarMenu">
                <ul class="navbar-nav me-auto ms-lg-4 mb-2 mb-lg-0 fw-semibold text-center gap-2" id="mainNav">
                    <li class="nav-item" id="dashboardNav" style="display:none;">
                        <a class="nav-link text-white px-4 py-2" href="/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white px-4 py-2" href="/katalog">Monitoring</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white px-4 py-2" href="/admin/medis">Medis</a>
                    </li>
                    <li class="nav-item" id="manajemenNav" style="display:none;">
                        <a class="nav-link text-white px-4 py-2" href="/admin/karyawan">Karyawan</a>
                    </li>
                </ul>

                <div class="d-flex justify-content-center mt-2 mt-lg-0 pb-2 pb-lg-0" id="userDropdown" style="display:none !important;">
                    <div class="dropdown">
                        <button class="btn rounded-circle p-2 d-flex align-items-center justify-content-center shadow-sm border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 38px; height: 38px; background: rgba(255,255,255,0.15); color: white;">
                            <i class="bi bi-person-fill fs-5"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0 animate-premium-entry" style="min-width: 180px; border-radius: 16px; margin-top: 15px; overflow: hidden; right: 0; left: auto;">
                            <li class="px-3 py-3 text-center" style="background: linear-gradient(135deg, #f0fdf4 0%, #e8f5e9 100%);">
                                <div class="mb-2 mx-auto d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px; background: #ffffff; border-radius: 12px; color: #2E7D32;">
                                    <i class="bi bi-person-badge-fill fs-4"></i>
                                </div>
                                <span class="fw-bold d-block" id="usernameDisplay" style="font-size: 0.95rem; color: #1A2E1A;">User</span>
                                <span class="opacity-75" id="roleDisplay" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; color: #4A6B4C; font-weight: 700;">Role</span>
                            </li>
                            <li class="p-2 border-top">
                                <a class="dropdown-item d-flex align-items-center justify-content-center gap-2 py-2 rounded-3 text-danger fw-bold bg-white" href="#" id="logoutBtn" style="transition: 0.2s;">
                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
    /* css navbar melayang kapsul */
    .floating-nav {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 95%;
        max-width: 1200px;
        background: rgba(27, 77, 30, 0.85) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        z-index: 1030;
    }

    @media (max-width: 991px) {
        .navbar-collapse {
            background: rgba(20, 60, 25, 0.95);
            margin-top: 10px;
            padding: 15px;
            border-radius: 15px;
        }
    }

    #logoutBtn:hover {
        background-color: #dc3545 !important;
        color: white !important;
    }
    
    /* fix :  efek kapsul navbar */
    .nav-link {
        border-radius: 50px !important; 
        transition: all 0.3s ease;
    }
    .nav-link:hover {
        background: rgba(255, 255, 255, 0.15);
    }
    /*efek kapsul nyala waktu halamannya dibuka */
    .nav-link.active {
        background-color: #D6EDD7 !important; 
        color: #1B4D1E !important; 
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    @keyframes premiumPopIn {
        from { opacity: 0; transform: scale(0.95) translateY(-10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-premium-entry {
        animation: premiumPopIn 0.2s ease-out forwards;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const user = localStorage.getItem('user');
        if(user) {
            const userObj = JSON.parse(user);
            
            const userDropdown = document.getElementById('userDropdown');
            if(userDropdown) userDropdown.style.setProperty('display', 'flex', 'important');
            
            document.getElementById('usernameDisplay').innerText = userObj.username || 'User';
            
            const roleEl = document.getElementById('roleDisplay');
            if (roleEl) roleEl.innerText = userObj.role || '-';

            if(userObj.role && userObj.role.toLowerCase() === 'admin') {
                const dn = document.getElementById('dashboardNav');
                if(dn) dn.style.display = 'block';

                const mn = document.getElementById('manajemenNav');
                if(mn) mn.style.display = 'block';
            }
        }

        // fix : detect halaman aktif otomatis 
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('#mainNav .nav-link');
        
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            // if url matchsama href menunya, kasih class active nyalain kapsul
            if (href && currentPath.startsWith(href)) {
                link.classList.add('active');
            }
        });

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