@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap');
    :root { --mint: #D6EDD7; --emerald: #1B4D1E; }
    
    body { font-family: 'Outfit', sans-serif; background: #0d150d; overflow: hidden; }

    .hero-container { height: 100vh; display: flex; align-items: center; position: relative; overflow: hidden; animation: fadeIn 2.5s ease; }
    .hero-bg { 
        position: absolute; inset: 0; z-index: 1;
        background: linear-gradient(to right, rgba(13,21,13,0.9) 15%, rgba(13,21,13,0.3) 50%, transparent), 
                    url('https://images.unsplash.com/photo-1524024973431-2ad916746881?q=80&w=1920') center/cover;
        animation: kenBurns 45s infinite alternate ease-in-out;
    }
    .overlay-glow { 
        position: absolute; inset: 0; z-index: 2; pointer-events: none;
        background: radial-gradient(circle at 20% 30%, rgba(214,237,215,0.05), transparent 40%),
                    radial-gradient(circle at 80% 70%, rgba(45,90,39,0.05), transparent 40%);
    }

    .hero-content { position: relative; z-index: 10; padding-left: 10%; max-width: 850px; color: white; }
    .hero-content h1 { font-size: clamp(3.5rem, 8vw, 6.5rem); font-weight: 800; line-height: 0.95; letter-spacing: -3px; }
    .hero-content h1 span { background: linear-gradient(#fff 30%, var(--mint)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: block; }
    
    .badge-welcome { 
        display: inline-flex; align-items: center; padding: 6px 16px; border-radius: 100px;
        background: rgba(255,255,255,0.08); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);
        font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: var(--mint);
    }

    .btn-main { 
        position: relative; display: inline-flex; align-items: center; padding: 12px 35px; border-radius: 50px;
        background: var(--mint); color: var(--emerald); font-weight: 700; text-decoration: none;
        transition: 0.4s; box-shadow: 0 10px 25px rgba(45,90,39,0.15); overflow: hidden;
    }
    .btn-main:hover { transform: translateY(-4px); background: #fff; box-shadow: 0 15px 35px rgba(45,90,39,0.25); }
    .btn-main::after { content: ''; position: absolute; inset: 0; left: -100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); transition: 0.6s; }
    .btn-main:hover::after { left: 100%; }
    
    .reveal { opacity: 0; transform: translateY(20px); animation: revealMove 0.8s ease forwards; will-change: transform, opacity; }
    .reveal-left { transform: translateX(-50px); animation-name: revealSlide; }
    
    @keyframes revealMove { to { opacity: 1; transform: translateY(0); } }
    @keyframes revealSlide { to { opacity: 1; transform: translateX(0); } }
    @keyframes kenBurns { from { transform: scale(1); } to { transform: scale(1.1); } }
    @keyframes fadeIn { from { opacity: 0; filter: blur(10px); } to { opacity: 1; filter: blur(0); } }

    @media (max-width: 992px) {
        .hero-content { padding: 0 5%; text-align: center; max-width: 100%; }
        .hero-bg { background-position: 75% center; }
    }
</style>

<div class="hero-container">
    <div class="hero-bg"></div>
    <div class="overlay-glow"></div>

    <div class="hero-content">
        <div class="badge-welcome reveal mb-4" style="animation-delay: 0.1s">
            <i class="bi bi-patch-check-fill me-2"></i> Smart Goat Monitoring
        </div>
        
        <h1 class="reveal reveal-left mb-4" style="animation-delay: 0.3s">
            Peternakan<br><span>Pak Tarno</span>
        </h1>
        
        <p class="reveal mb-5 text-white-50 fs-5 fw-light" style="max-width: 500px; animation-delay: 0.5s">
            Sistem Informasi Manajemen dan Monitoring Penggemukan Kambing Terpadu
        </p>
        
        <div class="reveal d-flex align-items-center gap-4" style="animation-delay: 0.7s">
            <a href="/login" class="btn-main">
                Login <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</div>
@endsection