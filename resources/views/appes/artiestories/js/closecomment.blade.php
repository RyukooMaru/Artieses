
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="inpcom-"]').forEach(function (input) {
            const storyCode = input.id.replace('inpcom-', '');
            const clearBtn = document.getElementById("balinpcom-" + storyCode);

            if (clearBtn) {
                input.addEventListener('input', function () {
                    if (input.value.length > 0) {
                        clearBtn.classList.add('block');
                        clearBtn.classList.remove('hidden');
                    } else {
                        clearBtn.classList.add('hidden');
                        clearBtn.classList.remove('block');
                    }
                });

                clearBtn.addEventListener('click', function () {
                    input.value = "";
                    clearBtn.classList.add('hidden');
                    clearBtn.classList.remove('block');
                    input.focus();
                });
            }
        });
    });
  </script>