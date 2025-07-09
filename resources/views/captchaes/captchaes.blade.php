@vite(['resources/css/captchaes/captchaes.css', 'resources/js/captchaes/captchaes.js'])
<body data-show-form="{{ session('form') }}">
<div id="captcha-form" class="captcha-form hidden">
    <h2>CAPTCHA</h2>
    <form method="GET" action="{{ route('hapus.captcha') }}">
        <button class="close-btnes">x</button>
    </form>
    <form method="POST" action="{{ route('captcha.action') }}">
        @csrf
        <input type="hidden" name="rotasi1" id="rotasi1">
        <input type="hidden" name="rotasi2" id="rotasi2">
        <div id="img-rotate" class="img-rot">
            <img src="" id="img-rotate1" class="img-rotasi">
            <img src="" id="img-rotate2" class="img-rotasi">
        </div>

        <div class="btn-rotasi-container">
            <button type="button" class="btn-rotasi" id="rotasi-kiri"><</button>
            <button type="button" class="btn-rotasi" id="rotasi-kanan">></button>
        </div>

        @if(session('alert') && (session('form') === 'captcha' || !session('form')))
            <div class="feedback error">
                {{ session('alert') }}
            </div>
        @endif
        <button type="submit" class="btn-captcha">COCOKAN</button>
    </form>
</div>
<div id="captcha-form1" class="captcha-form hidden">
    <h2>CODE<br>CAPTCHA</h2>
    <form method="GET" action="{{ route('hapus.captcha') }}">
        <button class="close-btnes">x</button>
    </form>
    <form method="POST" action="{{ route('captcha1.action') }}">
        @csrf
        <div class="input-group">
            <label for="kode-verifikasi">Kode verifikasi</label>
            <input type="integer" name="kodeinputes" id="kode-verifikasi" placeholder="Masukkan kode verifikasi" required minlength="6">
        </div>
        @if(session('alert') && (session('form') === 'captcha1' || !session('form')))
            <div class="feedback error">
                {{ session('alert') }}
            </div>
        @endif
        <button type="submit" class="btn-captcha">VERIFIKASI</button>
    </form>
</div>
</body>