
  <script>
    if (typeof window.react === 'undefined') {
        window.react = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
    }
    if (typeof window.react === 'undefined') {
        window.react = window.react.subscribe('react');
    }
    window.reacttime = null;
    window.reactmore = true;
    window.react.bind('react', function (data) {
        if (data.reqplat) {
            if (window.reactmore) {
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
                clearTimeout(window.reacttime);
                window.reacttime = setTimeout(() => {
                    window.reactmore = true;
                }, 1000);
            }
        }
    });
  </script>