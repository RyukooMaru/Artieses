
  <script>
    document.querySelectorAll('[id^="inpcom-"]').forEach(inputEl => {
        const storyCode = inputEl.id.replace('inpcom-', '');
        const clearBtn = document.getElementById(`balinpcom-${storyCode}`);
        const sendBtn = document.getElementById(`sendcom-${storyCode}`);
        const commentses = document.getElementById(`commentses-${storyCode}`);
        let canSend = true;
        window.typingTimeout2 = null;
        window.canFetchTyping2 = true;
        window.typingTimeout5 = null;
        window.canFetchTyping5 = true;
        if (!commentses) return;
        inputEl.addEventListener('input', function () {
            if (inputEl.value.length > 0) {
                clearBtn?.classList.remove('hidden');
                clearBtn?.classList.add('block');
            } else {
                clearBtn?.classList.add('hidden');
                clearBtn?.classList.remove('block');
            }
            const message = inputEl.value.trim();
            const comentses = commentses.value.trim();
            if (window.canFetchTyping5) {
                window.canFetchTyping5 = false;
                fetch('/broadcast-typing', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ message, comentses })
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.logged_in) {
                        sessionStorage.setItem('alert', data.alert);
                        sessionStorage.setItem('form', data.form);
                        window.location.href = data.redirect;
                    }
                });
                clearTimeout(window.typingTimeout5);
                window.typingTimeout5 = setTimeout(() => {
                    window.canFetchTyping5 = true;
                }, 1000);
            }
        });
        clearBtn?.addEventListener('click', function () {
            inputEl.value = "";
            clearBtn.classList.add('hidden');
        });
        function sendComment() {
            const message = inputEl.value.trim();
            const coderies = commentses.value.trim();
            const fileInput = document.getElementById(`filepicker-${storyCode}`);
            if (message.length === 0 && canSend && fileInput.files.length > 0) {
                canSend = false;
                if (window.canFetchTyping2) {
                    window.canFetchTyping2 = false;
                    const formData = new FormData();
                    formData.append('coderies', coderies);
                    formData.append('fileInput', fileInput.files[0]);
                    fetch('/enter-typing', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        fileInput.value = '';
                        const delprev = document.getElementById('image-preview-' + storyCode);
                        delprev.remove();
                        clearBtn?.classList.add('hidden');
                        if (!data.logged_in) {
                            sessionStorage.setItem('alert', data.alert);
                            sessionStorage.setItem('form', data.form);
                            window.location.href = data.redirect;
                        }
                    })
                    .finally(() => {
                        setTimeout(() => {
                            canSend = true;
                        }, 30);
                    });
                    clearTimeout(window.typingTimeout2);
                    window.typingTimeout2 = setTimeout(() => {
                        window.canFetchTyping2 = true;
                    }, 1000);
                }
            }
            if (message.length > 0 && canSend && fileInput.files.length === 0) {
                canSend = false;
                if (window.canFetchTyping2) {
                    window.canFetchTyping2 = false;
                    fetch('/enter-typing', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ message, coderies })
                    })
                    .then(res => res.json())
                    .then(data => {
                        inputEl.value = '';
                        clearBtn?.classList.add('hidden');
                        if (!data.logged_in) {
                            sessionStorage.setItem('alert', data.alert);
                            sessionStorage.setItem('form', data.form);
                            window.location.href = data.redirect;
                        }
                    })
                    .finally(() => {
                        setTimeout(() => {
                            canSend = true;
                        }, 30);
                    });
                    clearTimeout(window.typingTimeout2);
                    window.typingTimeout2 = setTimeout(() => {
                        window.canFetchTyping2 = true;
                    }, 1000);
                }
            }
        }
        inputEl.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                sendComment();
            }
        });
        sendBtn?.addEventListener('click', function (event) {
            event.preventDefault();
            sendComment();
        });
    });
  </script>