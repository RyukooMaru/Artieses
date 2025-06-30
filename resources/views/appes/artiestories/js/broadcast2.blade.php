
  <script>
    function handleSendComment(buttonElement) {
        if (buttonElement.disabled) return;
        const targetid = buttonElement.id.replace('btnimg-sendcom-', '');
        const inputOL = document.getElementById(`inpbalassaja-${targetid}`);
        const commentses1 = document.getElementById(`inpbalassajahidden-${targetid}`);
        const fileInput1 = document.getElementById(`filepicker1-${targetid}`);
        const clearBtn1 = document.getElementById(`close-dibales-${targetid}`);
        const delprev1 = document.getElementById(`image-preview1-${targetid}`);
        const message1 = inputOL.value.trim();
        const storyCode1 = commentses1.value.trim();
        const hasImage = fileInput1?.files.length > 0;
        if (!hasImage && message1.length === 0) {
            return;
        }
        buttonElement.disabled = true;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const handleAuthRedirect = (data) => {
            if (!data.logged_in) {
                sessionStorage.setItem('alert', data.alert);
                sessionStorage.setItem('form', data.form);
                window.location.href = data.redirect;
                return true;
            }
            return false;
        };
        const restoreButton = () => {
            setTimeout(() => {
                buttonElement.disabled = false;
            }, 300);
        };
        if (hasImage) {
            const formData = new FormData();
            formData.append('storyCode1', storyCode1);
            formData.append('code', targetid);
            formData.append('message1', message1);
            formData.append('fileInput1', fileInput1.files[0]);
            fetch('/enter-typing1', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (handleAuthRedirect(data)) return;
                inputOL.value = '';
                fileInput1.value = '';
                delprev1?.remove();
                clearBtn1?.classList.add('hidden');
            })
            .catch(error => console.error('Error:', error))
            .finally(restoreButton);
        } else if (message1.length > 0) {
            fetch('/enter-typing1', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message1, storyCode1 })
            })
            .then(res => res.json())
            .then(data => {
                if (handleAuthRedirect(data)) return;
                inputOL.value = '';
                clearBtn1?.classList.add('hidden');
            })
            .catch(error => console.error('Error:', error))
            .finally(restoreButton);
        } else {
            restoreButton();
        }
    }
    document.addEventListener('click', function(event) {
        const sendButton = event.target.closest('[id^="btnimg-sendcom-"]');
        if (sendButton) {
            event.preventDefault();
            handleSendComment(sendButton);
            return;
        }
        const clearButton = event.target.closest('[id^="close-dibales-"]');
        if (clearButton) {
            event.preventDefault();
            const targetid = clearButton.id.replace('close-dibales-', '');
            const inputOL = document.getElementById(`inpbalassaja-${targetid}`);
            if (inputOL) {
                inputOL.value = "";
                clearButton.classList.add('hidden');
                inputOL.focus();
            }
        }
    });
    document.addEventListener('focusin', function(event) {
        const inputOL = event.target;
        if (!inputOL.id || !inputOL.id.startsWith('inpbalassaja-')) return;
        if (inputOL.dataset.listenersAttached) return;
        const targetid = inputOL.id.replace('inpbalassaja-', '');
        const clearBtn1 = document.getElementById(`close-dibales-${targetid}`);
        const commentses1 = document.getElementById(`inpbalassajahidden-${targetid}`);
        let typingTimeout = null;
        inputOL.addEventListener('input', () => {
            clearBtn1?.classList.toggle('hidden', inputOL.value.trim().length === 0);
            clearTimeout(typingTimeout);
            typingTimeout = setTimeout(() => {
            }, 500);
        });
        inputOL.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const sendButton = document.getElementById(`btnimg-sendcom-${targetid}`);
                if (sendButton) {
                    handleSendComment(sendButton);
                }
            }
        });
        inputOL.dataset.listenersAttached = 'true';
    });
  </script>