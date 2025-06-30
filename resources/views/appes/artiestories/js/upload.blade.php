<script>
    const dropArea = document.getElementById('drop-area-artiestories');
    const fileInput = document.getElementById('fileElem-artiestories');
    const preview = document.getElementById('file-preview-artiestories');

    // Buat event listener untuk membuka dialog file saat area diklik
    dropArea.addEventListener('click', () => fileInput.click());

    // Event listener untuk drag and drop
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
            const newFiles = e.dataTransfer.files;
            const currentFiles = fileInput.files;
            
            const dt = new DataTransfer();
            for (let i = 0; i < currentFiles.length; i++) {
                dt.items.add(currentFiles[i]);
            }
            for (let i = 0; i < newFiles.length; i++) {
                dt.items.add(newFiles[i]);
            }

            fileInput.files = dt.files;
            showFilePreview(fileInput.files);
        }
    });

    // Event listener saat file dipilih melalui dialog
    fileInput.addEventListener('change', function (e) {
        showFilePreview(e.target.files);
    });

    /**
     * Fungsi utama untuk menampilkan pratinjau file gambar.
     * @param {FileList} files - Daftar file dari input.
     */
    function showFilePreview(files) {
        // Kosongkan area pratinjau sebelum menampilkan yang baru
        preview.innerHTML = '';

        // Konversi FileList ke Array agar mudah diolah
        Array.from(files).forEach((file, index) => {
            // Hanya proses file yang bertipe gambar
            if (file.type.startsWith('image/')) {
                // Buat container untuk setiap item pratinjau
                const previewItem = document.createElement('div');
                previewItem.classList.add('preview-item');

                // Buat elemen gambar
                const img = document.createElement('img');
                img.alt = file.name;

                // Buat tombol hapus
                const removeBtn = document.createElement('button');
                removeBtn.classList.add('remove-btn');
                removeBtn.innerHTML = '&times;'; // Simbol 'x'
                removeBtn.type = 'button'; // Pastikan tidak submit form

                // Tambahkan event listener untuk tombol hapus
                removeBtn.addEventListener('click', () => {
                    removeFile(index);
                });
                
                // Tambahkan gambar dan tombol ke container item
                previewItem.appendChild(img);
                previewItem.appendChild(removeBtn);

                // Tambahkan item ke area pratinjau
                preview.appendChild(previewItem);

                // Gunakan FileReader untuk membaca dan menampilkan gambar
                const reader = new FileReader();
                reader.onload = (e) => {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    /**
     * Fungsi untuk menghapus file dari daftar input.
     * @param {number} index - Indeks file yang akan dihapus.
     */
    function removeFile(index) {
        // Ambil daftar file saat ini
        const currentFiles = Array.from(fileInput.files);
        
        // Hapus file pada indeks yang ditentukan
        currentFiles.splice(index, 1);

        // Buat objek DataTransfer baru untuk menampung file yang tersisa
        const dt = new DataTransfer();
        currentFiles.forEach(file => {
            dt.items.add(file);
        });

        // Update file input dengan daftar file yang baru
        fileInput.files = dt.files;

        // Tampilkan ulang pratinjau berdasarkan daftar file yang sudah diperbarui
        showFilePreview(fileInput.files);
    }
</script>