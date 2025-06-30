<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('open_commentarist'))
            const storyId = "{{ session('open_commentarist') }}";
            const input = document.getElementById("inpcom-" + storyId);
            const modal = document.getElementById("commentarist-" + storyId);
            const closeBtn = document.getElementById("closeCommentarist-" + storyId);
            if (modal) {
                modal.classList.remove("hidden");
                modal.classList.add("block");
                if (closeBtn) {
                    closeBtn.addEventListener("click", function () {
                        if (input) input.value = "";
                        modal.classList.remove("block");
                        modal.classList.add("hidden");
                    });
                }
                modal.addEventListener("click", function (e) {
                    if (e.target === modal) {
                        modal.classList.remove("block");
                        modal.classList.add("hidden");
                    }
                });
            }
        @endif
    });
</script>
