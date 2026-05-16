<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kambing Super Pak Tarno</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        /* Background default diubah ke tema NovaGoat biar ga hitam */
        body { font-family: 'Inter', sans-serif; background: #E8EDEA; color: #1A2E1A; }
        
        /* Jarak atas diubah karena navbar baru tidak melayang (fixed) lagi */
        .main-content-padded { padding-top: 110px; padding-bottom: 50px; min-height: 100vh; }
        .main-content-full { min-height: 100vh; overflow-y: auto; overflow-x: hidden; }        
        body.login-page { overflow-y: auto; overflow-x: hidden; background: #000; color: white; }
            </style>
</head>
<body class="{{ Request::is('login*') || Request::is('register*') ? 'login-page' : '' }}">

    {{-- NAVBAR: Hanya muncul kalau bukan di halaman login/register --}}
    @if(!Request::is('login*') && !Request::is('register*') && !Request::is('/'))
        @include('layouts.navbar')
    @endif

    <main class="{{ (!Request::is('login*') && !Request::is('register*') && !Request::is('/')) ? 'main-content-padded' : 'main-content-full' }}">
        @yield('content')
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.searchable-select').forEach((el) => {
                new TomSelect(el, {
                    create: false,
                    sortField: { field: "text", direction: "asc" }
                });
            });
        });
    </script>
    
    <script>
        // Logika Keamanan: Proteksi Halaman & Cek Token
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            const hasToken = Boolean(token) && token !== 'null' && token !== 'undefined' && String(token).trim() !== '';
            const path = window.location.pathname;
            const protectedPrefixes = ['/dashboard','/admin/medis','/katalog','/admin'];
            const isProtected = protectedPrefixes.some(p => path === p || path.startsWith(p + '/') || path.includes(p));

            // Kalau belum login tapi maksa masuk halaman dalam, tendang ke login
            if (isProtected && !hasToken) {
                window.location.replace('/login');
                return;
            }

            // Kalau sudah login tapi iseng buka halaman login, lempar ke dashboard
            if ((path === '/login' || path === '/register' || path === '/') && hasToken) {
                window.location.replace('/dashboard');
                return;
            }
        });
    </script>
</body>
</html>