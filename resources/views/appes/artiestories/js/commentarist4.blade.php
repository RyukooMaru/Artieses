<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="rbtnry6-"]').forEach(rbtnry6 => {
        const id = rbtnry6.id.replace('rbtnry6-', '');
        const button = document.getElementById('rbtnry6-' + id);
        const srcard6 = document.getElementById('srcard6-' + id);

        let hideTimeout;

        function showCard() {
            clearTimeout(hideTimeout);
            srcard6.classList.remove('hidden');
            button.classList.add('hidden');
        }

        function hideCard() {
            hideTimeout = setTimeout(() => {
                if (!button.matches(':hover') && !srcard6.matches(':hover')) {
                    srcard6.classList.add('hidden');
                    button.classList.remove('hidden');
                }
            }, 250);
        }

        button.addEventListener('mouseenter', showCard);
        button.addEventListener('mouseleave', hideCard);
        srcard6.addEventListener('mouseleave', hideCard);
        srcard6.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
    });
});
</script>
