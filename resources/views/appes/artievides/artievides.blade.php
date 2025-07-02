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
<a href="/Artievides?GetContent={{ $video->codevides }}" class="">
  <div class="video-container video-container-{{ $video->codevides }}">
    <video width="100%" muted class="hover-video" id="hover-video-{{$video->codevides}}" poster="{{ url('/konten/' . $thumbId) }}">
      <source src="{{ url('/konten/' . $kontenId) }}" type="video/mp4">
    </video>
    <div class="video-timer" id="video-timer-{{$video->codevides}}">00:00 / 00:00</div>
  </div><br>
  <div class="cabot-artievides">
    @php
      $username = $video->usericonVides->username;
      $improfil = $video->usericonVides->improfil;
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
    <a href="{{ route('profiles.show', ['username' => $username]) }}">
      <p class="h5-artievides">{{ $username }}</p>
    </a>
    <h3 class="h3-artievides">{{ Str::limit($video->judul, 15) }}</h3>
    <p class="date-artievides" style="margin-top: 30px;">
      {{ \App\Helpers\inthelp::formatAngka($video->like_vides_count ?? 0) }} Disukai | 
      {{ \App\Helpers\inthelp::formatWaktu($video->created_at) }}
    </p>
  </div>
</a>