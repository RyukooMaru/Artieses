document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("search-input");
    const clearBtn = document.getElementById("clear-btn");
    const profileIcon = document.getElementById("profile-icon");
    const cardProf = document.getElementById("cardprof");

    if (profileIcon && cardProf) {
        
        profileIcon.addEventListener("click", function(event) {
            event.preventDefault();
            event.stopPropagation();
            cardProf.classList.toggle("show");
        });

        document.addEventListener("click", function(event) {
            if (!cardProf.contains(event.target) && !profileIcon.contains(event.target)) {
                cardProf.classList.remove("show");
            }
        });   
    }
    if (input && clearBtn) {
        input.addEventListener("input", function () {
            clearBtn.style.display = input.value.length > 0 ? "block" : "none";
        });

        clearBtn.addEventListener("click", function () {
            input.value = "";
            clearBtn.style.display = "none";
            input.focus();
        });
    }
});
