
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="reaksi-btn2-"]').forEach(btn => {
            btn.addEventListener('click', function () {
                const reaksi2 = this.getAttribute('data-reaksi2');
                const storyId2 = this.getAttribute('data-artiestoriesid2');
                console.log('Reaksi:', reaksi2);
                console.log('Story ID:', storyId2);
                if (reaksi2 && storyId2) {
                    fetch("{{ route('uprcm0') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            reaksi: reaksi2,
                            artiestoriesid: storyId2
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