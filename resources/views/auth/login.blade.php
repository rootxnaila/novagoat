@extends('layouts.app')

@section('content')
<div id="loginContainer" class="d-flex align-items-center justify-content-center vh-100 modern-entrance" style="background: linear-gradient(-45deg, #801a0d, #b38012, #8c7a00, #66290d); background-size: 400% 400%; animation: gradientBG 10s ease infinite;">
    <div class="card p-4 shadow-lg border-0" style="min-width:340px; max-width:380px; background:rgba(20,20,20,0.9); backdrop-filter: blur(10px); border-radius:25px; border: 1px solid rgba(255, 255, 255, 0.1);">
        <div class="text-center mb-4">
            <h3 class="fw-bold mt-2 mb-0" style="color:#fff;">Login Admin NovaGoat</h3>
            <small class="text-light opacity-75">Silakan masuk untuk melanjutkan</small>
        </div>
        <form id="loginForm" autocomplete="off">
            <div class="mb-3">
                <label class="form-label text-light">Email atau Username</label>
                <input type="text" name="Email atau Username" class="form-control bg-dark text-light border-secondary" placeholder="Email atau Username" style="border-radius: 10px;" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-light">Password</label>
                <input type="password" name="password" class="form-control bg-dark text-light border-secondary" placeholder="Password" style="border-radius: 10px;" required>
            </div>
            <button type="submit" class="btn btn-warning w-100 fw-bold py-2 mt-2 btn-animate" style="border-radius: 10px; background: #f5af19; border: none; color: #000; position: relative; overflow: hidden;">Masuk</button>
            <div id="loginError" class="text-danger mt-2 text-center" style="display:none;"></div>
        </form>
    </div>
</div>

<style>
    body { background: #000 !important; margin: 0; overflow: hidden; }

    .modern-entrance {
        animation: modernIn 1s cubic-bezier(0.23, 1, 0.32, 1) forwards;
    }

    .modern-exit {
        animation: modernOut 0.8s cubic-bezier(0.7, 0, 0.3, 1) forwards !important;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .btn-animate {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .btn-animate:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 5px 15px rgba(245, 175, 25, 0.4);
    }

    .btn-animate:active {
        transform: translateY(0) scale(0.98);
    }

    .btn-animate::after {
        content: "";
        background: rgba(255, 255, 255, 0.3);
        display: block;
        position: absolute;
        padding-top: 300%;
        padding-left: 350%;
        margin-left: -20px !important;
        margin-top: -120%;
        opacity: 0;
        transition: all 0.8s;
    }

    .btn-animate:active::after {
        padding: 0;
        margin: 0;
        opacity: 1;
        transition: 0s;
    }

    @keyframes modernIn {
        from { opacity: 0; transform: scale(1.1); filter: blur(10px); }
        to { opacity: 1; transform: scale(1); filter: blur(0); }
    }

    @keyframes modernOut {
        to { clip-path: circle(0% at 50% 50%); opacity: 0; }
    }
</style>

<script>
    document.getElementById('loginForm').onsubmit = async function(e) {
        e.preventDefault();
        const form = e.target;
        const data = {
            username: form.username.value,
            password: form.password.value
        };
        const res = await fetch('/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if(result.status === 'success') {
            localStorage.setItem('token', result.data.token);
            localStorage.setItem('user', JSON.stringify(result.data.user));
            
            // Effect transition before redirect
            document.getElementById('loginContainer').classList.add('modern-exit');
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 800);
        } else {
            document.getElementById('loginError').innerText = result.message || 'Login gagal';
            document.getElementById('loginError').style.display = 'block';
        }
    };
</script>
@endsection