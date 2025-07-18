<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[id^="cardstories-"], [id^="cbtnry1-"]').forEach(cardstories => {
            let id = cardstories.id;
            const match = id.match(/(?:cardstories|cbtnry1)-([^-]+)(?:-\d+)?/);
            if (match) {
                id = match[1];
            }
            if (cardstories.tagName.toLowerCase() === 'video') return;
            cardstories.addEventListener('click', function () {
                const input = document.getElementById("inpcom-" + id);
                const modal = document.getElementById("commentarist-" + id);
                const currentPath = window.location.pathname;
                const isProfile = currentPath.startsWith('/profiles/');
                let newUrl = '';
                if (isProfile) {
                    const parts = currentPath.split('/');
                    const username = parts[2] ?? '';
                    newUrl = `/profiles/${username}/Artiestories?GetContent=${id}`;
                } else {
                    newUrl = `Artiestories?GetContent=${id}`;
                }
                history.pushState({}, '', newUrl);
                document.querySelectorAll('video').forEach(function(video) {
                    video.pause();
                });
                if (modal) {
                    modal.classList.remove("hidden");
                    const closeBtn = document.getElementById("closeCommentarist-" + id);
                    document.body.classList.add('noscroll');
                    if (closeBtn) {
                        closeBtn.addEventListener("click", function () {
                            input.value = "";
                            modal.classList.add("hidden");
                            document.body.classList.remove('noscroll');
                            let path = window.location.pathname;
                            let isProfile = path.startsWith('/profiles/');
                            if (isProfile) {
                                let backUrl = path.replace(/\/Artiestories(\?.*)?$/i, '');
                                history.pushState({}, '', backUrl);
                            } else {
                                history.pushState({}, '', 'Artieses');
                            }
                        });
                    }
                }
            });
        });
        function getBackUrl() {
            const path = window.location.pathname + window.location.search;
            const isProfile = path.startsWith('/profiles/') && path.includes('/Artiestories');
            if (isProfile) {
                return path.replace(/\/Artiestories(\?.*)?$/i, '');
            }
            return 'Artieses';
        }
        function handleModalState() {
            const params = new URLSearchParams(window.location.search);
            const id = params.get('GetContent');
            document.querySelectorAll('.commentarist').forEach(modal => {
                if (modal.id !== `commentarist-${id}`) {
                    modal.classList.add("hidden");
                }
            });
            if (id) {
                const modalToShow = document.getElementById("commentarist-" + id);
                if (modalToShow) {
                    modalToShow.classList.remove("hidden");
                    document.body.classList.add('noscroll');
                }
            } else {
                document.body.classList.remove('noscroll');
            }
        }
        document.addEventListener('DOMContentLoaded', handleModalState);
        window.addEventListener('popstate', handleModalState);
        document.addEventListener('click', function(e) {
            if (e.target && e.target.id.startsWith('closeCommentarist-')) {
                e.preventDefault();
                const id = e.target.id.replace('closeCommentarist-', '');
                const modal = document.getElementById("commentarist-" + id);
                if (modal) {
                    modal.classList.add("hidden");
                }
                document.body.classList.remove('noscroll');
                history.pushState({}, '', getBackUrl());
                fetch('/close-commentarist', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });
            }
        });
    });
</script>