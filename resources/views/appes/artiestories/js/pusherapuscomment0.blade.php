
  <script>
    if (typeof window.pusher02 === 'undefined') {
        window.pusher02 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
    }
    if (typeof window.hapuscomment === 'undefined') {
        window.hapuscomment = window.pusher02.subscribe('hapuscomment');
    }
    window.hapuscommenttime = null;
    window.haouscommentmore = true;
    window.hapuscomment.bind('hapuscomment', function (data) {
        if (data.message && data.message !== "") {
            if (window.haouscommentmore) {
                const getwrapper = document.querySelector(`.commentwrapcom-${data.commentid}`);
                getwrapper.remove();
                clearTimeout(window.hapuscommenttime);
                window.hapuscommenttime = setTimeout(() => {
                    window.haouscommentmore = true;
                }, 1000);
            }
        }
    });
  </script>