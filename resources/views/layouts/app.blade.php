<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kambing Super Pak Tarno</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        *{ margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #000; color: white; }
        
        .main-content-padded { padding-top: 110px; min-height: 100vh; }
        .main-content-full { height: 100vh; overflow: hidden; }
        
        body.login-page { overflow: hidden; }

        .header-nav {
            position: fixed;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 1400px;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6), inset 0 0 0 1px rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 35px;
            z-index: 1000;
        }

        .logo-wrapper { display: flex; align-items: center; gap: 12px; }
        .goat-icon { height: 40px; width: auto; }
        .logo-text-stack { display: flex; flex-direction: column; line-height: 1.1; }
        .logo-main { color: white; font-weight: 600; font-size: 0.9rem; white-space: nowrap; }
        .logo-sub { color: rgba(255, 255, 255, 0.7); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; }
        .nav-links { display: flex; list-style: none; gap: 5px; align-items: center; position: relative; margin: 0; padding: 0; }
        .nav-links li { z-index: 2; margin: 0; padding: 0; }
        .nav-links a { 
            text-decoration: none; color: rgba(255, 255, 255, 0.8); 
            font-size: 0.85rem; padding: 10px 20px; display: block;
            transition: color 0.4s ease;
        }
        .nav-links a.active { color: #000; }
        .nav-indicator {
            position: absolute; background: #fff; border-radius: 25px; z-index: 1;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            width: 100px;
            height: 40px;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .search-wrapper.active { width: 300px; }

        .search-input {
            width: 100%; height: 100%;
            background: white; border: none; border-radius: 25px;
            padding: 0 45px 0 40px; font-size: 0.85rem; color: #333; outline: none;
            opacity: 0; visibility: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .search-wrapper.active .search-input { opacity: 1; visibility: visible; }

        .search-pill {
            position: absolute; right: 0;
            background: transparent; border: 1px solid white; color: white;
            padding: 8px 22px; border-radius: 25px; cursor: pointer;
            font-size: 0.8rem; transition: 0.3s; white-space: nowrap;
        }

        .search-pill:hover { background: white; color: black; }
        .search-wrapper.active .search-pill { opacity: 0; pointer-events: none; }

        .search-icon-inner {
            position: absolute; left: 15px; font-size: 0.9rem; color: #888;
            display: none; z-index: 5;
        }
        .search-wrapper.active .search-icon-inner { display: block; }

        .close-search {
            position: absolute; right: 15px; color: #888; font-size: 1.4rem;
            cursor: pointer; display: none; z-index: 5;
        }
        .search-wrapper.active .close-search { display: block; }
    </style>
</head>
<body class="{{ Request::is('login*') || Request::is('register*') ? 'login-page' : '' }}">

    {{-- NAVBAR only when NOT on login page, NOT on register page, and NOT on welcome page --}}
    @if(!Request::is('login*') && !Request::is('register*') && !Request::is('/'))
        @include('layouts.navbar')
    @endif

    <main class="{{ (!Request::is('login*') && !Request::is('register*') && !Request::is('/')) ? 'main-content-padded' : 'main-content-full' }}">
        @yield('content')
    </main>
        <script>
            function moveActive(element) {
                const links = document.querySelectorAll('.nav-links a');
                const indicator = document.querySelector('.nav-indicator');
                links.forEach(link => link.classList.remove('active'));
                element.classList.add('active');
                
                indicator.style.width = element.offsetWidth + 'px';
                indicator.style.left = element.offsetLeft + 'px';
                indicator.style.height = element.offsetHeight + 'px';
            }

            function toggleSearch() {
                const wrapper = document.getElementById('searchWrapper');
                const input = document.getElementById('searchInput');
                
                wrapper.classList.toggle('active');
                
                if (wrapper.classList.contains('active')) {
                    setTimeout(() => { input.focus(); }, 300);
                } else {
                    input.value = '';
                }
            }

            window.onload = function() {
                const currentPath = window.location.pathname;
                const links = document.querySelectorAll('.nav-links a');
                let found = false;
                links.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href && href !== '#' && currentPath.startsWith(href)) {
                        moveActive(link);
                        found = true;
                    }
                });
                
                // Default to first link if none matches
                if(!found && links.length > 0) {
                    moveActive(links[0]);
                }
            };

            // Frontend route guard: redirect to /login when token missing for protected pages
            document.addEventListener('DOMContentLoaded', function() {
                const token = localStorage.getItem('token_sakti');
                const hasToken = Boolean(token) && token !== 'null' && token !== 'undefined' && String(token).trim() !== '';
                const path = window.location.pathname;
                const protectedPrefixes = ['/dashboard','/medis','/katalog','/admin'];
                const isProtected = protectedPrefixes.some(p => path === p || path.startsWith(p + '/') || path.includes(p));

                if (isProtected && !hasToken) {
                    window.location.replace('/login');
                    return;
                }

                if ((path === '/login' || path === '/register' || path === '/') && hasToken) {
                    window.location.replace('/dashboard');
                    return;
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>