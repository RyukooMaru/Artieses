<!DOCTYPE html>
<html>
<head>
    <title>Chat Typing Broadcast</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/appes/artiestories.css') }}">
</head>
<body>
    <h2>Halo, {{ session('username') }}</h2>
    <input type="text" id="message" placeholder="Ketik pesan..." onkeydown="checkEnter(event)">
    <p id="typing-indicator"></p>
    <div id="chat-log"></div>
    <div id="chat-container"></div>
    <script>
        const input = document.getElementById('message');
        function checkEnter(event) {
        const message = input.value.trim();

        if (event.key === 'Enter') {
            const messeji = document.getElementById('message');
            messeji.value = "";
            fetch('/broadcast-typing', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message })
            }).then(res => res.json())
            .then(data => {
                input.value = '';
                console.log('Sent:', data);
            });
        } else {
            fetch('/broadcast-typing', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message: "" })
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        Pusher.logToConsole = true;
        const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
        const channel = pusher.subscribe('typing-channel');
        channel.bind('user.typing', function (data) {
            if (data.message && data.message !== "") {
                // Tampilkan pesan untuk semua termasuk pengirim
                const container = document.getElementById('chat-container');
                const card = document.createElement('div');
                card.className = 'cardcom001';
                const img = document.createElement('img');
                img.src = `${data.username}/profil/${data.improfil}`;
                img.className = 'creatorstories';
                const dispcard = document.createElement('div');
                dispcard.className = 'dispcard';
                const ddispcanam = document.createElement('div');
                ddispcanam.className = 'ddispcanam';
                const pName = document.createElement('p');
                pName.className = 'dispname';
                pName.innerText = data.username;
                ddispcanam.appendChild(pName);
                const pComment = document.createElement('p');
                pComment.className = 'comment001';
                pComment.innerText = data.message;
                dispcard.appendChild(ddispcanam);
                dispcard.appendChild(pComment);
                card.appendChild(img);
                card.appendChild(dispcard);
                container.appendChild(card);
            } else {
                if (data.username !== "{{ session('username') }}") {
                    document.getElementById('typing-indicator').innerText = `${data.username} sedang mengetik...`;
                    clearTimeout(window.typingTimeout);
                    window.typingTimeout = setTimeout(() => {
                        document.getElementById('typing-indicator').innerText = '';
                    }, 2000);
                }
            }
        });
    });
    </script>
</body>
</html>