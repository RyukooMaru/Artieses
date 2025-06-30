<div id="lupakan" class="login-card hidden">
    <h2>LUPA AKUN</h2>
    <form method="POST" action="{{ route('forget.action') }}">
        @csrf
        <div class="input-group">
            <label for="username-email">Username</label>
            <input type="text" id="username-email" name="usemail" placeholder="Masukkan username atau email" required>
        </div>
        @if(session('alert') && (session('form') === 'forget' || !session('form')))
            <div class="feedback error">
                {{ session('alert') }}
            </div>
        @endif
        <button type="submit" class="btn-login">Cari akun</button>
    </form>
    <p class="--link">
        Ingat akun?
        <a href="#" onclick="toggleForm('login')">Kembali ke login</a>
    </p>
</div>

<div id="kembalikan" class="login-card hidden">
    <h2>LUPA AKUN</h2>
    <form method="POST" action="{{ route('forget1.action') }}">
        @csrf
        <div class="input-group">
            <label for="password-register">Password</label>
            <input type="password" name="password" value="{{ old('password') }}" id="password-register" placeholder="Masukkan password" required minlength="6">
        </div>
        <div class="input-group">
            <label for="password_confirmation">Masukkan Ulang Password</label>
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" id="password_confirmation" placeholder="Masukkan ulang password" required minlength="6">
        </div>
        @if(session('alert') && (session('form') === 'forget1' || !session('form')))
            <div class="feedback error">
                {{ session('alert') }}
            </div>
        @endif
        <button type="submit" class="btn-login">Cari akun</button>
    </form>
    <p class="--link">
        Ingat akun?
        <a href="{{ route('authes') }}" onclick="toggleForm('login')">Kembali ke login</a>
    </p>
</div>