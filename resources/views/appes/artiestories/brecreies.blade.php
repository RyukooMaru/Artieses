@php
    $username = $story->usericonStories->username;
    $improfil = $story->usericonStories->improfil;
    $path = $improfil;
    $matches = [];
    preg_match('/\/d\/(.*?)\//', $path, $matches);
    $fileId = $matches[1] ?? null;
    $imgSrc = "https://drive.google.com/uc?export=view&id=$fileId";
@endphp
@if($imgSrc)
    <a href="{{ route('profiles.show', ['username' => $username]) }}">
        <img src="{{ url($imgSrc) }}" class="creatorstories">
    </a>
@endif