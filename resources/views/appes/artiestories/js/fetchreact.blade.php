
  <script>
    document.addEventListener('click', function (e) {
        const target = e.target;
        if (target.id?.startsWith('reaksi-btn2-')) {
            const idParts = target.id.split('-');
            const storyId2 = idParts.slice(2).join('-');
            const reaksi2 = target.getAttribute('data-reaksi2');
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
                    if (!data.logged_in) {
                        sessionStorage.setItem('alert', data.alert);
                        sessionStorage.setItem('form', data.form);
                        window.location.href = data.redirect;
                        return;
                    }
                    if (data.csrf) {
                        document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf);
                    }
                });
            }
        }
    });
  </script>