
  <script>
    if (typeof window.pusher010 === 'undefined') {
        window.pusher010 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
    }
    if (typeof window.hapuscomment1 === 'undefined') {
        window.hapuscomment1 = window.pusher010.subscribe('hapuscomment1');
    }
    window.hapuscommenttime1 = null;
    window.haouscommentmore1 = true;
    window.hapuscomment1.bind('hapuscomment1', function (data) {
        if (data.id1) {
            if (window.haouscommentmore1) {
                const getwrapper = document.getElementById(`wrappercom3-${data.id1}`);
                const getreply1 = document.getElementById(`reply-${data.id1}`);
                const lihat = document.getElementById(`seerpl11-${data.id}`);
                const tutup = document.getElementById(`seerpl01-${data.id}`);
                function updateReplyCounter(element) {
                    const text = element.innerText;
                    const match = text.match(/\((\d+)\)/);
                    if (match) {
                        let count = parseInt(match[1]);
                        count -= 1;
                        if (count <= 0) {
                            element.innerText = element.innerText.replace(/\(\d+\)/, '');
                        } else {
                            element.innerText = element.innerText.replace(/\(\d+\)/, `(${count})`);
                        }
                    }
                }
                if (lihat && tutup) {
                    updateReplyCounter(lihat);
                    updateReplyCounter(tutup);
                }
                getwrapper.remove();
                getreply1.remove();
                clearTimeout(window.hapuscommenttime1);
                window.hapuscommenttime1 = setTimeout(() => {
                    window.haouscommentmore1 = true;
                }, 1000);
            }
        }
    });
  </script>