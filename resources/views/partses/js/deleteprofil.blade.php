<script>
  document.addEventListener('DOMContentLoaded', function () {
    const showBtn = document.getElementById('show-delete-confirm');
    const confirmCard = document.getElementById('delete-confirm-card');
    const cancelBtn = document.getElementById('cancel-delete');
    const gotoCaptcha = document.getElementById('goto-captcha');
    const captchaForm = document.getElementById('captcha-form');
    showBtn?.addEventListener('click', () => {
    fetch('/set-session-delete', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({})
    });
        confirmCard.classList.remove('hidden');
    });
    cancelBtn?.addEventListener('click', () => {
        confirmCard.classList.add('hidden');
    });
    gotoCaptcha?.addEventListener('click', () => {
        confirmCard.classList.add('hidden');
        captchaForm.classList.remove('hidden');
    });

    const body = document.querySelector('body');
    const showForm = body.dataset.showForm;
    if (showForm === 'captcha') {
        captchaForm.classList.remove('hidden');
    } else if (showForm === 'captcha1') {
        document.getElementById('captcha-form1').classList.remove('hidden');
    }
  });
</script><!-- delete account -->