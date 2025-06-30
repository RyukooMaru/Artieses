<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
  <title>Artieses</title>
  <link rel="stylesheet" href="{{ asset('css/appes/appes.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artiekeles.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artievides.css') }}">
  <link rel="stylesheet" href="{{ asset('css/appes/artiestories.css') }}">
  <link rel="icon" href="{{ asset('partses/favicon.ico') }}">
  @include('partses.baries')
</head>
<body class="dark-mode">
    @if(session('alert'))
        <div class="feedback error">
            {{ session('alert') }}
        </div>
    @endif

    <div class="card-main">
        <br>
        <h2>Hasil Pencarian untuk: "{{ $query }}"</h2>
        <br>
        <div class="wrapper">
            @if($results->isEmpty())
                <p>Konten yang Anda cari tidak ditemukan.</p>
            @else
                {{-- Loop ini sekarang hampir identik dengan halaman index Anda --}}
                @foreach ($results as $item)
                    @if ($item['type'] === 'video')
                        @php $video = $item['data']; @endphp
                        <div class="card-artievides1 card-artievides1{{ $video->codevides }}" id="card-artievides1{{ $video->codevides }}">
                            @include('appes.artievides.artievides', ['video' => $video])
                        </div>
                    @elseif ($item['type'] === 'story')
                        @php $story = $item['data']; @endphp
                        @include('appes.artiestories.artiestories', ['story' => $story])
                    @elseif ($item['type'] === 'article')
                        @php $article = $item['data']; @endphp
                        {{-- Anda bisa membuat partial view untuk artikel agar lebih rapi --}}
                        <div class="card-article"> {{-- Contoh wrapper --}}
                            <h3>{{ $article->judul }}</h3>
                            <p>{{ Str::limit(strip_tags($article->konten), 100) }}</p>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</body>
  <script src="{{ asset('js/appes/togglemode.js') }}"></script>
  <script>
    let currentPage = 2;
    let isLoading = false;

    window.addEventListener('scroll', () => {
        const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 300;
        if (nearBottom && !isLoading) {
            isLoading = true;
            document.getElementById('loader').style.display = 'block';

            fetch(`/load-feed?page=${currentPage}`)
                .then(response => response.text())
                .then(html => {
                    const container = document.getElementById('feed-container');
                    container.insertAdjacentHTML('beforeend', html);
                    currentPage++;
                    isLoading = false;
                    document.getElementById('loader').style.display = 'none';
                })
                .catch(error => {
                    console.log(`/load-feed?page=${currentPage}`);
                    console.error('Gagal memuat data:', error);
                    isLoading = false;
                    document.getElementById('loader').style.display = 'none';
                });
        }
    });
  </script><!-- lazy load -->
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
  </script><!-- video autoplay -->
  @include('appes.artiestories.js.commentarist0')<!-- give reacted artietories(front) -->
  @include('appes.artiestories.js.commentarist01')<!-- give reacted artietories(back) -->
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
</html>
