<div id="register-form" class="login-card hidden">
    <h2 class="registertxt">REGISTER</h2>
    <form method="POST" action="{{ route('register.action') }}">
        @csrf
        <div class="input-group">
            <label for="username-register">Username</label>
            <input type="text" name="username" value="{{ old('username') }}" id="username-register" placeholder="Masukkan username" required maxlength="30">
        </div>
        <div class="input-group">
            <label for="nameuse">Nama Artieses</label>
            <input type="text" name="nameuse" value="{{ old('nameuse') }}" id="nameuse" placeholder="Masukkan nama artieses kamu" required maxlength="30">
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" id="email" placeholder="Masukkan email" required>
        </div>
        <div class="input-group">
            <label for="password-register">Password</label>
            <input type="password" name="password" value="{{ old('password') }}" id="password-register" placeholder="Masukkan password" required minlength="6">
        </div>
        <div class="input-group">
            <label for="password_confirmation">Masukkan Ulang Password</label>
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" id="password_confirmation" placeholder="Masukkan ulang password" required minlength="6">
        </div>
        @if(session()->has('alert') && session()->get('form') === 'register')
            <div class="feedback error">
                {{ session()->get('alert') }}
            </div>
        @endif

        <div class="input-group">
            <button type="submit" class="btn-regis">Buat Akun</button>
        </div>
    </form>
    <p class="--link">  
        Sudah punya akun?
        <a href="#" onclick="toggleForm('login')">Login</a>
    </p>
</div>