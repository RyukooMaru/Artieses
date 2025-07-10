    @php $storyCode = $story->coderies; 
        $itung = $story->comments_count; @endphp
    <div class="card-artiestories1" id="card-artiestories-{{ $storyCode }}">
        @include('appes.artiestories.brecreies')
        <a href="{{ route('profiles.show', ['username' => $story->usericonStories->username]) }}">
            <p class="p-artiestories">{{  Str::limit($story->usericonStories->username, 15) }}</p>
        </a>
        @php
            $images = $story->images->sortBy('artiestoriestypeid');
            $totalImages = $images->count();
        @endphp
        <div id="image-container-{{ $storyCode }}" class="image-container">
            @foreach ($images as $index => $img)
                @php
                    $videoTypes = ['mp4', 'webm', 'ogg'];
                    $imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                    $fileId = $img->konten;

                    $isVideo = in_array(strtolower($img->type), $videoTypes);
                    $isImage = in_array(strtolower($img->type), $imageTypes);
                @endphp
                @if ($isImage)
                    <img src="{{ url('/konten/'. $fileId) }}"
                        class="cardstories-awal cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }}"
                        id="cbtnry1-{{ $storyCode }}-{{ $index }}">
                @elseif ($isVideo)
                    <video controls
                        class="cardstories-awal cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }} cbtnry1vid-{{ $storyCode }}-{{ $index }}"
                        id="cbtnry1-{{ $storyCode }}-{{ $index }}">
                        <source src="{{ url('/konten/'. $fileId) }}" type="video/mp4">
                        Browsermu tidak mendukung video.
                    </video>
                @endif
            @endforeach
            <button id="previmg-{{ $storyCode }}" class="nav-button prev">◀</button>
            <button id="nextimg-{{ $storyCode }}" class="nav-button next">▶</button>
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
        @include('appes.artiestories.reacted')
        <div class="artiestories1" style="margin-left:10px; margin-top:10px;">
            @include('appes.artiestories.reacted1')
            <button class="rbtnry rbtnry-{{ $storyCode }}" id="rbtnry1-{{ $storyCode }}">
                <img class="iclikestory" loading="lazy" id="nullreact1-{{ $storyCode }}"
                    data-light="{{ asset('partses/likelm.png') }}"
                    data-dark="{{ asset('partses/likedm.png') }}">
            </button>
            <div class="commentarist-containe">
                @include('appes.artiestories.commentarist')
            </div>
            <button class="rbtnry cbtnry1-{{ $storyCode }}" id="cbtnry1-{{ $storyCode }}">
                <img class="iclikestory" loading="lazy"
                data-light="{{ asset('partses/commentlm.png') }}"
                data-dark="{{ asset('partses/commentdm.png') }}">
            </button>
        </div> 
        <p style="margin-top: 10px; margin-left:10px; font-size:13px;">{{ 0 + $story->react_stories_count }} Reaksi | {{ 0 + $story->comments_count }} Komentar</p>
        <p class="captionStories">{{ $story->caption }}</p>
        @include('appes.artiestories.cek')
      </div>