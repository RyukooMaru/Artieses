<script>
    const dropArea = document.getElementById('drop-area-artiestories');
    const fileInput = document.getElementById('fileElem-artiestories');
    const preview = document.getElementById('file-preview-artiestories');

    dropArea.addEventListener('click', () => fileInput.click());

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('dragover');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('dragover');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('dragover');

        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;

            showFilePreview(e.dataTransfer.files);
        }
    });

    fileInput.addEventListener('change', function (e) {
        showFilePreview(e.target.files);
    });

    function showFilePreview(files) {
        preview.innerHTML = '';

        Array.from(files).forEach((file) => {
            const div = document.createElement('div');
            div.classList.add('file-item');

            const nameSpan = document.createElement('span');
            nameSpan.classList.add('file-name');
            nameSpan.textContent = file.name;

            div.appendChild(nameSpan);
            preview.appendChild(div);
        });
    }
</script>
