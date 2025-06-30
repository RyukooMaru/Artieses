
    <script>
        document.addEventListener('click', function (v) {
            const target = v.target;
            if (target && target.id.startsWith('seerpl11-')) {
                const idSuffix = target.id.substring('seerpl11-'.length);
                const seerpl2 = document.getElementById('seerpl2-' + idSuffix);
                const seerpl01 = document.getElementById('seerpl01-' + idSuffix);
                const seerpl11 = document.getElementById('seerpl11-' + idSuffix);
                if (seerpl2 && seerpl01 && seerpl11) {
                    seerpl2.classList.remove('hidden');
                    seerpl11.classList.add('hidden');
                    seerpl01.classList.remove('hidden');
                }
            }
            if (target && target.id.startsWith('seerpl01-')) {
                const idSuffix = target.id.substring('seerpl01-'.length);
                const seerpl2 = document.getElementById('seerpl2-' + idSuffix);
                const seerpl01 = document.getElementById('seerpl01-' + idSuffix);
                const seerpl11 = document.getElementById('seerpl11-' + idSuffix);
                if (seerpl2 && seerpl01 && seerpl11) {
                    seerpl2.classList.add('hidden');
                    seerpl11.classList.remove('hidden');
                    seerpl01.classList.add('hidden');
                }
            }
        });
    </script><!-- script open close chat balas comment(when have atleast 1 chat balas comment ) -->