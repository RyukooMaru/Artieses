
  <script>
    document.querySelectorAll('[id^="importbtn1-"]').forEach(importBtn1 => {
        const storyCode1 = importBtn1.id.replace('importbtn1-', '');
        const fileInput1 = document.getElementById('filepicker1-' + storyCode1);
        if (fileInput1) {
            importBtn1.addEventListener('click', () => {
                fileInput1.click();
            });
        }
        if (fileInput1 && !fileInput1.dataset.listenerAdded) {
            fileInput1.addEventListener('change', function () {
                const file1 = this.files[0];
                if (file1 && file1.type.startsWith('image/')) {
                    const reader1 = new FileReader();
                    reader1.onload = function (event) {
                        showImagePreview1(event.target.result, storyCode1);
                    };
                    reader1.readAsDataURL(file1);
                }
            });
            fileInput1.dataset.listenerAdded = 'true';
        }
        const input1 = document.getElementById('inpbalassaja-' + storyCode1);
        if (input1 && !input1.dataset.listenerAdded) {
            input1.addEventListener('paste', function (e) {
                const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                for (let i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf("image") === 0) {
                        const file = items[i].getAsFile();
                        const reader1 = new FileReader();
                        reader1.onload = function (event) {
                            showImagePreview1(event.target.result, storyCode1);
                        };
                        reader1.readAsDataURL(file);
                    }
                }
            });
            input1.dataset.listenerAdded = 'true';
        }
    });
    function showImagePreview1(imageSrc, storyCode1) {
        const oldPreview = document.querySelector('.image-preview1-' + storyCode1);
        if (oldPreview) oldPreview.remove();
        const preview = document.createElement('div');
        preview.className = 'image-preview1 image-preview1-' + storyCode1;
        preview.style.marginTop = '10px';
        preview.id = 'image-preview1-' + storyCode1;
        preview.style.textAlign = 'center';
        const img = document.createElement('img');
        img.src = imageSrc;
        img.style.height = '80px';
        img.style.borderRadius = '8px';
        img.style.boxShadow = '0 0 5px rgba(0,0,0,0.2)';
        const delimg = document.createElement('button');
        delimg.className = 'bcloimcom1 blcloimcom' + storyCode1;
        delimg.id = 'bcloimcom' + storyCode1;
        delimg.innerHTML = '&times;';
        delimg.style.cursor = 'pointer';
        delimg.addEventListener('click', () => { 
            preview.remove();
            const fileInput1 = document.getElementById('filepicker1-' + storyCode1);
            if (fileInput1) {
                fileInput1.value = '';
            }
        });
        preview.appendChild(img);
        preview.appendChild(delimg);
        const input1 = document.getElementById('inpbalassaja-' + storyCode1);
        if (input1) input1.value = "";
        const clearBtn1 = document.getElementById(`close-dibales-${storyCode1}`);
        if (clearBtn1) clearBtn1.classList.add('hidden');
        const sendBtn = document.getElementById('lagi-' + storyCode1);
        if (sendBtn && sendBtn.parentNode) {
            sendBtn.insertBefore(preview, sendBtn.firstChild);
        }
    }
  </script>