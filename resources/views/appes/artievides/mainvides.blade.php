<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artieses</title>
    @vite(['resources/js/appes/togglemode.js', 'resources/css/appes/mainartievides.css'])
    <link href="https://vjs.zencdn.net/8.5.3/video-js.css" rel="stylesheet" />
    <link rel="icon" href="{{ asset('partses/favicon.ico') }}">
    @include('partses.baries')
</head>
<body class="allvid">
  @include('captchaes.captchaesjs')
    <div class="cardvideomain" id="cardvideomain">
        <div class="video-page-container">
            <div class="main-video" id="main-video">
                <div class="video-wrapper" id="video-wrapper">
                    @php
                        $konten = $video->video;
                        $thumbnail = $video->thumbnail;
                        $kontenurl = $konten;
                        $thumburl = $thumbnail;
                        $kontenId = null;
                        $thumbId = null;
                        if ($kontenurl) {
                            if (preg_match('/\/d\/(.*?)\//', $kontenurl, $matches)) {
                                $kontenId = $matches[1];
                            } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $kontenurl, $matches)) {
                                $kontenId = $matches[1];
                            } elseif (!str_contains($kontenurl, 'drive.google.com')) {
                                $kontenId = $kontenurl;
                            }
                        }
                        if ($thumburl) {
                            if (preg_match('/\/d\/(.*?)\//', $thumburl, $matches)) {
                                $thumbId = $matches[1];
                            } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $thumburl, $matches)) {
                                $thumbId = $matches[1];
                            } elseif (!str_contains($thumburl, 'drive.google.com')) {
                                $thumbId = $thumburl;
                            }
                        }
                    @endphp
                    <video autoplay class="thevides" id="thevides" preload="auto" poster="{{ url('/konten/' . $thumbId) }}" src="{{ url('/konten/' . $kontenId) }}" controlslist="nodownload" tabindex="-1"></video>
                    <div id="video-key-catcher" class="video-catch"></div>
                    <div class="controls-container hidden" id="controls-container">
                        <div class="custom-progress-container" id="custom-progress-container">
                            <div class="custom-progress-bar-quick" id="custom-progress-bar-quick"></div>
                            <div class="custom-progress-bar" id="custom-progress-bar"></div>
                            <div class="hover-bar" id="hover-bar"></div>
                            <div class="custom-tooltip hidden" id="custom-tooltip"></div>
                        </div>
                        <div class="controls-bar">
                            <div class="controls-left">
                                <img class="pbv" data-play="{{ asset('partses/pbv.png') }}" id="pbv" src="{{ asset('partses/pbv.png') }}" data-pause="{{ asset('partses/pause.png') }}">
                                <img src="{{ asset('partses/next.png') }}" class="next" id="next">
                                <div class="volume-container">
                                    <img src="{{ asset('partses/volume.png') }}" class="vol" id="vol">
                                    <input type="range" id="volumeBar" class="volume-bar" min="0" max="1" step="0.01" value="0.5">
                                    <div class="video-timer-mains" id="video-timer">00:00 / 00:00</div>
                                </div>
                            </div>
                            <div class="controls-right">
                                <img src="{{ asset('partses/zin.png') }}" class="zin" id="zin">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="video-title">{{ $video->judul }}</div>
            <div class="video-info">
                @php
                    $username = $video->usericonVides->username;
                    $improfil = $video->usericonVides->improfil;
                    $viewUrl = $improfil;
                    $fileId = null;
                    $matches = [];
                    if ($viewUrl) {
                        if (preg_match('/\/d\/(.*?)\//', $viewUrl, $matches)) {
                            $fileId = $matches[1];
                        } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $viewUrl, $matches)) {
                            $fileId = $matches[1];
                        } elseif (!str_contains($viewUrl, 'drive.google.com')) {
                            $fileId = $viewUrl;
                        }
                    }
                @endphp
                <div class="kumpul">
                    @if($fileId)
                        <div class="creator-1">
                            <a href="{{ route('profiles.show', ['username' => $username]) }}">
                                <img src="{{ url('/konten/' . $fileId) }}" class="creatorvides">
                            </a>
                        </div>
                    @endif
                    <div class="video-meta">
                        <a href="{{ route('profiles.show', ['username' => $username]) }}">{{ $video->usericonVides->username }}</a>
                        <p>{{ $user->subscriber->count() }} Subscriber</p>
                    </div>
                    @php
                        $isUserOwner = $video->usericonVides->username === session('username');
                        $loggedInUser = \App\Models\Users::where('username', session('username'))->first();
                        $isAdmin = $loggedInUser && $loggedInUser->admin;
                    @endphp
                    @if ($isUserOwner || $isAdmin)
                        <img class="delete-content" id="delete-content-{{ $video->codevides }}" data-light="{{ asset('partses/deletelm.png') }}" data-dark="{{ asset('partses/deletedm.png') }}">
                    @else
                    @endif
                </div>
                @if($user->username == session('username'))
                @else
                    @php
                        $isSubscribed = \App\Models\Subs::where('subscriber', session('userid'))->where('subscribing', $user->userid)->first();
                        function formatLike($n) {
                            if ($n >= 1000000000) return round($n / 1000000000, 1) . 'm';
                            elseif ($n >= 1000000) return round($n / 1000000, 1) . 'jt';
                            elseif ($n >= 1000) return round($n / 1000, 1) . 'rb';
                            return $n;
                        } 
                    @endphp
                    @if($isSubscribed)
                        <button class="btnsubs1 btnsubs{{ $user->userid }}" id="{{ $user->userid }}">Unsubscribe</button>
                    @else
                        <button class="btnsubs1 btnsubs{{ $user->userid }}" id="{{ $user->userid }}">Subscribe</button>
                    @endif
                    <div class="btldl">
                        <button class="btnlivides btnlivides-{{ $video->codevides }}" id="btnlivides-{{ $video->codevides }}">
                            <img class="iclivides" loading="lazy"
                                data-light="{{ asset('partses/likedm.png') }}"
                                data-dark="{{ asset('partses/likedm.png') }}">
                        </button>
                        <strong>{{ \App\Helpers\inthelp::formatAngka($video->like_vides_count ?? 0) }}</strong>
                        <span>|</span>
                        <button class="btnlivides1 btnlivides-{{ $video->codevides }}" id="btnlivides-{{ $video->codevides }}">
                            <img class="iclivides" loading="lazy"
                                data-light="{{ asset('partses/dislikedm.png') }}"
                                data-dark="{{ asset('partses/dislikedm.png') }}">
                        </button>
                    </div>
                @endif
            </div>
            <div class="description">
                <p><strong>{{ \App\Helpers\inthelp::formatAngka($video->banyakviewyahemangiyah->count()) }} x ditonton | {{ \Carbon\Carbon::parse($video->created_at)->translatedFormat('d F Y') }}</strong></p>
                <p>{{ $video->lseo }}</p>
            </div>
        </div>
        <div class="recomvides">
            @foreach ($relatedVideos as $RelateVideo)
                @php
                    $konten = $RelateVideo->video;
                    $thumbnail = $RelateVideo->thumbnail;
                    $kontenurl = $konten;
                    $thumburl = $thumbnail;
                    $kontenId = null;
                    $thumbId = null;
                    if ($kontenurl) {
                        if (preg_match('/\/d\/(.*?)\//', $kontenurl, $matches)) {
                            $kontenId = $matches[1];
                        } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $kontenurl, $matches)) {
                            $kontenId = $matches[1];
                        } elseif (!str_contains($kontenurl, 'drive.google.com')) {
                            $kontenId = $kontenurl;
                        }
                    }
                    if ($thumburl) {
                        if (preg_match('/\/d\/(.*?)\//', $thumburl, $matches)) {
                            $thumbId = $matches[1];
                        } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $thumburl, $matches)) {
                            $thumbId = $matches[1];
                        } elseif (!str_contains($thumburl, 'drive.google.com')) {
                            $thumbId = $thumburl;
                        }
                    }
                @endphp
                <a href="/Artievides?GetContent={{ $RelateVideo->codevides }}" class="">
                    <div class="video-container video-container-{{ $RelateVideo->codevides }}">
                        <video width="100%" muted class="hover-video" id="hover-video-{{$RelateVideo->codevides}}" poster="{{ url('/konten/' . $thumbId) }}">
                        <source src="{{ url('/konten/' . $kontenId) }}" type="video/mp4">
                        </video>
                        <div class="video-timer-wrap" id="video-timer-{{$RelateVideo->codevides}}">00:00 / 00:00</div>
                    </div><br>
                    <div class="cabot-artievides">
                        @php
                            $username = $RelateVideo->usericonVides->username;
                            $improfil = $RelateVideo->usericonVides->improfil;
                            $viewUrl = $improfil;
                            $fileId = null;
                            if ($viewUrl) {
                                if (preg_match('/\/d\/(.*?)\//', $viewUrl, $matches)) {
                                    $fileId = $matches[1];
                                } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $viewUrl, $matches)) {
                                    $fileId = $matches[1];
                                } elseif (!str_contains($viewUrl, 'drive.google.com')) {
                                    $fileId = $viewUrl;
                                }
                            }
                        @endphp
                        @if($fileId)
                            <div class="creator-1">
                                <a href="{{ route('profiles.show', ['username' => $username]) }}">
                                    <img src="{{ url('/konten/' . $fileId) }}" class="creatorvides">
                                </a>
                            </div>
                        @endif
                        <div class="inf-video-related">
                            <h3 class="h3-artievides">{{ Str::limit($RelateVideo->judul, 15) }}</h3>
                            <a href="{{ route('profiles.show', ['username' => $username]) }}">
                                <p class="h5-artievides">{{ $username }}</p>
                            </a>
                            <p class="date-artievides" style="margin-top: 30px;">
                                {{ \App\Helpers\inthelp::formatAngka($RelateVideo->like_vides_count ?? 0) }} Disukai | 
                                {{ \App\Helpers\inthelp::formatWaktu($RelateVideo->created_at) }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".btnlivides").forEach(button => {
            button.addEventListener("click", function () {
                const codevides = this.id.replace("btnlivides-", "");

                fetch(`/like/${codevides}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        this.nextElementSibling.textContent = data.likes;
                    }
                });
            });
        });

        document.querySelectorAll(".btnlivides1").forEach(button => {
            button.addEventListener("click", function () {
                const codevides = this.id.replace("btnlivides-", "");

                fetch(`/dislike/${codevides}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        this.previousElementSibling.previousElementSibling.textContent = data.likes;
                    }
                });
            });
        });
    });
  </script><!-- like dislike video -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const cardmainVideo = document.getElementById('cardvideomain');
        const overlay = document.getElementById('video-key-catcher');
        const controlscontainer = document.getElementById('controls-container');
        const timer = document.querySelector('.video-timer');
        const videoWrapper = document.getElementById('video-wrapper');
        let hideControlsTimeout;
        let hideCursorTimeout;
        const video = document.getElementById('thevides');
        const progressContainer = document.getElementById('custom-progress-container');
        const progressBar = document.getElementById('custom-progress-bar');
        const progressQuick = document.getElementById('custom-progress-bar-quick');
        const pbv = document.getElementById('pbv');
        const next = document.getElementById('next');
        const vol = document.getElementById('vol');
        const tooltip = document.getElementById('custom-tooltip');
        const hoverBar = document.getElementById('hover-bar');
        const zinBtn = document.getElementById('zin');
        let wasPlayingBeforeDrag = false;
        let isDragging = false;
        function formatTime(seconds) {
            const m = Math.floor(seconds / 60);
            const s = Math.floor(seconds % 60);
            return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
        }
        function updateProgressBar() {
            const current = video.currentTime;
            const duration = video.duration || 0;
            const percent = (current / duration) * 100;
            progressBar.style.width = `${percent}%`;
            hoverBar.style.left = `${percent}%`;
        }
        function updateTimerAndProgress() {
            const current = video.currentTime;
            const duration = video.duration || 0;
            const percent = (current / duration) * 100;
            progressBar.style.width = `${percent}%`;
            timer.textContent = `${formatTime(current)} / ${formatTime(duration)}`;
        }
        video.addEventListener('timeupdate', updateProgressBar);
        video.addEventListener('loadedmetadata', updateProgressBar);
        video.addEventListener('timeupdate', updateTimerAndProgress);
        video.addEventListener('loadedmetadata', updateTimerAndProgress);
        progressContainer.addEventListener('mousemove', function (e) {
            const rect = progressContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const width = rect.width;
            const ratio = x / width;
            const time = video.duration * ratio;
            tooltip.textContent = formatTime(time);
            tooltip.style.left = `${x}px`;
            tooltip.classList.remove('hidden');
            progressQuick.classList.remove('hidden');
            progressQuick.style.width = `${x}px`;
        });
        progressContainer.addEventListener('mouseleave', function () {
            tooltip.classList.add('hidden');
            progressQuick.classList.add('hidden');
        });
        progressContainer.addEventListener('mousedown', function (e) {
            isDragging = true;
            wasPlayingBeforeDrag = !video.paused;
            video.pause();
            seekTo(e);
            document.body.classList.add('no-select');
            e.preventDefault();
        });
        document.addEventListener('mousemove', function (e) {
            if (isDragging) {
                seekTo(e);
                e.preventDefault();
            }
        });
        document.addEventListener('mouseup', function () {
            if (isDragging) {
                isDragging = false;
                if (wasPlayingBeforeDrag) {
                    video.play();
                }
                document.body.classList.remove('no-select');
            }
        });
        function seekTo(e) {
            const rect = progressContainer.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const ratio = Math.min(Math.max(x / rect.width, 0), 1);
            const time = video.duration * ratio;
            video.currentTime = time;
            updateProgressBar();
        }
        progressContainer.addEventListener('click', function (e) {
            if (!isDragging) {
                const rect = progressContainer.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const width = rect.width;
                const clickRatio = clickX / width;
                video.currentTime = video.duration * clickRatio;
            }
        });
        pbv.addEventListener('click', () => {
            if (video.paused) {
                video.play();
                pbv.src = pbv.dataset.pause;
            } else {
                video.pause();
                pbv.src = pbv.dataset.play;
            }
        });
        video.addEventListener('play', () => {
            pbv.src = pbv.dataset.pause;
        });
        video.addEventListener('pause', () => {
            pbv.src = pbv.dataset.play;
        });
        function hideCursor() {
            videoWrapper.style.cursor = 'none';
        }
        function showCursor() {
            videoWrapper.style.cursor = '';
            clearTimeout(hideCursorTimeout);
            hideCursorTimeout = setTimeout(hideCursor, 1500);
        }
        function showcursor1() {
            videoWrapper.style.cursor = '';
            clearTimeout(hideCursorTimeout);

        }
        function showControls() {
            controlscontainer.classList.add('show');
            controlscontainer.classList.remove('hidden');
            clearTimeout(hideControlsTimeout);
            hideControlsTimeout = setTimeout(() => {
                controlscontainer.classList.add('hidden');
                controlscontainer.classList.remove('show');
            }, 1500);
        }
        function showControls1() {
            controlscontainer.classList.add('show');
            controlscontainer.classList.remove('hidden');
            clearTimeout(hideControlsTimeout);
        }
        function hideControls() {
            controlscontainer.classList.remove('show');
            controlscontainer.classList.add('hidden');
            clearTimeout(hideControlsTimeout);
            hideControlsTimeout = setTimeout(() => {
                controlscontainer.classList.remove('show');
                controlscontainer.classList.add('hidden');
            }, 1500);
        }
        videoWrapper.addEventListener('mouseenter', () => {
            if (video.getAttribute('poster')) {
                hideControls();
            } else {
                if (video.paused) {
                    showcursor1();
                    showControls1();
                } else {
                    showControls();
                    showCursor();
                }
            }
        });
        videoWrapper.addEventListener('mousemove', () => {
            if (video.getAttribute('poster')) {
                hideControls();
            } else {
                if (video.paused) {
                    showcursor1();
                    showControls1();
                } else {
                    showControls();
                    showCursor();
                }
            }
        });
        videoWrapper.addEventListener('mouseleave', () => {
            if (video.getAttribute('poster')) {
                hideControls();
            } else {
                if (video.paused) {
                    showcursor1();
                    showControls1();
                } else {
                    showcursor1();
                    showControls1();
                }
            }
        });
        if (video.readyState >= 1) {
            updateTimerAndProgress();
        }
        overlay .addEventListener('click', () => {
            if (video.paused) {
                showControls();
                showCursor();
                video.play();
                video.removeAttribute('poster');
            } else {
                showcursor1();
                video.pause();
            }
        });
        document.addEventListener('keydown', function (event) {
            const activeTag = document.activeElement.tagName.toLowerCase();
            if (activeTag === 'input' || activeTag === 'textarea') return;
            switch (event.code) {
                case 'Space':
                    event.preventDefault();
                    if (video.paused) {
                        showCursor();
                        showControls();
                        video.play();
                        video.removeAttribute('poster');
                    } else {
                        showcursor1();
                        controlscontainer.classList.add('show');
                        controlscontainer.classList.remove('hidden');
                        video.pause();
                    }
                    break;
                case 'ArrowLeft':
                    event.preventDefault();
                    showControls();
                    requestAnimationFrame(() => {
                        video.currentTime = Math.max(0, video.currentTime - 10);
                    });
                    break;
                case 'ArrowRight':
                    event.preventDefault();
                    showControls();
                    requestAnimationFrame(() => {
                        video.currentTime += 10;
                    });
                    break;
            }
        });
        let originalStyle = "";
        let zoomed = false;
        function resetVideoStyles() {
            zinBtn.src = `{{ asset('partses/zin.png') }}`;
            video.setAttribute('style', originalStyle);
            controlscontainer.classList.add('controls-container');
            controlscontainer.classList.remove('controls-container-fs');
            overlay.classList.add('video-catch');
            overlay.classList.remove('video-catch-fullscreen');
            videoWrapper.classList.add('video-wrapper');
            videoWrapper.classList.remove('videowrapper-fullscreen');
            zinBtn.classList.remove('zinbtnfs');
            zinBtn.classList.add('zin');
            timer.classList.remove('timerfs');
            timer.classList.add('video-timer');
            progressContainer.classList.remove('cpcfs');
            progressContainer.classList.add('custom-progress-container');
            progressBar.classList.remove('cpbfs');
            progressBar.classList.add('custom-progress-bar');
            pbv.classList.remove('pbvfs');
            pbv.classList.add('pbv');
            next.classList.remove('nfs');
            next.classList.add('next');
            vol.classList.remove('vfs');
            vol.classList.add('vol');
            document.body.classList.remove('noscroll');
            zoomed = false;
        }
        zinBtn.addEventListener('click', () => {
            if (!zoomed) {
                const elem = document.documentElement; 
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }
                originalStyle = video.getAttribute('style') || '';
                controlscontainer.classList.remove('controls-container');
                controlscontainer.classList.add('controls-container-fs');
                videoWrapper.classList.remove('video-wrapper');
                videoWrapper.classList.add('videowrapper-fullscreen');
                video.style.position = 'fixed';
                video.style.top = '0';
                video.style.left = '0';
                video.style.width = '100vw';
                video.style.height = '100vh';
                video.style.objectFit = 'contain';
                video.style.borderRadius = 'none !important';
                overlay.classList.remove('video-catch');
                overlay.classList.add('video-catch-fullscreen');
                zinBtn.src = `{{ asset('partses/zout.png') }}`;
                zinBtn.classList.add('zinbtnfs');
                zinBtn.classList.remove('zin');
                timer.classList.add('timerfs');
                timer.classList.remove('video-timer');
                progressContainer.classList.add('cpcfs');
                progressContainer.classList.remove('custom-progress-container');
                progressBar.classList.add('cpbfs');
                progressBar.classList.remove('custom-progress-bar');
                pbv.classList.add('pbvfs');
                pbv.classList.remove('pbv');
                next.classList.add('nfs');
                next.classList.remove('next');
                vol.classList.add('vfs');
                vol.classList.remove('vol');
                document.body.classList.add('noscroll');
                zoomed = true;
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
            }
        });
        document.addEventListener('fullscreenchange', () => {
            if (!document.fullscreenElement) {
                resetVideoStyles();
            }
        });
        document.addEventListener('webkitfullscreenchange', () => {
            if (!document.webkitFullscreenElement) {
                resetVideoStyles();
            }
        });
        document.addEventListener('msfullscreenchange', () => {
            if (!document.msFullscreenElement) {
                resetVideoStyles();
            }
        });
    });
  </script><!-- video controller --->
  <script>
    const video = document.getElementById('thevides');
    const volumeIcon = document.getElementById('vol');
    const volumeBar = document.getElementById('volumeBar');
    const videoTimer = document.getElementById('video-timer');
    let hideVolumeBarTimeout;
    let isVolumeBarDragging = false;
    function showVolumeBar() {
        clearTimeout(hideVolumeBarTimeout);
        volumeBar.classList.remove('hidden');
        videoControls.classList.add('volume-visible'); 
    }

    function hideVolumeBar() {
        if (!isVolumeBarDragging) {
            hideVolumeBarTimeout = setTimeout(() => {
                volumeBar.classList.add('hidden');

                // Cukup hapus class dari kontainer
                videoControls.classList.remove('volume-visible');
            }, 300);
        }
    }
    volumeBar.addEventListener('mouseenter', () => {
        clearTimeout(hideVolumeBarTimeout);
    });
    volumeBar.addEventListener('mouseleave', () => {
        hideVolumeBar();
    });
    volumeBar.addEventListener('input', () => {
        video.volume = volumeBar.value;
    });
    volumeBar.addEventListener('mousedown', (e) => {
        isVolumeBarDragging = true;
        updateVolumeFromClick(e);
        e.preventDefault();
    });
    document.addEventListener('mousemove', (e) => {
        if (isVolumeBarDragging) {
            updateVolumeFromClick(e);
            e.preventDefault();
        }
    });
    document.addEventListener('mouseup', () => {
        if (isVolumeBarDragging) {
            isVolumeBarDragging = false;
            hideVolumeBar();
        }
    });
    function updateVolumeFromClick(e) {
        const rect = volumeBar.getBoundingClientRect();
        let clientX = e.clientX;
        if (clientX < rect.left) clientX = rect.left;
        if (clientX > rect.right) clientX = rect.right;
        const x = clientX - rect.left;
        const ratio = x / rect.width;
        volumeBar.value = ratio;
        video.volume = ratio;
    }
    video.volume = volumeBar.value;
    volumeIcon.addEventListener('click', () => {
        showVolumeBar();
        if (video.muted) {
            video.muted = false;
            video.volume = volumeBar.value > 0 ? volumeBar.value : 0.5;
        } else {
            video.muted = true;
        }
    });
    video.addEventListener('volumechange', () => {
        if (!video.muted) {
            volumeBar.value = video.volume;
        } else {
            volumeBar.value = 0;
        }
    });
  </script><!-- video setting volume -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const videoElement = document.getElementById('thevides');
        const mainVideoContainer = document.getElementById('main-video');
        function setVideoAspectRatio() {
            if (videoElement.videoWidth && videoElement.videoHeight) {
                mainVideoContainer.style.aspectRatio = `${videoElement.videoWidth} / ${videoElement.videoHeight}`;
                console.log(`Video loaded, setting aspect-ratio to: ${videoElement.videoWidth} / ${videoElement.videoHeight}`);
            }
        }
        videoElement.addEventListener('loadedmetadata', setVideoAspectRatio);
        videoElement.addEventListener('canplay', setVideoAspectRatio);
        if (videoElement.readyState >= 2) {
            setVideoAspectRatio();
        }
    });
  </script><!-- auto size setting video -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const subscribeButtons = document.querySelectorAll('.btnsubs1');
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
                        if (data.subscribed) {
                            button.innerText = 'Unsubcribe';
                        } else {
                            button.innerText = 'Subscribe';
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
  </script><!-- subs -->
  <script>updateVolumeFromClick
    document.addEventListener('DOMContentLoaded', function () {
        const deleteBtns = document.querySelectorAll('[id^="delete-content-"]');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const idAttr = btn.id;
                const videoId = idAttr.replace('delete-content-', '');
                if (!videoId) {
                    return;
                }
                fetch('/delete-konten', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ artievidesid: videoId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else if (data.requireCaptcha) {
                        const captchaFormes = document.getElementById('captcha-form');
                        const captchabody = document.getElementById('captchabody');
                        captchaFormes.style.zIndex = '10000';
                        captchaFormes.classList.remove('hidden');
                        captchabody.classList.remove('hidden');
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
        const videoId = "{{ session('artievidesid') }}";

        if (runDelete && videoId) {
            console.log('y');
            fetch('/delete-konten', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ artievidesid: videoId })
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
</body>
</html>
