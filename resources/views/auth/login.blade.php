@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center vh-100" style="background: linear-gradient(135deg, #0f2027 0%, #2c5364 100%);">
    <div class="card p-4 shadow-lg border-0" style="min-width:340px; max-width:380px; background:rgba(20,20,20,0.95); border-radius:20px;">
        <div class="text-center mb-4">
            <h3 class="fw-bold mt-2 mb-0" style="color:#fff;">Login Admin NovaGoat</h3>
            <small class="text-secondary">Silakan masuk untuk melanjutkan</small>
        </div>
        <form id="loginForm" autocomplete="off">
    <div class="mb-3">
        <label class="form-label text-light">Username</label>
        <input type="text" name="username" class="form-control bg-black text-light border-secondary" placeholder="Username" required>
    </div>
    <div class="mb-3">
        <label class="form-label text-light">Password</label>
        <input type="password" name="password" class="form-control bg-black text-light border-secondary" placeholder="Password" required>
    </div>
    <button type="submit" class="btn btn-info w-100 fw-bold py-2 mt-2">Masuk</button>
    <div id="loginError" class="text-danger mt-2" style="display:none;"></div>
</form>
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
            window.location.href = '/dashboard';
        } else {
            document.getElementById('loginError').innerText = result.message || 'Login gagal';
            document.getElementById('loginError').style.display = 'block';
        }
    };
</script>
    </div>
</div>
<style>
    body { background: #000 !important; }
</style>
@endsection