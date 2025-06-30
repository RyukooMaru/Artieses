
  <script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[id^="inpcom-"]').forEach(input => {
            const storyCode = input.id.replace('inpcom-', '');
            const fileInput = document.getElementById('filepicker-' + storyCode);
            const importBtn = document.getElementById('importbtn-' + storyCode);

            if (!fileInput || !importBtn) return;

            importBtn.addEventListener('click', () => {
                fileInput.click();
            });

            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        showImagePreview(event.target.result, storyCode);
                    };
                    reader.readAsDataURL(file);
                }
            });

            input.addEventListener('paste', function (e) {
                const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                for (let i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf("image") === 0) {
                        const file = items[i].getAsFile();
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            showImagePreview(event.target.result, storyCode);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        });
    });

    function showImagePreview(imageSrc, storyCode) {
        const oldPreview = document.querySelector('.image-preview-' + storyCode);
        if (oldPreview) oldPreview.remove();

        const preview = document.createElement('div');
        preview.className = 'image-preview image-preview-' + storyCode;
        preview.style.marginTop = '10px';
        preview.id = 'image-preview-' + storyCode;
        preview.style.textAlign = 'center';

        const img = document.createElement('img');
        img.src = imageSrc;
        img.style.height = '80px';
        img.style.borderRadius = '8px';
        img.style.boxShadow = '0 0 5px rgba(0,0,0,0.2)';

        const delimg = document.createElement('button');
        delimg.className = 'bcloimcom blcloimcom' + storyCode;
        delimg.id = 'bcloimcom' + storyCode;
        delimg.innerHTML = `&times;`;
        delimg.style.cursor = 'pointer';
        delimg.addEventListener('click', () => preview.remove());

        preview.appendChild(img);
        preview.appendChild(delimg);

        const input = document.getElementById('inpcom-' + storyCode);
        if (input) input.value = "";

        const clearBtn = document.getElementById('balinpcom-' + storyCode);
        if (clearBtn) clearBtn.classList.add('hidden');

        const sendBtn = document.getElementById('sendcom-' + storyCode);
        if (sendBtn?.parentNode) {
            sendBtn.parentNode.insertBefore(preview, sendBtn);
        }
    }
  </script>