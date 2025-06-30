<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="reaksi-btn-"]').forEach(btn => {
            btn.addEventListener('click', function () {
                const reaksi = this.getAttribute('data-reaksi');
                const storyId = this.getAttribute('data-artiestoriesid');
                console.log('Reaksi:', reaksi);
                console.log('Story ID:', storyId);
                if (reaksi && storyId) {
                    fetch("{{ route('uprcm0') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            reaksi: reaksi,
                            artiestoriesid: storyId
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
                        console.log(data.message);
                        if (data.csrf) {
                            document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf);
                        }
                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                    });
                } else {
                    console.error('Reaksi atau Story ID tidak valid!');
                }
            });
        });
    });
</script>