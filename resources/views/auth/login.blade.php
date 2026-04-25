@extends('layouts.app') @section('content')
<div class="login-container">
    <div class="glass-card">
        <h2>Login Admin NovaGoat</h2>
        <form action="#" method="POST"> @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Masuk</button>
        </form>
    </div>
</div>
@endsection