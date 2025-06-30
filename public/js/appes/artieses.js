document.addEventListener("DOMContentLoaded", function () {
    const showArtiekelesBtn = document.getElementById("show-artiekeles");
    const artiekelesForm = document.getElementById("artiekeles-form");

    const showArtievidesBtn = document.getElementById("show-artievides");
    const artievidesForm = document.getElementById("artievides-form");

    const showArtiestoriesBtn = document.getElementById("show-artiestories");
    const artiestoriesForm = document.getElementById("artiestories-form");

    const closeArtiekelesBtn = document.getElementById("close-artiekeles");
    const closeArtievidesBtn = document.getElementById("close-artievides");
    const closeArtiestoriesBtn = document.getElementById("close-artiestories");

    if (showArtiekelesBtn && artiekelesForm) {
        showArtiekelesBtn.addEventListener("click", function () {
            document.querySelectorAll(".artiekeles-card1, .artievides-card1, .artiestories-card1").forEach(form => {
                form.classList.add("hidden");
            });
            artiekelesForm.classList.remove("hidden");
        });
    }

    if (showArtievidesBtn && artievidesForm) {
        showArtievidesBtn.addEventListener("click", function () {
            document.querySelectorAll(".artiekeles-card1, .artievides-card1, .artiestories-card1").forEach(form => {
                form.classList.add("hidden");
            });
            artievidesForm.classList.remove("hidden");
        });
    }

    if (showArtiestoriesBtn && artiestoriesForm) {
        showArtiestoriesBtn.addEventListener("click", function () {
            document.querySelectorAll(".artiekeles-card1, .artievides-card1, .artiestories-card1").forEach(form => {
                form.classList.add("hidden");
            });
            artiestoriesForm.classList.remove("hidden");
        });
    }

    if (closeArtiekelesBtn && artiekelesForm) {
        closeArtiekelesBtn.addEventListener("click", function () {
            artiekelesForm.classList.add("hidden");
        });
    }

    if (closeArtievidesBtn && artievidesForm) {
        closeArtievidesBtn.addEventListener("click", function () {
            artievidesForm.classList.add("hidden");
        });
    }

    if (closeArtiestoriesBtn && artiestoriesForm) {
        closeArtiestoriesBtn.addEventListener("click", function () {
            artiestoriesForm.classList.add("hidden");
        });
    }
});
