
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="reaksi-btn2-"]').forEach(btn => {
            btn.addEventListener('click', function () {
                const reaksi2 = this.getAttribute('data-reaksi2');
                const storyId2 = this.getAttribute('data-artiestoriesid2');
                if (reaksi2 && storyId2) {
                    fetch("{{ route('uprcm1') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            reaksi: reaksi2,
                            commentartiestoriesid: storyId2
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (!data.logged_in) {
                            sessionStorage.setItem('alert', data.alert);
                            sessionStorage.setItem('form', data.form);
                            window.location.href = data.redirect;
                            return;
                        }
                        if (data.csrf) {
                            document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf);
                        }
                    })
                    .catch(err => {
                    });
                } else {
                }
            });
        });
    });
</script>