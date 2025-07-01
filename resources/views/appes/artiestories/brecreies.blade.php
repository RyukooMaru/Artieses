@php
    $username = $story->usericonStories->username;
    $improfil = $story->usericonStories->improfil;
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
@if($fileId)
    <a href="{{ route('profiles.show', ['username' => $username]) }}">
        <img src="{{ url('/konten/' . $fileId) }}" class="creatorstories">
    </a>
@endif
