const dropAreaartievides = document.getElementById('drop-area-artievides');
const fileInputartievides = document.getElementById('fileElem-artievides');

dropAreaartievides.addEventListener('click', () => fileInputartievides.click());

dropAreaartievides.addEventListener('dragover', (e) => {
  e.preventDefault();
  dropAreaartievides.classList.add('dragover');
});

dropAreaartievides.addEventListener('dragleave', () => {
  dropAreaartievides.classList.remove('dragover');
});

dropAreaartievides.addEventListener('drop', (e) => {
  e.preventDefault();
  dropAreaartievides.classList.remove('dragover');

  if (e.dataTransfer.files.length) {
    fileInputartievides.files = e.dataTransfer.files;

    dropAreaartievides.querySelector('p').textContent = `File terkirim`;
  }
});

const dropAreaartievides1 = document.getElementById('drop-area-artievides1');
const fileInputartievides1 = document.getElementById('fileElem-artievides1');

dropAreaartievides1.addEventListener('click', () => fileInputartievides1.click());

dropAreaartievides1.addEventListener('dragover', (e) => {
  e.preventDefault();
  dropAreaartievides1.classList.add('dragover');
});

dropAreaartievides1.addEventListener('dragleave', () => {
  dropAreaartievides1.classList.remove('dragover');
});

dropAreaartievides1.addEventListener('drop', (e) => {
  e.preventDefault();
  dropAreaartievides1.classList.remove('dragover');

  if (e.dataTransfer.files.length) {
    fileInputartievides1.files = e.dataTransfer.files;

    dropAreaartievides1.querySelector('p').textContent = `File terkirim`;
  }
});

document.addEventListener("DOMContentLoaded", function () {
    const cardUpload = document.getElementById("cardupload-artievides");
    const uploadFile = document.getElementById("uploadfile-artievides");
    const cardUpload1 = document.getElementById("cardupload1-artievides");
    const uploadFile1 = document.getElementById("uploadfile1-artievides");
    const toggleBtn = document.getElementById("pilihkategorian-artievides");
    const kategoriBox = document.getElementById("pilihkategori-artievides");
    const kategoriBtns = document.querySelectorAll(".kategori-btn-artievides");
    const kseoInput = document.getElementById("kseo-artievides");

    const closeKategoriBtn = document.getElementById("close-kategori-artievides");
  
    if (cardUpload && uploadFile) {
        cardUpload.addEventListener("click", function(event) {
            event.preventDefault();
            event.stopPropagation();
            uploadFile.classList.toggle("show");
            uploadFile1.classList.remove("show");
            kategoriBox.classList.add("hidden");
        });
        document.addEventListener("click", function(event) {
            if (!cardUpload.contains(event.target) && !uploadFile.contains(event.target)) {
                uploadFile.classList.remove("show");
            }
        });
    }
    if (cardUpload1 && uploadFile1) {
      cardUpload1.addEventListener("click", function(event) {
          event.preventDefault();
          event.stopPropagation();
          uploadFile1.classList.toggle("show");
          uploadFile.classList.remove("show");
          kategoriBox.classList.add("hidden");
      });
      document.addEventListener("click", function(event) {
          if (!cardUpload1.contains(event.target) && !uploadFile1.contains(event.target)) {
              uploadFile1.classList.remove("show");
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
            kseoInput.value = btn.getAttribute("data-kategori-artievides");
            kategoriBox.classList.add("hidden");
            toggleBtn.textContent = `Kategori: ${btn.getAttribute("data-kategori-artievides")}`;
        });
    });
    
    if (closeKategoriBtn && kategoriBox) {
      closeKategoriBtn.addEventListener("click", function () {
          kategoriBox.classList.add("hidden");
      });
  }
});