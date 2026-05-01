@extends('layouts.app')

@section('content')
<style>
    .hero {
        height: 100vh;
        width: 100%;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.2)), 
                    url("{{ asset('images/photorealistic-sheep-farm.jpg') }}");
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        padding: 0 10%;
    }
    .goat-icon {
    height: 45px;
    width: auto;
    object-fit: contain;
    margin: 5px 0; 
}
    .hero-content { max-width: 600px; }
    .hero-content h1 { font-family: 'Playfair Display', serif; font-size: 5rem; line-height: 1; margin-bottom: 20px; }
    .hero-content p { font-size: 1rem; opacity: 0.8; margin-bottom: 40px; line-height: 1.6; }
    .btn-group { display: flex; gap: 15px; }
    .btn-login { padding: 12px 50px; border-radius: 35px; border: 1px solid white; background: transparent; color: white; cursor: pointer; transition: 0.3s; }
    .btn-register { padding: 12px 50px; border-radius: 35px; border: none; background: white; color: black; font-weight: 600; cursor: pointer; }
    .btn-login:hover { background: rgba(255,255,255,0.1); }
</style>

<div class="hero">
    <div class="hero-content">
        <h1>Peternakan<br>Pak Tarno</h1>
        <p>Kelola peternakan kambing Anda dengan sistem monitoring modern. Pantau pertumbuhan, pakan, dan kesehatan hewan ternak secara real-time.</p>
        <div class="btn-group">
            <a href="/login" class="btn-login text-decoration-none">Login</a>
        </div>
    </div>
</div>
@endsection