<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="rbtnry5-"]').forEach(rbtnry5 => {
        const id = rbtnry5.id.replace('rbtnry5-', '');
        const button = document.getElementById('rbtnry5-' + id);
        const srcard5 = document.getElementById('srcard5-' + id);

        let hideTimeout;

        function showCard() {
            clearTimeout(hideTimeout);
            srcard5.classList.remove('hidden');
            button.classList.add('hidden');
        }

        function hideCard() {
            hideTimeout = setTimeout(() => {
                if (!button.matches(':hover') && !srcard5.matches(':hover')) {
                    srcard5.classList.add('hidden');
                    button.classList.remove('hidden');
                }
            }, 250);
        }

        button.addEventListener('mouseenter', showCard);
        button.addEventListener('mouseleave', hideCard);
        srcard5.addEventListener('mouseleave', hideCard);
        srcard5.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
    });
});
</script>
