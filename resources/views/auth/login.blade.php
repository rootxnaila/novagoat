@extends('layouts.app')

@section('content')
<div id="loginContainer" class="login-wrapper d-flex align-items-center justify-content-center vh-100">
    <div class="card login-card p-4 shadow-lg border-0 reveal glass-card">
        <div class="text-center mb-4 reveal" style="animation-delay: 0.1s;">
            <div class="logo-container mb-3 d-inline-flex align-items-center justify-content-center rounded-circle">
                <img src="{{ asset('images/logo kambiang.png') }}" alt="Logo" class="logo-img">
            </div>
            <h3 class="fw-bold mb-1 header-title">Login Nova Goat</h3>
            <p class="text-secondary small opacity-75">Silakan masuk untuk melanjutkan akses</p>
        </div>
    
        <form id="loginForm" autocomplete="off">
            <div class="mb-3 reveal" style="animation-delay: 0.2s;">
                <label class="custom-label">Username</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text border-0 bg-transparent ps-3"><i class="bi bi-person text-secondary"></i></span>
                    <input type="text" name="username" class="form-control border-0 bg-transparent shadow-none py-3" placeholder="Masukkan username" required>
                </div>
            </div>
            
            <div class="mb-4 reveal" style="animation-delay: 0.3s;">
                <label class="custom-label">Password</label>
                <div class="input-group custom-input-group">
                    <span class="input-group-text border-0 bg-transparent ps-3"><i class="bi bi-lock text-success"></i></span>
                    <input type="password" name="password" id="passwordInput" class="form-control border-0 bg-transparent shadow-none py-3" placeholder="Masukkan password" required>
                    <button class="btn border-0 bg-transparent pe-3" type="button" id="togglePasswordBtn" tabindex="-1">
                        <i id="eyeIcon" class="bi bi-eye text-success fs-5"></i>
                        <i id="eyeSlashIcon" class="bi bi-eye-slash text-success fs-5 d-none"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 fw-bold py-3 shadow-sm border-0 position-relative overflow-hidden reveal" style="animation-delay: 0.4s;">
                <span class="btn-text">Masuk Sekarang</span>
                <div class="btn-shine"></div>
            </button>

            <div id="loginError" class="text-danger mt-3 text-center small fw-bold" style="display:none;"></div>
        </form>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap');
    :root { --primary: #2d5a27; --secondary: #3e7b36; }
    body { font-family: 'Outfit', sans-serif; overflow: hidden; background: #ced4da; }

    .login-wrapper {
        background: radial-gradient(at 0% 0%, #cbd5e0, transparent 50%), 
                    radial-gradient(at 100% 0%, #ced4da, transparent 50%), 
                    radial-gradient(at 0% 100%, rgba(45,90,39,0.08), transparent 50%), 
                    radial-gradient(at 100% 100%, rgba(62,123,54,0.08), transparent 50%), #ced4da;
    }

    .login-card { width: 100%; max-width: 400px; border-radius: 30px; background: rgba(255,255,255,0.8) !important; backdrop-filter: blur(20px) saturate(180%); border: 1px solid rgba(255,255,255,0.4) !important; }
    .logo-container { width: 100px; height: 100px; background: rgba(45,90,39,0.1); }
    .logo-img { height: 60px; filter: brightness(0) invert(26%) sepia(54%) saturate(541%) hue-rotate(66deg); }
    
    .header-title { color: #1a3a1a; letter-spacing: -1px; }
    .custom-label { font-size: 0.75rem; color: #444; margin-bottom: 6px; letter-spacing: 0.5px; text-transform: uppercase; font-weight: 700; display: block; }

    .custom-input-group { background: rgba(255,255,255,0.6) !important; border: 1.5px solid rgba(0,0,0,0.05) !important; border-radius: 16px; transition: 0.3s; }
    .custom-input-group:focus-within { background: #fff !important; border-color: var(--primary) !important; box-shadow: 0 8px 20px rgba(45,90,39,0.08) !important; transform: translateY(-2px); }

    .btn-login { background: linear-gradient(135deg, var(--primary), var(--secondary)) !important; color: #fff !important; border-radius: 16px; transition: 0.4s; }
    .btn-login:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(45,90,39,0.3) !important; filter: brightness(1.1); }
    .btn-shine { position: absolute; inset: 0; left: -100%; width: 50%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transform: skewX(-25deg); transition: 0.75s; }
    .btn-login:hover .btn-shine { left: 125%; }

    .reveal { opacity: 0; transform: translateY(20px); animation: revealUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
    @keyframes revealUp { to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    document.getElementById('loginForm').onsubmit = async function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        const btnText = btn.querySelector('.btn-text');
        
        btn.disabled = true;
        btnText.innerText = 'Memproses...';

        try {
            const res = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ username: this.username.value, password: this.password.value })
            });
            const result = await res.json();
            
            if(result.status === 'success') {
                localStorage.setItem('token', result.data.token);
                localStorage.setItem('user', JSON.stringify(result.data.user));
                
                const container = document.getElementById('loginContainer');
                Object.assign(container.style, { transition: '1s ease', opacity: '0', transform: 'scale(1.05)', filter: 'blur(10px)' });
                
                setTimeout(() => window.location.href = result.data.user.role === 'Admin' ? '/dashboard' : '/katalog', 1000);
            } else {
                throw new Error(result.message || 'Login gagal');
            }
        } catch (error) {
            const errEl = document.getElementById('loginError');
            errEl.innerText = error.message;
            errEl.style.display = 'block';
            btn.disabled = false;
            btnText.innerText = 'Masuk Sekarang';
        }
    };

    document.getElementById('togglePasswordBtn').onclick = function() {
        const passInput = document.getElementById('passwordInput');
        const isPass = passInput.type === 'password';
        passInput.type = isPass ? 'text' : 'password';
        document.getElementById('eyeIcon').classList.toggle('d-none', isPass);
        document.getElementById('eyeSlashIcon').classList.toggle('d-none', !isPass);
    };
</script>
@endsection