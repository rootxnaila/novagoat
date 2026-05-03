@extends('layouts.app')

@section('content')
<div id="loginContainer" class="login-wrapper d-flex align-items-center justify-content-center vh-100">
    <div class="card login-card p-4 shadow-lg border-0 card-entrance glass-card">
        {{-- Header Section --}}
        <div class="text-center mb-4 reveal-item" style="--delay: 0.1s;">
            <div class="logo-container mb-3 d-inline-flex align-items-center justify-content-center rounded-circle">
                <img src="{{ asset('images/logo kambiang.png') }}" alt="Logo" class="logo-img">
            </div>
            <h3 class="fw-bold mb-1 header-title">Login NovaGoat</h3>
            <p class="text-secondary small mb-0 opacity-75">Silakan masuk untuk melanjutkan akses</p>
        </div>
        
        <form id="loginForm" autocomplete="off">
            <div class="mb-3 reveal-item" style="--delay: 0.2s;">
                <label class="form-label custom-label">Username</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text border-0 bg-transparent ps-3 pe-0">
                        <i class="bi bi-person text-secondary"></i>
                    </span>
                    <input type="text" name="username" class="form-control border-0 bg-transparent shadow-none py-3" placeholder="Masukkan username" required>
                </div>
            </div>
            
            <div class="mb-4 reveal-item" style="--delay: 0.3s;">
                <label class="form-label custom-label">Password</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text border-0 bg-transparent ps-3 pe-0">
                        <i class="bi bi-lock text-secondary"></i>
                    </span>
                    <input type="password" name="password" id="passwordInput" class="form-control border-0 bg-transparent shadow-none py-3" placeholder="Masukkan password" required>
                    <button class="btn border-0 bg-transparent pe-3" type="button" id="togglePasswordBtn" tabindex="-1">
                        <i id="eyeIcon" class="bi bi-eye text-secondary opacity-50"></i>
                        <i id="eyeSlashIcon" class="bi bi-eye-slash text-secondary d-none opacity-50"></i>
                    </button>
                </div>
            </div>

            <div class="reveal-item" style="--delay: 0.4s;">
                <button type="submit" class="btn btn-login w-100 fw-bold py-3 shadow border-0 position-relative overflow-hidden">
                    <span class="btn-text">Masuk Sekarang</span>
                    <div class="btn-shine"></div>
                </button>
            </div>

            <div id="loginError" class="text-danger mt-3 text-center small fw-bold" style="display:none;"></div>
        </form>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap');

    :root {
        --primary-green: #2d5a27;
        --secondary-green: #3e7b36;
        --bg-gray: #ced4da;
    }

    body { margin: 0; font-family: 'Outfit', sans-serif; overflow: hidden; background-color: var(--bg-gray); }

    .login-wrapper {
        background: radial-gradient(at 0% 0%, #cbd5e0 0, transparent 50%), 
                    radial-gradient(at 50% 0%, #e2e8f0 0, transparent 50%), 
                    radial-gradient(at 100% 0%, #ced4da 0, transparent 50%), 
                    radial-gradient(at 0% 100%, rgba(45, 90, 39, 0.08) 0, transparent 50%), 
                    radial-gradient(at 100% 100%, rgba(62, 123, 54, 0.08) 0, transparent 50%), 
                    var(--bg-gray);
    }

    .login-card {
        width: 100%;
        max-width: 400px;
        border-radius: 30px;
        will-change: transform, opacity;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.7) !important;
        backdrop-filter: blur(20px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
        border: 1px solid rgba(255, 255, 255, 0.4) !important;
    }

    .logo-container {
        width: 100px; 
        height: 100px;
        background-color: rgba(45, 90, 39, 0.1);
    }

    .logo-img {
        height: 60px; 
        width: auto; 
        filter: brightness(0) saturate(100%) invert(26%) sepia(54%) saturate(541%) hue-rotate(66deg) brightness(92%) contrast(88%);
    }

    .header-title {
        color: #1a3a1a;
        letter-spacing: -1px;
    }

    .custom-label {
        font-size: 0.75rem; 
        color: #444; 
        margin-bottom: 6px; 
        letter-spacing: 0.5px; 
        text-transform: uppercase;
        font-weight: 700;
    }

    /* Animations */
    .card-entrance {
        opacity: 0;
        animation: cardFadeIn 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    @keyframes cardFadeIn {
        from { opacity: 0; transform: scale(0.94) translateY(30px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .reveal-item {
        opacity: 0;
        transform: translateY(20px);
        will-change: transform, opacity;
        animation: itemReveal 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        animation-delay: var(--delay);
    }

    @keyframes itemReveal {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Input & Button Styles */
    .custom-input-group {
        background-color: rgba(255, 255, 255, 0.5) !important;
        border: 1.5px solid rgba(0, 0, 0, 0.05) !important;
        border-radius: 16px !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .custom-input-group input { font-size: 0.9rem; }

    .custom-input-group:focus-within {
        background-color: #ffffff !important;
        border-color: var(--primary-green) !important;
        box-shadow: 0 8px 20px rgba(45, 90, 39, 0.08) !important;
        transform: translateY(-2px);
    }

    .btn-login {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)) !important;
        color: white !important;
        font-size: 0.95rem;
        border-radius: 16px !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(45, 90, 39, 0.3) !important;
        filter: brightness(1.1);
    }

    .btn-login:active { transform: translateY(-1px) scale(0.98); }

    .btn-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 50%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
        transform: skewX(-25deg);
        transition: 0.75s;
    }

    .btn-login:hover .btn-shine { left: 125%; }
</style>

<script>
    document.getElementById('loginForm').onsubmit = async function(e) {
        e.preventDefault();
        const form = e.target;
        const btn = form.querySelector('button[type="submit"]');
        const btnText = btn.querySelector('.btn-text');
        
        btn.disabled = true;
        btnText.innerText = 'Memproses...';

        const data = {
            username: form.username.value,
            password: form.password.value
        };

        try {
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });
            const result = await res.json();
            
            if(result.status === 'success') {
                localStorage.setItem('token', result.data.token);
                localStorage.setItem('user', JSON.stringify(result.data.user));
                
                const container = document.getElementById('loginContainer');
                container.style.transition = 'all 1s cubic-bezier(0.7, 0, 0.3, 1)';
                container.style.opacity = '0';
                container.style.transform = 'scale(1.05)';
                container.style.filter = 'blur(10px)';
                
                setTimeout(() => {
                    if (result.data.user.role === 'admin') {
                        window.location.href = '/dashboard';
                    } else {
                        window.location.href = '/katalog'; 
                    }
                }, 1000);
            } else {
                showError(result.message || 'Login gagal');
                btn.disabled = false;
                btnText.innerText = 'Masuk Sekarang';
            }
        } catch (error) {
            showError('Terjadi kesalahan sistem');
            btn.disabled = false;
            btnText.innerText = 'Masuk Sekarang';
        }
    };

    function showError(msg) {
        const errEl = document.getElementById('loginError');
        errEl.innerText = msg;
        errEl.style.display = 'block';
    }

    document.getElementById('togglePasswordBtn').addEventListener('click', function() {
        const passInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');
        
        const isPass = passInput.type === 'password';
        passInput.type = isPass ? 'text' : 'password';
        eyeIcon.classList.toggle('d-none', isPass);
        eyeSlashIcon.classList.toggle('d-none', !isPass);
    });
</script>
@endsection