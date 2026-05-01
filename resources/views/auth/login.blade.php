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
                <input type="text" name="username" class="form-control bg-dark text-light border-secondary" placeholder="Email atau Username" style="border-radius: 10px;" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-light">Password</label>
                <div class="input-group" style="border-radius: 10px; overflow: hidden; border: 1px solid #6c757d;">
                    <input type="password" name="password" id="passwordInput" class="form-control bg-dark text-light border-0 shadow-none" placeholder="Password" required>
                    <button class="btn border-0 d-flex align-items-center justify-content-center" type="button" id="togglePasswordBtn" style="background: #212529; width: 45px;" tabindex="-1">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#f5af19" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                        </svg>
                        <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#f5af19" class="bi bi-eye-slash d-none" viewBox="0 0 16 16">
                            <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l-.708-.709z"/>
                            <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"/>
                            <path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-warning w-100 fw-bold py-2 mt-2 btn-animate" style="border-radius: 10px; background: #f5af19; border: none; color: #000; position: relative; overflow: hidden;">Masuk</button>
            <div class="text-center mt-3">
                <a href="/register" class="text-light opacity-75 hover-opacity-100" style="text-decoration: none; font-size: 0.85rem; transition: 0.3s;">Belum punya akun? Daftar di sini</a>
            </div>
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
                
                // Effect transition before redirect
                document.getElementById('loginContainer').classList.add('modern-exit');
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 800);
            } else {
                document.getElementById('loginError').innerText = result.message || 'Login gagal';
                document.getElementById('loginError').style.display = 'block';
            }
        } catch (error) {
            document.getElementById('loginError').innerText = 'Terjadi kesalahan sistem: ' + error.message;
            document.getElementById('loginError').style.display = 'block';
        }
    };

    document.getElementById('togglePasswordBtn').addEventListener('click', function() {
        const passInput = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eyeIcon');
        const eyeSlashIcon = document.getElementById('eyeSlashIcon');
        
        if (passInput.type === 'password') {
            passInput.type = 'text';
            eyeIcon.classList.add('d-none');
            eyeSlashIcon.classList.remove('d-none');
        } else {
            passInput.type = 'password';
            eyeIcon.classList.remove('d-none');
            eyeSlashIcon.classList.add('d-none');
        }
    });
</script>
@endsection