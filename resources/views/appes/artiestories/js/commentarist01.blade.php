<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="rbtnry2-"]').forEach(rbtnry2 => {
        const id = rbtnry2.id.replace('rbtnry2-', '');
        const button = document.getElementById('rbtnry2-' + id);
        const srcard2 = document.getElementById('srcard2-' + id);

        let hideTimeout;

        function showCard() {
            clearTimeout(hideTimeout);
            srcard2.classList.remove('hidden');
        }

        function hideCard() {
            hideTimeout = setTimeout(() => {
                if (!button.matches(':hover') && !srcard2.matches(':hover')) {
                    srcard2.classList.add('hidden');
                }
            }, 250);
        }

        button.addEventListener('mouseenter', showCard);
        button.addEventListener('mouseleave', hideCard);
        srcard2.addEventListener('mouseleave', hideCard);
        srcard2.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
    });
});
</script>
