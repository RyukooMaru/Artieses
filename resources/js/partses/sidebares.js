document.addEventListener("DOMContentLoaded", function () {
    const setting = document.getElementById("toggle-settings");
    const setnav = document.getElementById("card-setting");
    const buates = document.getElementById("buates");
    const cardBu = document.getElementById("cardbu");

    const alertBox = document.getElementById('carlert');
    if (alertBox && alertBox.style.display !== 'none') {
        setTimeout(() => {
            alertBox.style.opacity = '0';
            setTimeout(() => {
                alertBox.style.display = 'none';
            }, 500);
        }, 5000);
    }

    if (buates && cardBu) {
        buates.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();
            if (setnav && setnav.classList.contains("show")) {
                setnav.classList.remove("show");
            }

            cardBu.classList.toggle("show");
        });

        document.addEventListener("click", function (event) {
            if (!cardBu.contains(event.target) && !buates.contains(event.target)) {
                cardBu.classList.remove("show");
            }
        });
    }

    if (setting && setnav) {
        setting.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();
            if (cardBu && cardBu.classList.contains("show")) {
                cardBu.classList.remove("show");
            }

            setnav.classList.toggle("show");
        });

        document.addEventListener("click", function (event) {
            if (!setnav.contains(event.target) && !setting.contains(event.target)) {
                setnav.classList.remove("show");
            }
        });
    }
});
