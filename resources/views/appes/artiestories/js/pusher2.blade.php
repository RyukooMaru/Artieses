
  <script>
    if (typeof window.pusher1 === 'undefined') {
        window.pusher1 = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
            cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
            forceTLS: true
        });
    }
    if (typeof window.channel3 === 'undefined') {
        window.channel3 = window.pusher1.subscribe('typing-channel1');
    }
    window.typingTimeout3 = null;
    window.canFetchTyping3 = true;
    window.channel3.bind('user.typing1', function (data) {
        if (data.message && data.message !== "") {
            if (window.canFetchTyping3) {
                const imprev = document.getElementById(`image-preview1-${data.reqplat}`);
                if(imprev) imprev.remove();
                window.canFetchTyping3 = false;
                const reply = document.createElement('div');
                reply.className = `reply reply-${data.reqplat}`;
                const aprofil = document.createElement('a');
                aprofil.href = `/profiles/${data.username}`;
                const imgprofil = document.createElement('img');
                imgprofil.src = `${data.username}/profil/${data.improfil}`;
                imgprofil.className = `creatorstories`;
                const dispcard = document.createElement('div');
                dispcard.className = 'dispcard';
                const aname = document.createElement('a');
                aname.href = `/profiles/${data.username}`;
                const nameprofil = document.createElement('p');
                nameprofil.className = `dispname`;
                nameprofil.innerText = data.username;
                const messageprof = document.createElement('p');
                messageprof.className = `comment001`;
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = data.message;
                const imgElement = tempDiv.querySelector('img.imgcom');
                if (imgElement) {
                    messageprof.innerHTML = data.message;
                } else {
                    messageprof.innerText = tempDiv.innerText;
                }
                const wrappercom3 = document.createElement('div');
                wrappercom3.className = `wrappercom3 wrappercom3-${data.reqplat}`;
                const reacted = document.createElement('div');
                reacted.className = `srcard4 srcard5-${data.comstoriesid} hidden`;
                reacted.id = `srcard5-${data.comstoriesid}`;
                const reacted1 = document.createElement('a');
                reacted1.href = `javascript:void(0)`;
                const reacted2 = document.createElement('a');
                reacted2.href = `javascript:void(0)`;
                const reacted3 = document.createElement('a');
                reacted3.href = `javascript:void(0)`;
                const reacted4 = document.createElement('a');
                reacted4.href = `javascript:void(0)`;
                const reacted5 = document.createElement('a');
                reacted5.href = `javascript:void(0)`;
                const reactedimg1 = document.createElement('img');
                reactedimg1.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg1.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg1.setAttribute('data-reaksi4', 'suka');
                reactedimg1.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedimg2 = document.createElement('img');
                reactedimg2.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg2.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg2.setAttribute('data-reaksi4', 'suka');
                reactedimg2.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedimg3 = document.createElement('img');
                reactedimg3.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg3.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg3.setAttribute('data-reaksi4', 'suka');
                reactedimg3.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedimg4 = document.createElement('img');
                reactedimg4.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg4.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg4.setAttribute('data-reaksi4', 'suka');
                reactedimg4.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedimg5 = document.createElement('img');
                reactedimg5.src = '{{ asset('partses/reaksi/suka.png') }}';
                reactedimg5.className = `iclikestory reaksi-btn4-${data.comstoriesid}`;
                reactedimg5.setAttribute('data-reaksi4', 'suka');
                reactedimg5.setAttribute('data-artiestoriesid4', `${data.comstoriesid}`);
                const reactedp = document.createElement('p');
                reactedp.className = `rbtnry5-${data.comstoriesid}`;
                reactedp.id = `rbtnry5-${data.comstoriesid}`;
                reactedp.innerText = 'suka';
                const createdate = document.createElement('p');
                createdate.className = `captionStoriess gg2`;
                createdate.innerHTML = `${data.timeAgo}`;
                const getChat = document.getElementById(`lagi-${data.reqplat}`);
                const balas = document.getElementById(`seerpl11-${data.reqplat}`);
                const urungkan = document.getElementById(`seerpl01-${data.reqplat}`);
                reply.append(aprofil, dispcard);
                aprofil.appendChild(imgprofil);
                dispcard.append(aname,messageprof);
                aname.appendChild(nameprofil);
                wrappercom3.append(reacted, reactedp, createdate);
                reacted.append(reacted1, reacted2, reacted3, reacted4, reacted5);
                reacted1.appendChild(reactedimg1);
                reacted2.appendChild(reactedimg2);
                reacted3.appendChild(reactedimg3);
                reacted4.appendChild(reactedimg4);
                reacted5.appendChild(reactedimg5);
                const getreplies = document.getElementById(`seerpl2-${data.reqplat}`);
                if (!balas) {
                    const balas1 = document.getElementById(`balaskansaja-${data.reqplat}`);
                    const urungkan1 = document.getElementById(`urungkansaja-${data.reqplat}`);
                    const replies = document.createElement('div');
                    replies.className = `replies replies-${data.reqplat}`;
                    replies.id = `seerpl2-${data.reqplat}`;
                    const makebalaskan = document.createElement('p');
                    makebalaskan.className = `balaskan002`;
                    makebalaskan.id = `seerpl11-${data.reqplat}`;
                    makebalaskan.innerHTML = `Lihat(${data.jumlah})`;
                    const makeurungkan = document.createElement('p');
                    makeurungkan.className = `urungkan001`;
                    makeurungkan.id = `seerpl01-${data.reqplat}`;
                    makeurungkan.innerHTML = `Tutup(${data.jumlah})`;
                    if (balas1 && balas1.classList.contains('hidden')) {
                        makebalaskan.classList.add('hidden');
                    } else {
                        makeurungkan.classList.add('hidden');
                        replies.classList.add('hidden');
                    }
                    if (urungkan1) urungkan1.remove();
                    if (balas1) balas1.remove();
                    function waitForElement(selector, callback) {
                        const el = document.querySelector(selector);
                        if (el) {
                            callback(el);
                            return;
                        }
                        const observer = new MutationObserver((mutations, obs) => {
                            const el = document.querySelector(selector);
                            if (el) {
                                obs.disconnect();
                                callback(el);
                            }
                        });
                        observer.observe(document.body, { childList: true, subtree: true });
                    }
                    waitForElement(`#wrappercom2-${data.reqplat}`, (wrappercom2) => {
                        wrappercom2.appendChild(replies);
                        replies.append(reply, wrappercom3, getChat);
                        const getsuka = document.getElementById(`rbtnry3-${data.reqplat}`);
                        if (getsuka) getsuka.after(makebalaskan);
                        makebalaskan.after(makeurungkan);
                    });
                } if (balas) {
                    const makebalaskan = document.createElement('p');
                    makebalaskan.className = `balaskan002`;
                    makebalaskan.id = `seerpl11-${data.reqplat}`;
                    makebalaskan.innerHTML = `Lihat(${data.jumlah})`;
                    balas.replaceWith(makebalaskan);
                    if (urungkan) {
                        const makeurungkan = document.createElement('p');
                        makeurungkan.className = `urungkan001`;
                        makeurungkan.id = `seerpl01-${data.reqplat}`;
                        makeurungkan.innerHTML = `Tutup(${data.jumlah})`;
                        urungkan.replaceWith(makeurungkan);
                        if (getreplies && getreplies.classList.contains('hidden')) {
                            makeurungkan.classList.add('hidden');
                        } else {
                            makebalaskan.classList.add('hidden');
                        }
                        balas.replaceWith(makebalaskan);
                        getreplies.append(reply, wrappercom3, getChat);
                    };
                };
                getChat.classList.remove('hidden');
                clearTimeout(window.typingTimeout3);
                window.typingTimeout3 = setTimeout(() => {
                    window.canFetchTyping3 = true;
                }, 1000);
            }
        }
    });
    if (typeof window.channel4 === 'undefined') {
        window.channel4 = window.pusher1.subscribe('broadcast-channel1');
    }
    window.channel4.bind('broadcast.typing1', function (data) {
        if (data.reqplat && data.reqplat.length > 0) {
            const cardmengetik = document.getElementById(`divbrcmt2-${data.reqplat}`);
            const teksmengetik = document.getElementById(`brcmt2-${data.reqplat}`);
            cardmengetik.classList.remove('hidden');
            teksmengetik.innerText = `${data.username} sedang mengetik...`;
            clearTimeout(window.typingTimeouts?.[data.reqplat]);
            window.typingTimeouts = window.typingTimeouts || {};
            window.typingTimeouts[data.reqplat] = setTimeout(() => {
                teksmengetik.innerText = '';
                cardmengetik.classList.add('hidden');
            }, 4000);
        }
    });
  </script>