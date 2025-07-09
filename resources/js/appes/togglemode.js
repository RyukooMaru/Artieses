const toggleButtons = document.querySelectorAll(".toggle-mode");
const toggleButtons1 = document.querySelectorAll(".tm");
const modeText = document.getElementById("mode-text");
const isDarkMode = localStorage.getItem("darkMode") === "enabled";

// Fungsi untuk mengaktifkan atau menonaktifkan dark mode
function applyDarkMode(isDark) {
    document.body.classList.toggle("dark-mode", isDark);
    localStorage.setItem("darkMode", isDark ? "enabled" : "disabled");

    // Update semua gambar yang punya data-light & data-dark
    document.querySelectorAll("img[data-light][data-dark]").forEach(img => {
        const src = isDark ? img.dataset.dark : img.dataset.light;
        img.src = src;
    });

    // Update teks mode (jika elemen ada)
    if (modeText) {
        modeText.textContent = isDark
            ? modeText.getAttribute("data-dark")
            : modeText.getAttribute("data-light");
    }
}

// Inisialisasi mode saat halaman dimuat
applyDarkMode(isDarkMode);

// Event listener untuk tombol toggle mode
toggleButtons.forEach(button => {
    button.addEventListener("click", () => {
        const currentMode = document.body.classList.contains("dark-mode");
        applyDarkMode(!currentMode);
    });
});
toggleButtons1.forEach(button => {
    button.addEventListener("click", () => {
        const currentMode = document.body.classList.contains("dark-mode");
        applyDarkMode(!currentMode);
    });
});