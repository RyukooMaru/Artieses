@php
    $username = $story->usericonStories->username ?? 'defaultuser';
    $improfil = $story->usericonStories->improfil ?? 'default.png';
    $path = $improfil;
    $ext = strtolower(pathinfo($improfil, PATHINFO_EXTENSION));
    $validExt = in_array($ext, ['gif', 'png', 'jpg', 'jpeg', 'webp']);
@endphp
@if($validExt)
    <a href="{{ route('profiles.show', ['username' => $username]) }}">
        <img src="{{ asset($path) }}" class="creatorstories" alt="{{ asset($path) }}">
    </a>
@endif