
  <script>
    if (typeof window.pusher01 === 'undefined') {
        window.pusher01 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
    }
    if (typeof window.hapuscomment === 'undefined') {
        window.hapuscomment = window.pusher01.subscribe('typing1');
    }
    window.typingTimeout3 = null;
    window.canFetchTyping3 = true;
    window.hapuscomment.bind('user1', function (data) {
        if (data.message && data.message !== "") {
            if (window.canFetchTyping3) {
                getChat.classList.remove('hidden');
                clearTimeout(window.typingTimeout3);
                window.typingTimeout3 = setTimeout(() => {
                    window.canFetchTyping3 = true;
                }, 1000);
            }
        }
    });
  </script>