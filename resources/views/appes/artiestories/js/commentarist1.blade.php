<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="rbtnry3-"]').forEach(rbtnry3 => {
        const id = rbtnry3.id.replace('rbtnry3-', '');
        const button = document.getElementById('rbtnry3-' + id);
        const srcard3 = document.getElementById('srcard3-' + id);

        let hideTimeout;

        function showCard() {
            clearTimeout(hideTimeout);
            srcard3.classList.remove('hidden');
            button.classList.add('hidden');
        }

        function hideCard() {
            hideTimeout = setTimeout(() => {
                if (!button.matches(':hover') && !srcard3.matches(':hover')) {
                    srcard3.classList.add('hidden');
                    button.classList.remove('hidden');
                }
            }, 250);
        }

        button.addEventListener('mouseenter', showCard);
        button.addEventListener('mouseleave', hideCard);
        srcard3.addEventListener('mouseleave', hideCard);
        srcard3.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
    });
});
</script>
