<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="reaksi-btn1-"]').forEach(btn => {
            btn.addEventListener('click', function () {
                const reaksi1 = this.getAttribute('data-reaksi1');
                const storyId1 = this.getAttribute('data-artiestoriesid1');
                console.log('Reaksi:', reaksi1);
                console.log('Story ID:', storyId1);
                if (reaksi1 && storyId1) {
                    fetch("{{ route('uprcm0') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            reaksi: reaksi1,
                            artiestoriesid: storyId1
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