<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artieses</title>
    <link rel="stylesheet" href="{{ asset('css/appes/artiestoriesprofil.css') }}">
    <link rel="stylesheet" href="{{ asset('css/appes/appes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/appes/artieprofil.css') }}">
    <link rel="stylesheet" href="{{ asset('css/appes/artiekeles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/appes/artievides.css') }}">
    <link rel="icon" href="{{ asset('partses/favicon.ico') }}">
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.13/dist/cropper.min.js"></script>
    @include('partses.baries')
</head>
<body class="dark-mode noscroll">
    @include('captchaes.captchaes')
    @if(session('alert'))
        <div class="feedback error">
            {{ session('alert') }}
        </div>
    @endif
    <div class="card-main">
        @php
            $isUserOwner = $user->username === session('username');
            $loggedInUser = \App\Models\Users::where('username', session('username'))->first();
            $isAdmin = $loggedInUser && $loggedInUser->admin;
        @endphp
        @if ($isAdmin)
            <img class="delete-profile" id="show-delete-confirm" data-light="{{ asset('partses/deletelm.png') }}" data-dark="{{ asset('partses/deletedm.png') }}">
            <div id="delete-confirm-card" class="card-confirm hidden">
                <p>Yakin ingin menghapus akun ini?</p>
                <button id="goto-captcha" class="btn-confirm">Ya, Lanjut ke Verifikasi</button>
                <button type="button" class="btn-cancel" id="cancel-delete">Batal</button>
            </div>
            @include('partses.js.deleteprofil')
        @else
        @endif
        @php
            $username = $user->username ?? 'defaultuser';
            $improfil = $user->improfil;
            $improfilurl = "https://drive.google.com/uc?export=view&id=$improfil";
        @endphp
        <div class="card-name">
            @if($improfilurl)
                @if($user->username == session('username'))
                    <div class="profile-container">
                        <img src="{{ $improfilurl }}" class="creatorprofile" alt="Foto Profil">
                        <img id="edit-photo-btn"
                            src="{{ asset('partses/editingdm.png') }}"
                            data-light="{{ asset('partses/editinglm.png') }}"
                            data-dark="{{ asset('partses/editingdm.png') }}" style="cursor:pointer;">
                    </div>
                    <input type="file" id="fileInput" accept=".jpg,.jpeg,.png,.webp,.gif" style="display: none;">
                    <div id="cropModal" class="card-confirm hidden">
                        <p>Crop Gambar</p>
                        <img id="preview-image" style="max-width: 100%; max-height: 400px;">
                        <button id="cropConfirmBtn">Crop & Lanjut</button>
                        <button id="cropCancelBtn">Batal</button>
                    </div>
                    <div id="photo-modal" class="card-confirm hidden">
                        <p>Konfirmasi Foto Profil</p>
                        <div>
                            <img id="crop-preview" style="max-width: 100%; max-height: 300px;" />
                        </div>
                        <button id="confirm-photo">Simpan</button>
                        <button id="cancel-photo">Batal</button>
                    </div>
                @else
                    <img src="{{ $improfilurl }}" class="creatorprofile">
                @endif
            @endif
            <div class="text-section">
                <div class="top-subs">
                    @if($user->username == session('username'))
                        <div class="edit-username-wrapper">
                            <span id="username-display" class="nameprofiles">
                                {{ $user->username }}
                                <img class="icon-img-p" id="edit-username-btn" data-light="{{ asset('partses/editinglm.png') }}" data-dark="{{ asset('partses/editingdm.png') }}" style="cursor:pointer;">
                            </span>
                            <input type="text" id="username-input" class="hidden-input" value="{{ $user->username }}" required style="display:none;">
                        </div>
                        <div id="confirm-username-card" class="card-confirm hidden">
                            <p>Yakin ingin mengubah username? Perubahan hanya bisa dilakukan 7 hari sekali.</p>
                            <div class="button-group-acc">
                                <button id="confirm-username-change">Ya, Ubah</button>
                                <button id="cancel-username-change">Batal</button>
                            </div>
                        </div>
                        <p class="nameprofiles use">
                            {{ $user->nameuse }}
                            <img class="icon-img-p" loading="lazy" data-light="{{ asset('partses/editinglm.png') }}" data-dark="{{ asset('partses/editingdm.png') }}" style="cursor:pointer;">
                        </p>
                        <input type="text" id="username-input" class="hidden-input" value="{{ $user->username }}" style="display:none;">
                    @else
                        <span class="nameprofiles">{{ $user->username }}</span>
                        <p class="nameprofiles use">{{ $user->nameuse }}</p>
                    @endif
                    @if($user->username == session('username'))
                    @else
                        @php
                            $isSubscribed = \App\Models\Subs::where('subscriber', session('userid'))->where('subscribing', $user->userid)->first();
                        @endphp
                        @if($isSubscribed)
                            <button class="btnsubs btnsubs{{ $user->userid }}" id="{{ $user->userid }}">Unsubscribe</button>
                        @else
                            <button class="btnsubs btnsubs{{ $user->userid }}" id="{{ $user->userid }}">Subscribe</button>
                        @endif
                    @endif
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const subscribeButtons = document.querySelectorAll('.btnsubs');
                            subscribeButtons.forEach(button => {
                                button.addEventListener('click', function () {
                                    const subscribing = this.id;
                                    if (subscribing) {
                                        fetch("{{ route('addsubs') }}", {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                            },
                                            body: JSON.stringify({
                                                subscribing: subscribing
                                            })
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            console.log(data);
                                            if (!data.logged_in) {
                                                sessionStorage.setItem('alert', data.alert);
                                                sessionStorage.setItem('form', data.form);
                                                window.location.href = data.redirect;
                                                return;
                                            }

                                            if (data.csrf) {
                                                document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.csrf);
                                            }

                                            // Opsional: update tampilan tombol
                                            if (data.subscribed) {
                                                button.textContent = 'Subscribed';
                                                button.classList.add('subscribed');
                                            } else {
                                                button.textContent = 'Subscribe';
                                                button.classList.remove('subscribed');
                                            }

                                            console.log(data.message);
                                        })
                                        .catch(err => {
                                            console.error('Fetch error:', err);
                                        });
                                    } else {
                                        console.error('User ID tidak valid!');
                                    }
                                });
                            });
                        });
                    </script>
                </div>
                <div class="subs">
                    <p>{{ $user->stories->count() + $user->videos->count() + $user->artiekeles->count() }} Konten</p>
                    <p>{{ $user->subscriber->count() }} Subscriber</p>
                    <p>{{ $user->subscribing->count() }} Subscribing</p>
                </div>
                <div class="bio">
                    @if($user->username == session('username'))
                        <p class="bio-text">
                            {{ $user->bio }}
                            <img id="edit-bio-btn" class="icon-img-p" loading="lazy"
                                data-light="{{ asset('partses/editinglm.png') }}"
                                data-dark="{{ asset('partses/editingdm.png') }}" style="cursor:pointer;">
                        </p>
                        <textarea id="bio-input" class="hidden-input" style="display:none;">{{ $user->bio }}</textarea>
                    @else
                        <p>{{ $user->bio }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="profile-content">
            <div class="tabs">
                <button class="tab-button active" data-tab="videos">Artievides</button>
                <button class="tab-button" data-tab="stories">Artiestories</button>
                <button class="tab-button" data-tab="articles">Artiekeles(BETA)</button>
            </div>
            <div id="videos-tab" class="tab-content active">
                <div class="video-grid">
                    @forelse($videscontent as $video)
                        <div class="video-item">
                            <a href="/Artievides?GetContent={{ $video->codevides }}">
                                <div class="video-container-{{ $video->codevides }}">
                                    @php
                                        $konten = $video->video;
                                        $thumbnail = $video->thumbnail;
                                        $thumbnailurl = "https://drive.google.com/uc?export=view&id=$thumbnailurl";
                                        $videourl = "https://drive.google.com/uc?export=view&id=$konten";
                                    @endphp
                                    <video muted id="hover-video-{{ $video->codevides }}" poster="{{ $thumbnailurl }}">
                                        <source src="{{ $videourl }}" type="video/mp4">
                                    </video>
                                    <div style="background: rgba(0, 0, 0, 0.6) !important" class="video-timer-profiles" id="video-timer-{{ $video->codevides }}">00:00 / 00:00</div>
                                    <h3>{{ $video->judul }}</h3>
                                </div>
                                <p class="date-artievides-profiles">
                                {{ \App\Helpers\inthelp::formatAngka($video->like_vides_count ?? 0) }} Disukai | 
                                {{ \App\Helpers\inthelp::formatWaktu($video->created_at) }}
                                </p>
                            </a>
                        </div>
                    @empty
                        <p>No videos available.</p>
                    @endforelse
                </div>
            </div>
            <div id="stories-tab" class="tab-content">
                <div class="stories-grid">
                    @forelse($storiescontent as $story)
                        @php
                            $images = $story->images->sortBy('artiestoriesimgid');
                            $totalImages = $images->count();
                            $storyCode = $story->coderies; 
                        @endphp
                        <div class="story-item" id="rclick">
                            @foreach ($images as $index => $img)
                                @php
                                    $videoTypes = ['mp4', 'webm', 'ogg'];
                                    $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                                    $fileId = $img->konten;
                                    $fileUrl = "https://drive.google.com/uc?export=view&id=$fileId";

                                    $isVideo = in_array(strtolower($img->type), $videoTypes);
                                    $isImage = in_array(strtolower($img->type), $imageTypes);
                                @endphp
                                @if ($isVideo)
                                    <video id="cbtnry1-{{ $storyCode }}-{{ $index }}" class="cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }}" controls>
                                        <source src="{{ $fileUrl }}" type="video/mp4">
                                        Browsermu tidak mendukung video.
                                    </video>
                                @elseif ($isImage)
                                    <img id="cbtnry1-{{ $storyCode }}-{{ $index }}" class="img-storyitem cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }}"
                                        src="{{ $fileUrl }}" alt="{{ $story->title }}">
                                @endif
                            @endforeach
                            <button id="previmg-{{ $storyCode }}" class="nav-button1 prev">◀</button>
                            <button id="nextimg-{{ $storyCode }}" class="nav-button1 next">▶</button>
                            <div class="commentarist-container">
                                @include('appes.artiestories.commentarist')
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                let currentIndex{{ $storyCode }} = 0;
                                const total{{ $storyCode }} = {{ $totalImages }};
                                const storyCode = "{{ $storyCode }}";
                                function showImage(index) {
                                    for (let i = 0; i < total{{ $storyCode }}; i++) {
                                        const element = document.getElementById(`cbtnry1-{{ $storyCode }}-${i}`);
                                        if (element) {
                                            element.classList.add('hidden');
                                            if (element.tagName === 'VIDEO') {
                                                element.pause();
                                            }
                                        }
                                    }
                                    const activeElement = document.getElementById(`cbtnry1-{{ $storyCode }}-${index}`);
                                    if (activeElement) {
                                        activeElement.classList.remove('hidden');
                                    }
                                }
                                document.getElementById(`nextimg-${storyCode}`)?.addEventListener('click', function () {
                                    currentIndex{{ $storyCode }} = (currentIndex{{ $storyCode }} + 1) % total{{ $storyCode }};
                                    showImage(currentIndex{{ $storyCode }});
                                });
                                document.getElementById(`previmg-${storyCode}`)?.addEventListener('click', function () {
                                    currentIndex{{ $storyCode }} = (currentIndex{{ $storyCode }} - 1 + total{{ $storyCode }}) % total{{ $storyCode }};
                                    showImage(currentIndex{{ $storyCode }});
                                });
                                let currentIndexComment{{ $storyCode }} = 0;
                                const totalComment{{ $storyCode }} = {{ $totalImages }};
                                function showImageComment(index) {
                                    for (let i = 0; i < total{{ $storyCode }}; i++) {
                                    const imagesComment = document.getElementById(`cbtnry001-${storyCode}-${i}`);
                                    if (imagesComment) imagesComment.classList.add('hidden');
                                }
                                    const activeImgComment = document.getElementById(`cbtnry001-${storyCode}-${index}`);
                                    if (activeImgComment) {activeImgComment.classList.remove('hidden');}
                                }
                                document.getElementById(`nextimg-{{ $storyCode }}-comment`)?.addEventListener('click', function () {
                                    currentIndexComment{{ $storyCode }} = (currentIndexComment{{ $storyCode }} + 1) % totalComment{{ $storyCode }};
                                    showImageComment(currentIndexComment{{ $storyCode }});
                                        currentIndex{{ $storyCode }} = (currentIndex{{ $storyCode }} + 1) % total{{ $storyCode }};
                                        showImage(currentIndex{{ $storyCode }});
                                });
                                document.getElementById(`previmg-{{ $storyCode }}-comment`)?.addEventListener('click', function () {
                                    currentIndexComment{{ $storyCode }} = (currentIndexComment{{ $storyCode }} - 1 + totalComment{{ $storyCode }}) % totalComment{{ $storyCode }};
                                    showImageComment(currentIndexComment{{ $storyCode }});
                                        currentIndex{{ $storyCode }} = (currentIndex{{ $storyCode }} - 1 + total{{ $storyCode }}) % total{{ $storyCode }};
                                        showImage(currentIndex{{ $storyCode }});
                                });
                            });
                        </script>
                    @empty
                        <p>No stories available.</p>
                    @endforelse
                </div>
            </div>
            <div id="articles-tab" class="tab-content">
                <h2>Articles</h2>
                <div class="articles-list">
                    @forelse($articlescontent as $article)
                        <div class="article-item">
                            <h3><a href="{{ route('article.show', $article->slug) }}">{{ $article->title }}</a></h3>
                            <p>{{ Str::limit($article->content, 150) }}</p>
                        </div>
                    @empty
                        <p>No articles available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/appes/togglemode.js') }}"></script>
    <script src="{{ asset('js/appes/artievides1.js') }}"></script>
    <script>
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteBtns = document.querySelectorAll('[id^="delete-content-"]');
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const idAttr = btn.id;
                    const storyId = idAttr.replace('delete-content-', '');
                    if (!storyId) {
                        return;
                    }
                    fetch('/delete-konten', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ artiestoriesid: storyId })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else if (data.requireCaptcha) {
                            const captchaFormes = document.getElementById('captcha-form');
                            captchaFormes.style.zIndex = '10000';
                            captchaFormes.classList.remove('hidden');
                        } else {
                        }
                    })
                });
            });
        });
    </script><!-- delete konten(first) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const runDelete = "{{ session('runDelete') }}";
            const storyId = "{{ session('artiestoriesid') }}";
            if (runDelete && storyId) {
                console.log('y');
                fetch('/delete-konten', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ artiestoriesid: storyId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                    }
                });
            }
        });
    </script><!-- tangkap delete(last) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const display = document.getElementById('username-display');
            const input = document.getElementById('username-input');
            const confirmCard = document.getElementById('confirm-username-card');
            const confirmBtn = document.getElementById('confirm-username-change');
            const cancelBtn = document.getElementById('cancel-username-change');

            document.getElementById('edit-username-btn').addEventListener('click', function () {
                display.style.display = 'none';
                input.style.display = 'inline-block';
                input.focus();
            });
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    confirmCard.classList.remove('hidden');
                }
            });
            cancelBtn.addEventListener('click', function () {
                confirmCard.classList.add('hidden');
                input.value = display.textContent.trim();
                display.style.display = 'inline-block';
                input.style.display = 'none';
            });
            confirmBtn.addEventListener('click', function () {
                const newUsername = input.value.trim();
                const oldUsername = display.textContent.trim();
                console.log("Mengirim fetch ke:", `/updateusername/${oldUsername}`);
                console.log("Username baru:", newUsername);
                fetch(`/updateusername/${encodeURIComponent(oldUsername)}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ username: newUsername }),
                })
                .then(async res => {
                    const text = await res.text();
                    console.log("Raw response:", text);
                    try {
                        const data = JSON.parse(text);
                        if (data.success) {
                            window.location.href = data.redirect;
                        } else {
                            alert(data.message);
                            confirmCard.classList.add('hidden');
                        }
                    } catch (e) {
                        console.error("Gagal parse JSON:", text);
                    }
                });
            });
        });
    </script><!-- edit profil(username) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameUseText = document.querySelector('.nameprofiles.use');
            const nameUseIcon = nameUseText.querySelector('img');
            const nameUseInput = document.createElement('input');
            nameUseInput.type = 'text';
            nameUseInput.className = 'hidden-input';
            nameUseInput.style.display = 'none';
            nameUseInput.value = nameUseText.textContent.trim();
            nameUseText.parentNode.insertBefore(nameUseInput, nameUseText.nextSibling);
            nameUseIcon.addEventListener('click', function () {
                nameUseInput.style.display = 'inline-block';
                nameUseInput.focus();
                nameUseText.style.display = 'none';
            });
            nameUseInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    const newNameUse = nameUseInput.value.trim();
                    if (!newNameUse) return;

                    fetch(`/updatenameuse/{{ $user->username }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ nameuse: newNameUse })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            nameUseText.childNodes[0].textContent = newNameUse + ' ';
                            nameUseText.style.display = 'block';
                            nameUseInput.style.display = 'none';
                        } else {
                            alert('Gagal mengubah nama pengguna.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan.');
                    });
                }
            });
        });
    </script><!-- edit profil(nameuse) -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const bioText = document.querySelector(".bio-text");
            const editBioBtn = document.getElementById("edit-bio-btn");
            const bioInput = document.getElementById("bio-input");

            if (editBioBtn && bioText && bioInput) {
                editBioBtn.addEventListener("click", function () {
                    bioText.style.display = "none";
                    bioInput.style.display = "block";
                    bioInput.focus();
                });

                function saveBio() {
                    const newBio = bioInput.value.trim();
                    const username = "{{ $user->username }}";

                    fetch(`/updatebio/${username}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ bio: newBio })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            bioText.innerHTML = `${newBio} <img id="edit-bio-btn" class="icon-img-p" loading="lazy"
                                data-light="{{ asset('partses/editinglm.png') }}"
                                data-dark="{{ asset('partses/editingdm.png') }}">`;
                            bioText.style.display = "block";
                            bioInput.style.display = "none";
                        } else {
                            alert(data.message || "Gagal memperbarui bio.");
                        }
                    });
                }

                bioInput.addEventListener("keydown", function (e) {
                    if (e.key === "Enter" && !e.shiftKey) {
                        e.preventDefault();
                        saveBio();
                    }
                });

                bioInput.addEventListener("blur", function () {
                    saveBio();
                });
            }
        });
    </script><!-- edit profil(bio) -->
    <script>
        let cropper;
        let selectedFile = null;
        const fileInput = document.getElementById('fileInput');
        const editBtn = document.getElementById('edit-photo-btn');
        const cropModal = document.getElementById('cropModal');
        const previewImage = document.getElementById('preview-image');
        const photoModal = document.getElementById('photo-modal');
        const cropPreview = document.getElementById('crop-preview');
        editBtn.addEventListener('click', () => {
            fileInput.click();
        });
        fileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const fileType = file.type;
            const isGIF = fileType === 'image/gif';
            const reader = new FileReader();
            reader.onload = function (e) {
                if (!isGIF) {
                    previewImage.src = e.target.result;
                    cropModal.classList.remove('hidden');
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(previewImage, {
                        aspectRatio: 1,
                        viewMode: 1
                    });
                    document.getElementById('cropConfirmBtn').onclick = function () {
                        cropper.getCroppedCanvas().toBlob(blob => {
                            selectedFile = blob;
                            cropPreview.src = URL.createObjectURL(blob);
                            cropModal.classList.add('hidden');
                            photoModal.classList.remove('hidden');
                        });
                    };
                    document.getElementById('cropCancelBtn').onclick = function () {
                        cropModal.classList.add('hidden');
                        if (cropper) cropper.destroy();
                    };
                } else {
                    cropPreview.src = e.target.result;
                    selectedFile = file;
                    photoModal.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(file);
        });
        document.getElementById('cancel-photo').addEventListener('click', () => {
            photoModal.classList.add('hidden');
            selectedFile = null;
        });
        document.getElementById('confirm-photo').addEventListener('click', () => {
            if (!selectedFile) return;
            const formData = new FormData();
            formData.append('foto', selectedFile);
            fetch(`/updatefoto/{{ $user->username }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            }).then(res => res.json())
            .then(res => {
                if (res.success) {
                    alert('Foto berhasil diperbarui');
                    location.reload();
                } else {
                    alert(res.message || 'Gagal mengunggah foto');
                }
            });
        });
    </script><!-- edit profil(foto) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            function activateTab(tabName) {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                const targetBtn = document.querySelector(`.tab-button[data-tab="${tabName}"]`);
                const targetTab = document.getElementById(`${tabName}-tab`);
                
                if (targetBtn && targetTab) {
                    targetBtn.classList.add('active');
                    targetTab.classList.add('active');
                }
            }
            const path = window.location.pathname;
            const tabFromPath = path.includes('/Artiestories') ? 'stories' :
                                path.includes('/Artiekeles') ? 'articles' :
                                path.includes('/Videos') ? 'videos' : null;

            if (tabFromPath) {
                activateTab(tabFromPath);
            } else {
                const defaultTab = tabButtons[0]?.dataset.tab;
                if (defaultTab) activateTab(defaultTab);
            }
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const target = button.dataset.tab;
                    activateTab(target);
                });
            });
        });
    </script><!-- select content -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[id^="hover-video-"]').forEach(video => {
                if (video.poster) {
                    video.dataset.originalPoster = video.poster;
                }
                const vcodes = video.id.replace('hover-video-', '');
                const timer = document.getElementById('video-timer-' + vcodes);
                const formatTime = (seconds) => {
                    if (isNaN(seconds) || seconds < 0) return '00:00';
                    const min = Math.floor(seconds / 60).toString().padStart(2, '0');
                    const sec = Math.floor(seconds % 60).toString().padStart(2, '0');
                    return `${min}:${sec}`;
                };
                video.addEventListener('mouseenter', () => {
                    video.play();
                });
                video.addEventListener('mouseleave', () => {
                    video.pause();
                    video.currentTime = 0;
                    video.load();
                });
                video.addEventListener('ended', () => {
                    video.currentTime = 0;
                    video.load();
                });
                video.addEventListener('loadedmetadata', () => {
                    if (timer) timer.textContent = `00:00 / ${formatTime(video.duration)}`;
                });
                video.addEventListener('timeupdate', () => {
                    if (timer) timer.textContent = `${formatTime(video.currentTime)} / ${formatTime(video.duration)}`;
                });
            });
        });
    </script>
    @include('appes.artiestories.js.commentarist')<!-- buka content artiestories -->
    @include('appes.artiestories.js.cnoscroll')<!-- noscroll open comment -->
    @include('appes.artiestories.js.commentarist001')<!-- open session artiestories -->
    @include('appes.artiestories.js.commentarist1')<!-- open reacted(if) artiestories -->
    @include('appes.artiestories.js.commentarist2')<!-- open reacted(else) artiestories -->
    @include('appes.artiestories.js.commentarist3')<!-- open reacted aftercomment(if) artiestories -->
    @include('appes.artiestories.js.commentarist4')<!-- open reacted aftercomment(else) artiestories -->
    @include('appes.artiestories.js.reacted1')<!-- give reacted artietories(if) -->
    @include('appes.artiestories.js.reacted2')<!-- give reacted artietories(else) -->
    @include('appes.artiestories.js.reacted3')<!-- give reacted comment artietories(if) -->
    @include('appes.artiestories.js.reacted4')<!-- give reacted comment artietories(else) -->
    @include('appes.artiestories.js.reacted5')<!-- give reacted balcom artietories(if) -->
    @include('appes.artiestories.js.reacted6')<!-- give reacted balcom artietories(else) -->
    @include('appes.artiestories.js.openclose')<!-- open close balas chat(first) -->
    @include('appes.artiestories.js.openclose1')<!-- open close balas chat(etc) -->
    @include('appes.artiestories.js.closecomment')<!-- close comment -->
    @include('appes.artiestories.js.checklogged')<!-- check user is logged? -->
    @include('appes.artiestories.js.fcpresend')<!-- chat awal preview send file(artiestories) -->
    @include('appes.artiestories.js.fetchreact')<!-- fetch reaksi artiestories -->
    @include('appes.artiestories.js.silent')<!-- silent console-->
    @include('appes.artiestories.js.preimg')<!-- preview img balascomment -->
    @include('appes.artiestories.js.broadcast2')<!-- fetch dan broadcast chat balas comment-->
    @include('appes.artiestories.js.pusher2')<!-- pusher broadcasting dan chat balas comment -->
    @include('appes.artiestories.js.broadcast1')<!-- fetch broadcasting dan chat awal comment -->
    @include('appes.artiestories.js.pusher1')<!-- pusher broadcasting dan chat awal comment -->
</body>
</html> 