
@php
    $username = $account->username;
    $improfil = $account->improfil;
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
<div class="itsprofil"> 
    <a href="{{ route('profiles.show', ['username' => $username]) }}">
        <div class="cabot-profil">
        @if($fileId)
            <div>
                <img src="{{ url('/konten/' . $fileId) }}" class="photo-profil">
            </div>
            @endif
            <div class="data-account">
                <p>{{ $account->username }}<span class="at-symbol">@</span><span class="at-symbol">{{ $account->nameuse }}</span></p>
                <p>{{ $account->subscriber->count() }} Subscriber</p>
                <p>{{ $account->stories->whereNull('deltime')->count() + $account->videos->whereNull('deltime')->count() + $account->artiekeles->whereNull('deltime')->count() }} Konten</p>
            </div>
        </div>
    </a>
</div>