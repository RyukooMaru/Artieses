<script>
    document.addEventListener('click', function (e) {
        const target = e.target;
        if (target.id.startsWith('balaskansaja-')) {
            const rcmId = target.id.replace('balaskansaja-', '');
            document.getElementById(`lagi-${rcmId}`)?.classList.remove('hidden');
            document.getElementById(`balaskansaja-${rcmId}`)?.classList.add('hidden');
            document.getElementById(`urungkansaja-${rcmId}`)?.classList.remove('hidden');
        }
        if (target.id.startsWith('urungkansaja-')) {
            const rcmId = target.id.replace('urungkansaja-', '');
            document.getElementById(`lagi-${rcmId}`)?.classList.add('hidden');
            document.getElementById(`balaskansaja-${rcmId}`)?.classList.remove('hidden');
            document.getElementById(`urungkansaja-${rcmId}`)?.classList.add('hidden');
            const input = document.getElementById(`inpbalassaja-${rcmId}`);
            if (input) input.value = "";
        }
        if (target.id.startsWith('close-dibales-')) {
            const rcmId = target.id.replace('close-dibales-', '');
            const input = document.getElementById(`inpbalassaja-${rcmId}`);
            if (input) input.value = "";
        }
    });
</script>
