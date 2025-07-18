<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
  <title>Artieses - Hasil Pencarian</title>
  @vite(['resources/css/appes/appes.css',
         'resources/css/appes/searches.css',
         'resources/css/appes/artiekeles.css',
         'resources/css/appes/artievides.css',
         'resources/css/appes/artiestories.css',
         'resources/js/appes/togglemode.js',
         'resources/js/appes/artiestories.js',
         'resources/js/appes/artievides.js',
         'resources/js/appes/artiekeles.js',
         ])
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <link rel="icon" href="{{ asset('partses/favicon.ico') }}">
  @include('partses.baries')
</head>
<body class="dark-mode">
    @if(session('alert'))
        <div class="feedback error">
            {{ session('alert') }}
        </div>
    @endif

    <div class="card-main-searches">
        <div class="card-main">
            <br>
            <h2>Hasil Pencarian untuk: "{{ $query }}"</h2>
            <br>
            <div class="filter-container">
                <div>
                    <button class="filter-btn active" data-filter-type="all" onclick="setActiveFilter(this); applyFilters();">Semua</button>
                    <button class="filter-btn" data-filter-type="video" onclick="setActiveFilter(this); applyFilters();">Video</button>
                    <button class="filter-btn" data-filter-type="story" onclick="setActiveFilter(this); applyFilters();">Story</button>
                    <button class="filter-btn" data-filter-type="article" onclick="setActiveFilter(this); applyFilters();">Artikel</button>
                    <button class="filter-btn" data-filter-type="account" onclick="setActiveFilter(this); applyFilters();">Akun</button>
                </div>
                <div class="category-filter">
                    <button class="filter-btn" id="category-btn" onclick="toggleDropdown('category-dropdown')">Kategori</button>
                    <div class="category-dropdown" id="category-dropdown">
                        <div class="category-grid">
                            <div>
                                <label><input type="radio" name="kategori" value="all" onchange="applyFilters()" checked> Semua Kategori</label>
                            </div>
                            @php
                                $categories = ['Teknologi', 'Pendidikan', 'Kesehatan', 'Makanan', 'Olahraga', 'Transportasi', 'Bisnis', 'Hiburan', 'Seni', 'Politik', 'Lingkungan', 'Pariwisata'];
                            @endphp
                            @foreach($categories as $category)
                                <div>
                                    <label><input type="radio" name="kategori" value="{{ strtolower($category) }}" onchange="applyFilters()"> {{ $category }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="category-filter">
                    <button class="filter-btn" id="date-filter-btn" onclick="toggleDropdown('date-dropdown')">Tanggal Upload</button>
                    <div class="category-dropdown" id="date-dropdown">
                        <div class="category-grid">
                            <div>
                                <label><input type="radio" name="tanggal" value="all" onchange="applyFilters()" checked> Kapan saja</label>
                            </div>
                            <div>
                                <label><input type="radio" name="tanggal" value="hour" onchange="applyFilters()"> Sejam terakhir</label>
                            </div>
                            <div>
                                <label><input type="radio" name="tanggal" value="today" onchange="applyFilters()"> Hari ini</label>
                            </div>
                            <div>
                                <label><input type="radio" name="tanggal" value="week" onchange="applyFilters()"> Minggu ini</label>
                            </div>
                            <div>
                                <label><input type="radio" name="tanggal" value="month" onchange="applyFilters()"> Bulan ini</label>
                            </div>
                            <div>
                                <label><input type="radio" name="tanggal" value="year" onchange="applyFilters()"> Tahun ini</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                @if($results->isEmpty())
                    <p>Konten yang Anda cari tidak ditemukan.</p>
                @else
                    @foreach ($results as $item)
                        @if ($item['type'] === 'account')
                            @php $account = $item['data']; @endphp
                            <div class="card-account filter-item" data-type="account">
                                @include('appes.account.account', ['account' => $account])
                            </div>
                        @elseif ($item['type'] === 'video')
                            @php $video = $item['data']; @endphp
                            <div class="card-artievides1 filter-item" data-type="video" data-date="{{ $video->created_at->toDateString() }}" data-category="{{ strtolower($video->kseo) }}" id="card-artievides1{{ $video->codevides }}">
                                @include('appes.artievides.artievides', ['video' => $video])
                            </div>
                        @elseif ($item['type'] === 'story')
                            @php $story = $item['data']; @endphp
                            <div class="filter-item" data-type="story" data-date="{{ $story->created_at->toDateString() }}" data-category="{{ strtolower($story->kseo) }}">
                            @include('appes.artiestories.artiestories', ['story' => $story])
                            </div>
                        @elseif ($item['type'] === 'article')
                            @php $article = $item['data']; @endphp
                            <div class="card-article filter-item" data-type="article" data-category="{{ strtolower($article->kseo) }}">
                                <h3>{{ $article->judul }}</h3>
                                <p>{{ Str::limit(strip_tags($article->konten), 100) }}</p>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <script>
        let currentPage = 2;
        let isLoading = false;
        window.addEventListener('scroll', () => {
            const nearBottom = window.innerHeight + window.scrollY >= document.body.offsetHeight - 300;
            if (nearBottom && !isLoading) {
                isLoading = true;
                fetch(`/load-feed?page=${currentPage}`)
                    .then(response => response.text())
                    .then(html => {
                        const container = document.querySelector('.wrapper');
                        container.insertAdjacentHTML('beforeend', html);
                        currentPage++;
                        isLoading = false;
                    })
                    .catch(error => {
                        console.error('Gagal memuat data:', error);
                        isLoading = false;
                    });
            }
        });
    </script>
    <script>
        function setActiveFilter(button) {
            document.querySelectorAll('.filter-btn[data-filter-type]').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        }
        function toggleDropdown(dropdownId) {
            document.querySelectorAll('.category-dropdown').forEach(dropdown => {
                if (dropdown.id !== dropdownId) {
                    dropdown.classList.remove('show');
                }
            });
            document.getElementById(dropdownId).classList.toggle('show');
        }
        function applyFilters() {
            const typeFilter = document.querySelector('.filter-btn[data-filter-type].active').dataset.filterType;
            const categoryFilter = document.querySelector('input[name="kategori"]:checked').value;
            const dateFilter = document.querySelector('input[name="tanggal"]:checked').value;
            const now = new Date();
            let startDate = null;
            if (dateFilter !== 'all') {
                switch (dateFilter) {
                    case 'hour':
                        startDate = new Date(now.getTime() - (60 * 60 * 1000));
                        break;
                    case 'today':
                        startDate = new Date(now.setHours(0, 0, 0, 0));
                        break;
                    case 'week':
                        const firstDayOfWeek = now.getDate() - now.getDay();
                        startDate = new Date(now.setDate(firstDayOfWeek));
                        startDate.setHours(0,0,0,0);
                        break;
                    case 'month':
                        startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                        break;
                    case 'year':
                        startDate = new Date(now.getFullYear(), 0, 1);
                        break;
                }
            }
            document.querySelectorAll('.filter-item').forEach(item => {
                const itemType = item.dataset.type;
                const itemCategory = item.dataset.category;
                const itemDate = new Date(item.dataset.date);
                const typeMatch = (typeFilter === 'all' || itemType === typeFilter);
                const categoryMatch = (categoryFilter === 'all' || itemCategory === categoryFilter);
                const dateMatch = (dateFilter === 'all' || itemDate >= startDate);
                if (typeMatch && categoryMatch && dateMatch) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            setTimeout(() => {
                document.querySelectorAll('.category-dropdown.show').forEach(d => d.classList.remove('show'));
            }, 200);
        }
        window.onclick = function(event) {
            if (!event.target.matches('.filter-btn')) {
                document.querySelectorAll('.category-dropdown.show').forEach(d => d.classList.remove('show'));
            }
        }
        document.addEventListener('DOMContentLoaded', () => {
            applyFilters();
        });
    </script>
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
    @include('appes.artiestories.js.commentarist0')
    @include('appes.artiestories.js.commentarist01')
    @include('appes.artiestories.js.commentarist')
    @include('appes.artiestories.js.cnoscroll')
    @include('appes.artiestories.js.commentarist001')
    @include('appes.artiestories.js.commentarist1')
    @include('appes.artiestories.js.commentarist2')
    @include('appes.artiestories.js.commentarist3')
    @include('appes.artiestories.js.commentarist4')
    @include('appes.artiestories.js.reacted1')
    @include('appes.artiestories.js.reacted2')
    @include('appes.artiestories.js.reacted3')
    @include('appes.artiestories.js.reacted4')
    @include('appes.artiestories.js.reacted5')
    @include('appes.artiestories.js.reacted6')
    @include('appes.artiestories.js.openclose')
    @include('appes.artiestories.js.openclose1')
    @include('appes.artiestories.js.closecomment')
    @include('appes.artiestories.js.checklogged')
    @include('appes.artiestories.js.fcpresend')
    @include('appes.artiestories.js.fetchreact')
    @include('appes.artiestories.js.silent')
    @include('appes.artiestories.js.preimg')
    @include('appes.artiestories.js.broadcast2')
    @include('appes.artiestories.js.pusher2')
    @include('appes.artiestories.js.broadcast1')
    @include('appes.artiestories.js.pusher1')
</body>
</html>
