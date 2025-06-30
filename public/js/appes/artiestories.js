document.addEventListener("DOMContentLoaded", function () {
    const cardUpload = document.getElementById("cardupload-artiestories");
    const uploadFile = document.getElementById("uploadfile-artiestories");
    const toggleBtn = document.getElementById("pilihkategorian-artiestories");
    const kategoriBox = document.getElementById("pilihkategori-artiestories");
    const kategoriBtns = document.querySelectorAll(".kategori-btn-artiestories");
    const kseoInput = document.getElementById("kseo-artiestories");

    if (cardUpload && uploadFile) {
        cardUpload.addEventListener("click", function(event) {
            event.preventDefault();
            event.stopPropagation();
            uploadFile.classList.toggle("show");
            kategoriBox.classList.add("hidden");
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
            kseoInput.value = btn.getAttribute("data-kategori-artiestories");
            kategoriBox.classList.add("hidden");
            toggleBtn.textContent = `Kategori: ${btn.getAttribute("data-kategori-artiestories")}`;
        });
    });

});