<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="rbtnry4-"]').forEach(rbtnry4 => {
        const id = rbtnry4.id.replace('rbtnry4-', '');
        const button = document.getElementById('rbtnry4-' + id);
        const srcard4 = document.getElementById('srcard4-' + id);
        let hideTimeout;
        function showCard() {
            clearTimeout(hideTimeout);
            srcard4.classList.remove('hidden');
            button.classList.add('hidden');
        }
        function hideCard() {
            hideTimeout = setTimeout(() => {
                if (!button.matches(':hover') && !srcard4.matches(':hover')) {
                    srcard4.classList.add('hidden');
                    button.classList.remove('hidden');
                }
            }, 250);
        }
        button.addEventListener('mouseenter', showCard);
        button.addEventListener('mouseleave', hideCard);
        srcard4.addEventListener('mouseleave', hideCard);
        srcard4.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
    });
});
</script>
