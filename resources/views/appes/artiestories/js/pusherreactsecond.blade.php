
  <script>
    if (typeof window.react1 === 'undefined') {
        window.react1 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
    }
    if (typeof window.react1 === 'undefined') {
        window.react1 = window.pusherreact1.subscribe('react1');
    }
    window.reacttime1 = null;
    window.reactmore1 = true;
    window.react1.bind('react1', function (data) {
        if (data.reqplat) {
            if (window.reactmore1) {
                const p = document.getElementById(`rbtnry5-${data.reqplat}`);
                p.remove();
                let cekr6 = document.getElementById(`rbtnry6-${data.reqplat}`);
                if (!cekr6) {
                    const rbtnry6 = document.createElement('div');
                    rbtnry6.className = `iclikeswrap rbtnry6-${data.reqplat}`;
                    rbtnry6.id = `rbtnry6-${data.reqplat}`;
                    document.getElementById('parent-container').appendChild(rbtnry6);
                    cekr6 = rbtnry6;
                }
                if (cekr6) {
                    const cekemote = document.getElementById(`iclikeswrapimg-${data.reaksi}`);
                    if (!cekemote) {
                        const rimg = document.createElement('img');
                        rimg.src = `/partses/reaksi/${data.reaksi}.png`;
                        rimg.id = `iclikeswrapimg-${data.reaksi}`;
                        cekr6.appendChild(rimg);
                    }
                }
                clearTimeout(window.reacttime1);
                window.reacttime1 = setTimeout(() => {
                    window.reactmore1 = true;
                }, 1000);
            }
        }
    });
  </script>