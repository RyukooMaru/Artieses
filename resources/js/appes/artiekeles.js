const dropAreaartiekeles = document.getElementById('drop-area-artiekeles');
const fileInputartiekeles = document.getElementById('fileElem-artiekeles');

dropAreaartiekeles.addEventListener('click', () => fileInputartiekeles.click());

dropAreaartiekeles.addEventListener('dragover', (e) => {
  e.preventDefault();
  dropAreaartiekeles.classList.add('dragover');
});

dropAreaartiekeles.addEventListener('dragleave', () => {
  dropAreaartiekeles.classList.remove('dragover');
});

dropAreaartiekeles.addEventListener('drop', (e) => {
  e.preventDefault();
  dropAreaartiekeles.classList.remove('dragover');

  if (e.dataTransfer.files.length) {
    fileInputartiekeles.files = e.dataTransfer.files;

    dropAreaartiekeles.querySelector('p').textContent = `File terkirim`;
  }
});

document.addEventListener("DOMContentLoaded", function () {
    const cardUpload = document.getElementById("cardupload-artiekeles");
    const uploadFile = document.getElementById("uploadfile-artiekeles");
    const toggleBtn = document.getElementById("pilihkategorian-artiekeles");
    const kategoriBox = document.getElementById("pilihkategori-artiekeles");
    const kategoriBtns = document.querySelectorAll(".kategori-btn-artiekeles");
    const kseoInput = document.getElementById("kseo-artiekeles");
    if (cardUpload && uploadFile) {
        cardUpload.addEventListener("click", function(event) {
            event.preventDefault();
            event.stopPropagation();
            kategoriBox.classList.add("hidden");
            uploadFile.classList.toggle("show");
        });
        document.addEventListener("click", function(event) {
            if (!cardUpload.contains(event.target) && !uploadFile.contains(event.target)) {
                uploadFile.classList.remove("show");
            }
        });
    }
    document.addEventListener("click", function(event) {
      if (!toggleBtn.contains(event.target) && !kategoriBox.contains(event.target)) {
          kategoriBox.classList.add("hidden");
      }
    });
    toggleBtn.addEventListener("click", function () {
        kategoriBox.classList.toggle("hidden");
    });
    kategoriBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            kategoriBtns.forEach(b => b.classList.remove("selected"));
            btn.classList.add("selected");
            kseoInput.value = btn.getAttribute("data-kategori-artiekeles");
            kategoriBox.classList.add("hidden");
            toggleBtn.textContent = `Kategori: ${btn.getAttribute("data-kategori-artiekeles")}`;
        });
    });
    
});