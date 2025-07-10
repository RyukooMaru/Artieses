
  <script>
    if (typeof window.pusher01 === 'undefined') {
        window.pusher01 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
    }
    if (typeof window.hapuscomment1 === 'undefined') {
        window.hapuscomment1 = window.pusher01.subscribe('hapuscomment1');
    }
    window.hapuscommenttime1 = null;
    window.haouscommentmore1 = true;
    window.hapuscomment1.bind('hapuscomment1', function (data) {
        if (data.message && data.message !== "") {
            if (window.haouscommentmore1) {
                const getwrapper = document.querySelector(`.wrappercom3-${data.commentid}`);
                const getreply1 = document.querySelector(`.reply-${data.commentid}`);
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