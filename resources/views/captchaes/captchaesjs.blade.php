@vite(['resources/css/captchaes/captchaes.css', 'resources/js/captchaes/captchaes.js'])
<div id="captchabody">
    <div id="captcha-form" class="captcha-form hidden">
        <h2>CAPTCHA</h2>
        <button class="close-btnes" id="close-btnes">x</button>
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
        <div class="feedback error hidden">
            {{ session('alert') }}
        </div>
        <button type="submit" id="rotate-captcha" class="btn-captcha">COCOKAN</button>
    </div>
    <div id="captcha-form1" class="captcha-form hidden">
        <h2>CODE<br>CAPTCHA</h2>
        <button class="close-btnes" id="close-btnes">x</button>
        @csrf
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
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rotate = document.getElementById("rotate-captcha");
        const rotasi1value = document.getElementById("rotasi1");
        const rotasi2value = document.getElementById("rotasi2");
        rotate.addEventListener('click', function () {
            const rotasi1 = rotasi1value.value.trim();
            const rotasi2 = rotasi2value.value.trim();
            fetch('/captchada', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ rotasi1, rotasi2 })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else if (data.requireCaptchadone) {
                    const captchaFormes = document.getElementById('captcha-form1');
                    const captchafirst = document.getElementById('captcha-form');
                    captchafirst.classList.add('hidden')
                    captchaFormes.classList.remove('hidden');
                } else if (data.requireCaptchalose) {
                    const getalert = document.getElementById('feedback');
                    getalert.innerText = data.alert;
                }
            })
        })
    })
</script><!-- captcha rotate -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const close = document.getElementById("close-btnes");
        close.addEventListener('click', function () {
            fetch('/hapus-captcha', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else if (data.closecaptcha) {
                    const captchaFormes = document.getElementById('captcha-form1');
                    const captchafirst = document.getElementById('captcha-form');
                    captchafirst.classList.add('hidden')
                    captchaFormes.classList.add('hidden');
                }
            })
        })
    })
</script><!-- captcha close -->