
  <script>
      if (typeof window.pusher === 'undefined') {
          Pusher.logToConsole = true;
          window.pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}", {
              cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
              forceTLS: true
          });
      }
      if (typeof window.channel === 'undefined') {
          window.channel = window.pusher.subscribe('typing');
      }
      if (typeof window.channel1 === 'undefined') {
          window.channel1 = window.pusher.subscribe('broadcast');
      }
      if (!window.channelBound1) {
          window.channel.bind('user', function (data) {
              if (data.message && data.message !== "") {
                  const targetWrapper = document.querySelector(`.commentarist[data-story="${data.coderies}"]`);
                  check1 = targetWrapper.getAttribute('data-story');
                  if (data.coderies === check1) {
                    const container = document.getElementById(`wrappercom1-${check1}`);
                    const apusnoncmt = document.getElementById(`noncomments-${data.coderies}`);
                    if (apusnoncmt) {
                        apusnoncmt.remove();
                    }
                    const commentwrapcom001 = document.createElement('div');
                    commentwrapcom001.id = `commentwrapcom-${data.comstoriesid}`;
                    const card = document.createElement('div');
                    card.className = `cardcom001 cardcom001-${data.comstoriesid}`;
                    const aharen = document.createElement('a');
                    aharen.href = `/profiles/${data.username}`;
                    const aharen1 = document.createElement('a');
                    aharen1.href = `/profiles/${data.username}`;
                    const img = document.createElement('img');
                    img.src = `${data.username}/profil/${data.improfil}`;
                    img.className = 'creatorstories';
                    const dispcard = document.createElement('div');
                    dispcard.className = 'dispcard';
                    const ddispcanam = document.createElement('div');
                    ddispcanam.className = 'ddispcanam';
                    const pName = document.createElement('p');
                    pName.className = 'dispname';
                    pName.innerText = data.username;
                    const pComment = document.createElement('p');
                    pComment.className = 'comment001';
                    const tempDiv = document.createElement("div");
                    tempDiv.innerHTML = data.message;
                    if (tempDiv.querySelector('img.imgcom')) {
                        pComment.innerHTML = data.message;
                    } else {
                        pComment.innerText = tempDiv.innerText;
                    }
                    const wrappercom2 = document.createElement('div');
                    wrappercom2.className = `wrappercom2 wrappercom2-${data.comstoriesid}`;
                    wrappercom2.id = `wrappercom2-${data.comstoriesid}`;
                    const balaskan001 = document.createElement('div');
                    balaskan001.className = `balaskan001`;
                    balaskan001.id = `balaskan001-${data.comstoriesid}`;
                    const suka = document.createElement('p');
                    suka.className = `inint rbtnry3-${data.comstoriesid}`;
                    suka.id = `rbtnry3-${data.comstoriesid}`;
                    suka.innerText = 'Suka';
                    const created = document.createElement('p');
                    created.className = 'captionStoriess gg12';
                    created.innerText = `${data.timeAgo}`;
                    const balaskan = document.createElement('p');
                    balaskan.className = `balaskan002 balaskansaja-${data.comstoriesid}`;
                    balaskan.id = `balaskansaja-${data.comstoriesid}`;
                    balaskan.innerText = 'Balas';
                    const urungkansaja = document.createElement('p');
                    urungkansaja.className = `urungkan001 urungkansaja-${data.comstoriesid} hidden`;
                    urungkansaja.id = `urungkansaja-${data.comstoriesid}`;
                    urungkansaja.innerText = 'Urungkan';
                    const dibaleslagi = document.createElement('div');
                    dibaleslagi.className = `dibales lagi-${data.comstoriesid}`;
                    dibaleslagi.id = `lagi-${data.comstoriesid}`;
                    const inpbalassaja = document.createElement('input');
                    inpbalassaja.type = 'text';
                    inpbalassaja.className = `inpbalassaja inpbalassaja-${data.comstoriesid}`;
                    inpbalassaja.id = `inpbalassaja-${data.comstoriesid}`;
                    inpbalassaja.placeholder = 'Kirim balasan...';
                    inpbalassaja.required = true;
                    const inpbalassajahidden = document.createElement('input');
                    inpbalassajahidden.type = 'hidden';
                    inpbalassajahidden.value = data.comstoriesid;
                    inpbalassajahidden.id = `inpbalassajahidden-${data.comstoriesid}`;
                    const submitDibales = document.createElement('button');
                    submitDibales.type = 'submit';
                    submitDibales.className = `btnimg-sendcom btnimg-sendcom-${data.comstoriesid}`;
                    submitDibales.id = `btnimg-sendcom-${data.comstoriesid}`;
                    const dibalesIMG = document.createElement('img');
                    dibalesIMG.className = 'iclikescmt1';
                    dibalesIMG.src = `{{ asset('partses/sendcomdm.png') }}`;
                    const imgupload = document.createElement('img');
                    imgupload.src = `{{ asset('partses/import.png') }}`;
                    imgupload.className = 'iclikestoryimp1';
                    imgupload.id = `importbtn1-${data.comstoriesid}`;
                    const inpfile = document.createElement('input');
                    inpfile.type = 'file';
                    inpfile.accept = 'image/*';
                    inpfile.id = `filepicker1-${data.comstoriesid}`;
                    inpfile.className = 'hidden';
                    const brort = document.createElement('div');
                    brort.className = `brcmt2 hidden`;
                    brort.id = `divbrcmt2-${data.comstoriesid}`;
                    const brortp = document.createElement('p');
                    brortp.id = `brcmt2-${data.comstoriesid}`;
                    const srcard3 = document.createElement('div');
                    srcard3.className = `srcard3 srcard-${data.comstoriesid} hidden`;
                    srcard3.id = `srcard3-${data.comstoriesid}`;
                    const reactedjava = document.createElement('a');
                    reactedjava.href = `javascript:void(0)`;
                    const reactedjava1 = document.createElement('a');
                    reactedjava1.href = `javascript:void(0)`;
                    const reactedjava2 = document.createElement('a');
                    reactedjava2.href = `javascript:void(0)`;
                    const reactedjava3 = document.createElement('a');
                    reactedjava3.href = `javascript:void(0)`;
                    const reactedjava4 = document.createElement('a');
                    reactedjava4.href = `javascript:void(0)`;
                    const reactedimg = document.createElement('img');
                    reactedimg.src = '{{ asset('partses/reaksi/suka.png') }}';
                    reactedimg.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                    reactedimg.id = `reaksi-btn2-${data.comstoriesid}`;
                    reactedimg.setAttribute('data-reaksi2', 'suka');
                    reactedimg.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                    const reactedimg1 = document.createElement('img');
                    reactedimg1.src = '{{ asset('partses/reaksi/senang.png') }}';
                    reactedimg1.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                    reactedimg1.id = `reaksi-btn2-${data.comstoriesid}`;
                    reactedimg1.setAttribute('data-reaksi2', 'senang');
                    reactedimg1.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                    const reactedimg2 = document.createElement('img');
                    reactedimg2.src = '{{ asset('partses/reaksi/ketawa.png') }}';
                    reactedimg2.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                    reactedimg2.id = `reaksi-btn2-${data.comstoriesid}`;
                    reactedimg2.setAttribute('data-reaksi2', 'ketawa');
                    reactedimg2.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                    const reactedimg3 = document.createElement('img');
                    reactedimg3.src = '{{ asset('partses/reaksi/sedih.png') }}';
                    reactedimg3.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                    reactedimg3.id = `reaksi-btn2-${data.comstoriesid}`;
                    reactedimg3.setAttribute('data-reaksi2', 'sedih');
                    reactedimg3.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                    const reactedimg4 = document.createElement('img');
                    reactedimg4.src = '{{ asset('partses/reaksi/marah.png') }}';
                    reactedimg4.className = `iclikestoriesemote3 reaksi-btn2 reaksi-btn2-${data.comstoriesid}`;
                    reactedimg4.id = `reaksi-btn2-${data.comstoriesid}`;
                    reactedimg4.setAttribute('data-reaksi2', 'marah');
                    reactedimg4.setAttribute('data-artiestoriesid2', `${data.comstoriesid}`);
                    const getreplies = document.createElement('div');
                    getreplies.className = `replies replies-${data.comstoriesid} hidden`;
                    getreplies.id = `seerpl2-${data.comstoriesid}`;
                    const deletecomment = document.createElement('img');
                    deletecomment.className = `delete-content`;
                    deletecomment.id = `delete-comment-${data.comstoriesid}`;
                    deletecomment.setAttribute('data-light', `{{ asset('partses/deletelm.png') }}`);
                    deletecomment.setAttribute('data-dark', `{{ asset('partses/deletedm.png') }}`);
                    deletecomment.src = "{{ asset('partses/deletedm.png')}}";
                    deletecomment.addEventListener('click', function () {
                        const idAttr = deletecomment.id;
                        const storyId = idAttr.replace('delete-comment-', '');
                        if (!storyId) return;
                        fetch('/delete-konten', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify({ id: storyId })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                const getwrapper = document.querySelector(`.commentwrapcom-${data.commentid}`);
                                if (getwrapper) {
                                    getwrapper.remove();
                                }
                            }
                        });
                    });
                    container.appendChild(commentwrapcom001);
                    reactedjava.appendChild(reactedimg);
                    reactedjava1.appendChild(reactedimg1);
                    reactedjava2.appendChild(reactedimg2);
                    reactedjava3.appendChild(reactedimg3);
                    reactedjava4.appendChild(reactedimg4);
                    srcard3.append(reactedjava, reactedjava1, reactedjava2, reactedjava3, reactedjava4);
                    commentwrapcom001.append(card, wrappercom2);
                    card.append(aharen, dispcard);
                    aharen.appendChild(img);
                    dispcard.append(ddispcanam, pComment, deletecomment);
                    ddispcanam.appendChild(aharen1);
                    aharen1.appendChild(pName);
                    wrappercom2.append(balaskan001, getreplies);
                    getreplies.appendChild(dibaleslagi);
                    balaskan001.append(srcard3, suka, balaskan, urungkansaja, created);
                    dibaleslagi.append(brort, imgupload, inpfile, inpbalassaja, inpbalassajahidden, submitDibales);
                    brort.appendChild(brortp);
                    submitDibales.appendChild(dibalesIMG);
                    balaskan.addEventListener('click', () => {
                        dibaleslagi.classList.remove('hidden');
                        balaskan.classList.add('hidden');
                        urungkansaja.classList.remove('hidden');
                        inpbalassaja.focus();
                    });
                    urungkansaja.addEventListener('click', () => {
                        dibaleslagi.classList.add('hidden');
                        balaskan.classList.remove('hidden');
                        urungkansaja.classList.add('hidden');
                    });
                    function setupSendButtonListener(submitButton, inputElement, hiddenInputElement, fileInputElement, targetId) {
                        submitButton.addEventListener('click', function(event) {
                            event.preventDefault();
                            const previewImageContainer = document.querySelector(`#divbrcmt2-${targetId} .image-preview1`);
                            handleSendComment(submitButton, inputElement, hiddenInputElement, fileInputElement, previewImageContainer, targetId);
                        });
                        inputElement.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter' && !e.shiftKey) {
                                e.preventDefault(); 
                                const previewImageContainer = document.querySelector(`#divbrcmt2-${targetId} .image-preview1`);
                                handleSendComment(submitButton, inputElement, hiddenInputElement, fileInputElement, previewImageContainer, targetId);
                            }
                        });
                    }
                    function handleSendComment(buttonElement, inputOL, commentses1, fileInput1, delprev1, targetid) {
                        if (buttonElement.disabled) return;
                        const message1 = inputOL.value.trim();
                        const storyCode1 = commentses1.value.trim();
                        const hasImage = fileInput1?.files.length > 0;
                        if (!hasImage && message1.length === 0) {
                            return;
                        }
                        buttonElement.disabled = true;
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                        const formData = new FormData();
                        formData.append('storyCode1', storyCode1);
                        formData.append('message1', message1);
                        if (hasImage) {
                            formData.append('fileInput1', fileInput1.files[0]);
                        }
                        fetch('/enter-typing1', {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrfToken },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.logged_in) {
                                window.location.href = data.redirect;
                                return;
                            }
                            inputOL.value = '';
                            if (fileInput1) fileInput1.value = '';
                            delprev1?.remove();
                            dibaleslagi.classList.add('hidden');
                            balaskan.classList.remove('hidden');
                            urungkansaja.classList.add('hidden');
                        })
                        .catch(error => console.error('Error:', error))
                        .finally(() => {
                            setTimeout(() => { buttonElement.disabled = false; }, 300);
                        });
                    }
                    function setupImageUpload(importButton, storyCode1, fileInputElement, inputElement) {
                        importButton.addEventListener('click', () => {
                            fileInputElement.click();
                        });

                        fileInputElement.addEventListener('change', function () {
                            const file = this.files[0];
                            if (file && file.type.startsWith('image/')) {
                                const reader = new FileReader();
                                reader.onload = function (event) {
                                    showImagePreview1(event.target.result, storyCode1, fileInputElement);
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                        inputElement.addEventListener('paste', function (e) {
                            const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                            for (let item of items) {
                                if (item.type.indexOf("image") === 0) {
                                    const file = item.getAsFile();
                                    const dataTransfer = new DataTransfer();
                                    dataTransfer.items.add(file);
                                    fileInputElement.files = dataTransfer.files;
                                    const reader = new FileReader();
                                    reader.onload = function (event) {
                                        showImagePreview1(event.target.result, storyCode1, fileInputElement);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }
                        });
                    }
                    function showImagePreview1(imageSrc, storyCode1, fileInputElement) {
                        const dibalesContainer = document.getElementById('lagi-' + storyCode1);
                        if (!dibalesContainer) return;

                        const oldPreview = dibalesContainer.querySelector('.image-preview1');
                        if (oldPreview) {
                            oldPreview.remove();
                        }
                        const preview = document.createElement('div');
                        preview.className = 'image-preview1 image-preview1-' + storyCode1;
                        preview.id = 'image-preview1-' + storyCode1;
                        preview.style.position = 'relative';
                        preview.style.display = 'inline-block';
                        const img = document.createElement('img');
                        img.src = imageSrc;
                        img.style.height = '60px';
                        img.style.borderRadius = '8px';
                        const delimg = document.createElement('button');
                        delimg.innerHTML = '&times;';
                        delimg.className = 'bcloimcom1';
                        delimg.onclick = () => {
                            preview.remove(); 
                            fileInputElement.value = '';
                        };
                        preview.appendChild(img);
                        preview.appendChild(delimg);
                        dibalesContainer.prepend(preview);
                    }
                    function setupHoverListeners(rbtrny3, srcard3) {
                        let hideTimeout;
                        function showCard() {
                            clearTimeout(hideTimeout);
                            srcard3.classList.remove('hidden');
                            rbtrny3.classList.add('hidden');
                        }
                        function hideCard() {
                            hideTimeout = setTimeout(() => {
                                if (!rbtrny3.matches(':hover') && !srcard3.matches(':hover')) {
                                    srcard3.classList.add('hidden');
                                    rbtrny3.classList.remove('hidden');
                                }
                            }, 250);
                        }
                        rbtrny3.addEventListener('mouseenter', showCard);
                        rbtrny3.addEventListener('mouseleave', hideCard);
                        srcard3.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
                        srcard3.addEventListener('mouseleave', hideCard);
                    }
                    setupHoverListeners(suka, srcard3);
                    setupSendButtonListener(submitDibales, inpbalassaja, inpbalassajahidden, inpfile, data.comstoriesid);
                    setupImageUpload(imgupload, data.comstoriesid, inpfile, inpbalassaja); 
                  }
              }
          });
          window.channelBound1 = true;
      };
      document.querySelectorAll('[id^="divbrcmt-"]').forEach(getstorycode => {
        const getstorycd = getstorycode.id.replace('divbrcmt-', '');
        window.channel1.bind('broadcast', function (data) {
            if (data.reqplat && data.reqplat.length > 0) {
              if (data.reqplat == getstorycd) {
                const cardmengetik = document.getElementById('divbrcmt-' + getstorycd);
                const teksmengetik = document.getElementById('brcmt-' + getstorycd);
                cardmengetik.classList.remove('hidden');
                teksmengetik.innerText = `${data.username} sedang mengetik...`;
                clearTimeout(window.typingTimeout);
                window.typingTimeout = setTimeout(() => {
                    teksmengetik.innerText = '';
                    cardmengetik.classList.add('hidden');
                }, 2000);
              }}
        });
      });
  </script>