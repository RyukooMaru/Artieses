<a href="/Artievides?GetContent={{ $video->codevides }}" class="">
  <div class="video-container video-container-{{ $video->codevides }}">
    <video width="100%" muted class="hover-video" id="hover-video-{{$video->codevides}}" poster="{{ url('/Artiethumb/' . basename($video->thumbnail) . '?GetContent=' . $video->codevides) }}">
      <source src="{{ url('/Artievides/' . basename($video->video) . '?GetContent=' . $video->codevides) }}" type="video/mp4">
    </video>
    <div class="video-timer" id="video-timer-{{$video->codevides}}">00:00 / 00:00</div>
  </div><br>
  <div class="cabot-artievides">
    @php
      $username = $video->usericonVides->username ?? 'defaultuser';
      $improfil = $video->usericonVides->improfil ?? 'default.png';
      $path = $username . '/profil/' . $improfil;
      $ext = pathinfo($improfil, PATHINFO_EXTENSION);
    @endphp
    @if(in_array(strtolower($ext), ['gif', 'png', 'jpg', 'jpeg', 'webp']))
      <div class="creator-1">
        <a href="{{ route('profiles.show', ['username' => $username]) }}">
            <img src="{{ asset($path) }}" class="creatorvides">
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