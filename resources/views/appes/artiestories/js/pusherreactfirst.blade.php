
  <script>
    if (typeof window.pusherreact === 'undefined') {
        window.pusherreact = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
    }
    if (typeof window.pusherreact === 'undefined') {
        window.pusherreact = window.pusherreact.subscribe('pusherreact');
    }
    window.pusherreacttime = null;
    window.pusherreactmore = true;
    window.pusherreact.bind('pusherreact', function (data) {
        if (data.reqplat) {
            if (window.pusherreactmore) {
                const p = document.getElementById(`rbtnry3-${data.reqplat}`);
                p.remove();
                let cekr4 = document.getElementById(`rbtnry4-${data.reqplat}`);
                if (!cekr4) {
                    const rbtnry4 = document.createElement('div');
                    rbtnry4.className = `iclikeswrap rbtnry4-${data.reqplat}`;
                    rbtnry4.id = `rbtnry4-${data.reqplat}`;
                    document.getElementById('parent-container').appendChild(rbtnry4);
                    cekr4 = rbtnry4;
                }
                if (cekr4) {
                    const cekemote = document.getElementById(`iclikeswrapimg-${data.reaksi}`);
                    if (!cekemote) {
                        const rimg = document.createElement('img');
                        rimg.src = `/partses/reaksi/${data.reaksi}.png`;
                        rimg.id = `iclikeswrapimg-${data.reaksi}`;
                        cekr4.appendChild(rimg);
                    }
                }
                clearTimeout(window.pusherreacttime);
                window.pusherreacttime = setTimeout(() => {
                    window.pusherreactmore = true;
                }, 1000);
            }
        }
    });
  </script>