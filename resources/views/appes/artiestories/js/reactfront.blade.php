<script>
    if (typeof window.pusherreact === 'undefined') {
        window.pusherreact = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true,
            logToConsole: true
        });
    }
    if (typeof window.channelreact === 'undefined') {
        window.channelreact = window.pusherreact.subscribe('.refr');
    }
    if (!window.channelBoundreact) {
        window.channelreact.bind('.refr', function (data) {
            if (data.message && data.message !== "") {
                document.querySelectorAll('[id^="iclikeswrap1-"]').forEach(function (el) {
                    const id = el.id.replace('iclikeswrap1-', '');
                    const getsrcard = document.getElementById('iclikeswrap-' + id);
                    const havesrcard = document.getElementById('iclikeswrap1-' + id);
                    if (!getsrcard && havesrcard) {
                        const divic = document.createElement('div');
                        divic.className = "iclikeswrap";
                        divic.id = "iclikeswrap-" + id;
                        havesrcard.appendChild(divic);
                    } else if (getsrcard && data && data.reaksi && data.code) {
                        const checkreact = document.getElementById(`iclikeswraperact-${data.reaksi}-${data.code}`);
                        if (!checkreact) {
                            const newreact = document.createElement('img');
                            newreact.src = `/partses/reaksi/${data.reaksi}.png`;
                            newreact.className = "iclikestories";
                            newreact.id = `iclikeswraperact-${data.reaksi}-${data.code}`;
                            getsrcard.appendChild(newreact);
                        }
                    }
                });
            }
        })
        window.channelBoundreact = true;
    }
</script>