<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Artieses</title>
  <link rel="stylesheet" href="{{ asset('css/authes/authes.css') }}">
  <link rel="icon" href="{{ asset('partses/favicon.ico') }}">
</head>
<body class="timess" data-show-form="{{ session('showForm') ?? session('form') ?? ($errors->any() ? 'register' : 'login') }}">
  <div class="locardes">
  <div class="cardbg">
    <div class="locard-left">
      <img id="gifImage" src="{{ asset('partses/ico.gif') }}" class="gifet"/>
    </div>
      <div class="locard-right">
        @include('authes.logines')
        @include('authes.registeres')
        @include('authes.forgetes')
      </div>
    </div>
  </div>
  @include('captchaes.captchaes')
  <footer class="footeresauth">
    <p>&copy; {{ date('Y') }} Artieses by Kelompok 10.</p>
  </footer>
</body>
  <script>
    var iconPath = "{{ asset('partses/icon.png') }}";
  </script>
  <script src="{{ asset('js/authes/authes.js') }}"></script>
  <script>
document.addEventListener('DOMContentLoaded', function () {
    const alert = sessionStorage.getItem('alert');
    const form = sessionStorage.getItem('form');

    if (alert) {
        fetch("{{ route('set.alert.session') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                alert: alert,
                form: form
            })
        }).then(() => {
            sessionStorage.removeItem('alert');
            sessionStorage.removeItem('form');
            window.location.reload();
        });
    }
});
</script>
</html>