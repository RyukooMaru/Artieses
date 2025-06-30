<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="rbtnry1-"]').forEach(rbtnry1 => {
        const id = rbtnry1.id.replace('rbtnry1-', '');
        const button = document.getElementById('rbtnry1-' + id);
        const srcard1 = document.getElementById('srcard1-' + id);

        let hideTimeout;

        function showCard() {
            clearTimeout(hideTimeout);
            srcard1.classList.remove('hidden');
            button.classList.add('hidden');
        }

        function hideCard() {
            hideTimeout = setTimeout(() => {
                if (!button.matches(':hover') && !srcard1.matches(':hover')) {
                    srcard1.classList.add('hidden');
                    button.classList.remove('hidden');
                }
            }, 250);
        }

        button.addEventListener('mouseenter', showCard);
        button.addEventListener('mouseleave', hideCard);
        srcard1.addEventListener('mouseleave', hideCard);
        srcard1.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
    });
});
</script>
