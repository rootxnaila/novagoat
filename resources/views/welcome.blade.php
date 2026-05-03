@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap');
    :root { --mint: #D6EDD7; --emerald: #1B4D1E; }
    
    body { font-family: 'Outfit', sans-serif; background: #0d150d; overflow: hidden; }

    .hero-container { 
        height: 100vh; position: relative; overflow: hidden; 
        animation: fadeIn 2s ease; transition: 0.6s cubic-bezier(0.7, 0, 0.3, 1);
    }
    
    .hero-container.exit-active { opacity: 0; filter: blur(20px); transform: scale(1.05); pointer-events: none; }

    .hero-bg { 
        position: absolute; inset: 0; z-index: 1;
        background: linear-gradient(to right, rgba(13,21,13,0.95) 15%, rgba(13,21,13,0.4) 50%, transparent), 
                    url('https://images.unsplash.com/photo-1524024973431-2ad916746881?q=80&w=1920') center/cover;
        animation: kenBurns 45s infinite alternate ease-in-out;
    }
    .overlay-glow { 
        position: absolute; inset: 0; z-index: 2; pointer-events: none;
        background: radial-gradient(circle at 20% 30%, rgba(214, 237, 215, 0.05), transparent 40%),
                    radial-gradient(circle at 80% 70%, rgba(45, 90, 39, 0.05), transparent 40%);
    }

    .hero-content { position: relative; z-index: 10; color: white; transition: 0.6s ease; padding-left: 5%; }
    .hero-container.exit-active .hero-content { transform: translateX(-50px); opacity: 0; }

    .hero-content h1 { font-size: clamp(2.2rem, 8vw, 5.5rem); font-weight: 800; line-height: 0.95; letter-spacing: -2px; }
    .hero-content h1 span { 
        background: linear-gradient(to bottom, #fff 20%, var(--mint) 90%); 
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: block; 
    }
    
    .badge-welcome { 
        display: inline-flex; align-items: center; padding: 6px 16px; border-radius: 100px;
        background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1);
        font-size: clamp(0.65rem, 2vw, 0.75rem); font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: var(--mint);
    }

    .btn-main { 
        position: relative; display: inline-flex; align-items: center; padding: 12px 35px; border-radius: 50px;
        background: var(--mint); color: var(--emerald); font-weight: 700; text-decoration: none;
        font-size: clamp(0.85rem, 2vw, 0.95rem);
        transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); box-shadow: 0 10px 25px rgba(45,90,39,0.15); overflow: hidden;
    }
    .btn-main:hover { transform: translateY(-4px) scale(1.02); background: #fff; box-shadow: 0 15px 35px rgba(45,90,39,0.25); }
    .btn-main::after { content: ''; position: absolute; inset: 0; left: -100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); transition: 0.6s; }
    .btn-main:hover::after { left: 100%; }
    
    .reveal { opacity: 0; transform: translateY(20px); animation: revealMove 0.8s ease forwards; will-change: transform, opacity; }
    
    @keyframes revealMove { to { opacity: 1; transform: translateY(0); } }
    @keyframes kenBurns { from { transform: scale(1); } to { transform: scale(1.1); } }
    @keyframes fadeIn { from { opacity: 0; filter: blur(15px); } to { opacity: 1; filter: blur(0); } }

    .copyright { 
        position: absolute; bottom: 30px; right: 40px; z-index: 10; 
        color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 300; 
        letter-spacing: 0.5px;
    }

    @media (max-width: 991.98px) {
        .hero-bg { background: linear-gradient(to bottom, rgba(13,21,13,0.85), rgba(13,21,13,0.4)), url('https://images.unsplash.com/photo-1524024973431-2ad916746881?q=80&w=1920') center/cover; }
        .hero-content { text-align: center; }
        .hero-content p { margin-inline: auto; font-size: 1rem !important; }
        .hero-content div.d-flex { justify-content: center; }
        .copyright { right: 0; left: 0; bottom: 20px; text-align: center; font-size: 0.75rem; }
    }
    @media (max-width: 576px) {
        .hero-content h1 { letter-spacing: -1px; }
        .btn-main { width: 100%; justify-content: center; padding: 14px 20px; }
    }
</style>

<div id="heroContainer" class="hero-container">
    <div class="hero-bg"></div>
    <div class="overlay-glow"></div>

    <div class="container-fluid h-100 position-relative z-3">
        <div class="row h-100 align-items-center px-3 px-md-5">
            <div class="col-12 col-lg-9 col-xl-8">
                <div class="hero-content">
                    <div class="badge-welcome reveal mb-4" style="animation-delay: 0.2s">
                        <i class="bi bi-patch-check-fill me-2"></i> Smart Goat Monitoring
                    </div>
                    
                    <h1 class="reveal mb-4" style="animation-delay: 0.35s">
                        Peternakan<br><span>Pak Tarno</span>
                    </h1>
                    
                    <p class="reveal mb-5 text-white fw-light" style="max-width: 500px; animation-delay: 0.5s; font-size: 1.1rem; line-height: 1.6;">
                        Sistem Informasi Manajemen dan Monitoring Penggemukan Kambing Terpadu
                    </p>
                    
                    <div class="reveal d-flex align-items-center gap-4" style="animation-delay: 0.65s">
                        <a href="/login" id="loginBtn" class="btn-main">
                            Login <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright reveal" style="animation-delay: 1.2s">
        &copy; 2026 NovaGoat Team - Universitas Negeri Malang
    </div>
</div>

<script>
    const container = document.getElementById('heroContainer');
    const loginBtn = document.getElementById('loginBtn');

    if (loginBtn) {
        loginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const targetUrl = this.getAttribute('href');
            container.classList.add('exit-active');
            setTimeout(() => { window.location.href = targetUrl; }, 600);
        });
    }

    window.addEventListener('pageshow', function(event) {
        if (container.classList.contains('exit-active')) {
            container.classList.remove('exit-active');
        }
    });
</script>
@endsection