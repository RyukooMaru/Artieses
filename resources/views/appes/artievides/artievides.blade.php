@php
  $konten = $video->video;
  $thumbnail = $video->thumbnail;
  $thumbnailurl = "https://drive.google.com/uc?export=view&id=$thumbnailurl";
  $videourl = "https://drive.google.com/uc?export=view&id=$konten";
@endphp
<a href="/Artievides?GetContent={{ $video->codevides }}" class="">
  <div class="video-container video-container-{{ $video->codevides }}">
    <video width="100%" muted class="hover-video" id="hover-video-{{$video->codevides}}" poster="{{ $thumbnailurl }}">
      <source src="{{ $videourl }}" type="video/mp4">
    </video>
    <div class="video-timer" id="video-timer-{{$video->codevides}}">00:00 / 00:00</div>
  </div><br>
  <div class="cabot-artievides">
    @php
      $username = $video->usericonVides->username;
      $improfil = $video->usericonVides->improfil;
      $path = $improfil;
      $matches = [];
      preg_match('/\/d\/(.*?)\//', $path, $matches);
      $fileId = $matches[1] ?? null;
      $imgSrc = "https://drive.google.com/uc?export=view&id=$fileId";
    @endphp
    @if($imgSrc)
      <div class="creator-1">
        <a href="{{ route('profiles.show', ['username' => $username]) }}">
            <img src="{{ $imgSrc }}" class="creatorvides">
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