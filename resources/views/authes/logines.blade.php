<div id="login-form" class="login-card">
    <h2>LOGIN</h2>
    <form method="POST" action="{{ route('login.action') }}">
        @csrf
        <div class="input-group">
            <label for="username-login">Username atau Email</label>
            <input type="text" id="username-login" name="username" placeholder="Masukkan username atau Email" required>
        </div>
        <div class="input-group">
            <label for="password-login">Password</label>
            <input type="password" id="password-login" name="password" placeholder="Masukkan password" required>
        </div>
        @if(session('alert') && (session('form') === 'login' || !session('form')))
            <div class="feedback error">
                {{ session('alert') }}
            </div>
        @endif
        <button type="submit" class="btn-login">Login</button>
    </form>
    <p class="--link">
        Lupa akun?
        <a href="#" onclick="toggleForm('forget')">Balikin akun kamu</a>
    </p>
    <p class="--link">
        Belum punya akun?
        <a href="#" onclick="toggleForm('register')">Daftar</a>
    </p>
</div>