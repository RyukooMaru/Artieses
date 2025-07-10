@php 
    $storyCode = $story->coderies;
@endphp
<div id="commentarist-{{ $storyCode }}" class="commentarist commentarist-{{ $storyCode }} {{isset($open_commentarist) && $open_commentarist == $storyCode? (request()->is('profiles/') ? 'block' : 'block'): 'hidden'}}"data-story="{{ $storyCode }}">
    @php
        $isUserOwner = $story->usericonStories->username === session('username');
        $loggedInUser = \App\Models\Users::where('username', session('username'))->first();
        $isAdmin = $loggedInUser && $loggedInUser->admin;
    @endphp
    @if ($isUserOwner || $isAdmin)
        <img class="delete-content" id="delete-content-{{ $storyCode }}" data-light="{{ asset('partses/deletelm.png') }}" data-dark="{{ asset('partses/deletedm.png') }}">
    @else
    @endif
    <div class="commentaristcardimg">
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
                    class="crimg cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }}"
                    id="cbtnry001-{{ $storyCode }}-{{ $index }}" >
            @elseif ($isVideo)
                <video controls
                    class="crimg cardstories-{{ $storyCode }} {{ $index !== 0 ? 'hidden' : '' }}"
                    id="cbtnry001-{{ $storyCode }}-{{ $index }}" tabindex="-1">
                    <source src="{{ url('/konten/'. $fileId) }}" type="video/mp4">
                    Browsermu tidak mendukung video.
                </video>
            @endif
        @endforeach
        <button id="previmg-{{ $storyCode }}-comment" class="nav-button prev1">◀</button>
        <button id="nextimg-{{ $storyCode }}-comment" class="nav-button next1">▶</button>
        </div>
    <div class="commentaristcre">
        <div class="pemmisahcreator">
            @include('appes.artiestories.brecreies')
            <a href="{{ route('profiles.show', ['username' => $story->usericonStories->username]) }}">
                <p class="p-artiestories">{{ $story->usericonStories->username }}</p>   
            </a>
            <p class="captionStories">{{ $story->caption }}</p>
            @include('appes.artiestories.cek')
            @include('appes.artiestories.reacted')
            @include('appes.artiestories.reacted2')
            <div class="rbtnry001">
                <button class="rbtnry rbtnry2-{{ $storyCode }}" id="rbtnry2-{{ $storyCode }}">
                    <img class="iclikestory" loading="lazy" id="nullreact2-{{ $storyCode }}"
                        data-light="{{ asset('partses/likelm.png') }}"
                        data-dark="{{ asset('partses/likedm.png') }}">
                </button>
                <button class="rbtnry cbtnry1-{{ $storyCode }}">
                    <img class="iclikestory" loading="lazy"
                    data-light="{{ asset('partses/commentlm.png') }}"
                    data-dark="{{ asset('partses/commentdm.png') }}">
                </button>
            </div>
        </div>
        <div class="pemisah-comment">
            @include('appes.artiestories.commentses')
        </div>
        <div class="forchates">
            <div class="chat chat-{{ $storyCode }}">
                <div class="brcmt hidden" id="divbrcmt-{{ $storyCode }}">
                    <p id="brcmt-{{ $storyCode }}"></p>
                    <p id="Alert-Toxic-{{ $storyCode }}"></p>
                </div>
                <img src="{{ asset('partses/import.png') }}" class="iclikestoryimp" id="importbtn-{{ $storyCode }}">
                <input type="text" class="inpcom inpcom-{{ $storyCode }}" id="inpcom-{{ $storyCode }}" placeholder="Kirim komentar..." required/>
                <input type="file" accept="image/*" id="filepicker-{{ $storyCode }}" class="hidden" />
                <input type="hidden" value="{{ $storyCode }}" id="commentses-{{ $storyCode }}">
                <button type="button" class="balinpcom balinpcom-{{ $storyCode }} hidden" id="balinpcom-{{ $storyCode }}">&times;</button>
                <button type="submit" class="sendcom sendcom-{{ $storyCode }}" id="sendcom-{{ $storyCode }}">
                    <img class="iclikestory" loading="lazy" src="{{ asset('partses/sendcomdm.png') }}">
                </button>
            </div>
        </div>
    </div>      
    <button class="closecmtrst closecmtrst-{{ $storyCode }}" id="closeCommentarist-{{ $storyCode }}">&times;</button>
</div>