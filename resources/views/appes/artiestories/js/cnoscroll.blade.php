<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openCommentarist = @json(isset($open_commentarist) ? $open_commentarist : null);
        if (openCommentarist) {
            const modal = document.getElementById("commentarist-" + openCommentarist);
            if (modal) {
                document.body.classList.add('noscroll');
            }
        }
    });
</script><!-- script no scroll body -->