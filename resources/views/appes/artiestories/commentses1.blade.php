@php
    $firstReply = $comment->replies->first();
    $idbalcom = $firstReply->balcomstoriesid ?? null;
    $commentlagi = $comment->commentartiestoriesid;
    $username = $comment->userComments->username ?? 'defaultuser';
    $improfil = $comment->userComments->improfil ?? 'default.png';
    $path = $improfil;
    $ext = pathinfo($improfil, PATHINFO_EXTENSION);
    use Illuminate\Support\Str;
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
    $prefix = '<img src="' . url('/konten/');
    $now = \Carbon\Carbon::now();
    $waktunya = $comment->created_at;
    $diffInMinutes001 = $waktunya->diffInMinutes($now);
    $diffInHours001 = $waktunya->diffInHours($now);
    $diffInDays001 = $waktunya->diffInDays($now);
    $diffInWeeks001 = $waktunya->diffInWeeks($now);
    $diffInMonths001 = $waktunya->diffInMonths($now);
    $diffInYears001 = $waktunya->diffInYears($now);
    $diffInMinutes = (int) $diffInMinutes001;
    $diffInHours = (int) $diffInHours001;
    $diffInDays = (int) $diffInDays001;
    $diffInWeeks = (int) $diffInWeeks001;
    $diffInMonths = (int) $diffInMonths001;
    $diffInYears = (int) $diffInYears001;
    if ($diffInMinutes < 60) {
        $timeAgo = $diffInMinutes . ' menit yang lalu';
    } elseif ($diffInHours < 24) {
        $timeAgo = $diffInHours . ' jam yang lalu';
    } elseif ($diffInDays < 7) {
        $timeAgo = $diffInDays . ' hari yang lalu';
    } elseif ($diffInWeeks < 4) {
        $timeAgo = $diffInWeeks . ' minggu yang lalu';
    } elseif ($diffInMonths < 12) {
        $timeAgo = $diffInMonths . ' bulan yang lalu';
    } else {
        $timeAgo = $diffInYears . ' tahun yang lalu';
    }
@endphp
<div id="commentwrapcom-{{ $comment->commentartiestoriesid }}">
    <div class="cardcom001 cardcom001-{{ $commentlagi }}">
        @if($fileId)
            <a href="{{ route('profiles.show', ['username' => $comment->userComments->username]) }}">
                <img src="{{ url('/konten/' . $fileId) }}" class="creatorstories">
            </a>
        @endif
        <div class="dispcard">
            <div class="ddispcanam">
                <a href="{{ route('profiles.show', ['username' => $comment->userComments->username]) }}">
                    <p class="dispname">{{ $comment->userComments->username }}</p> 
                </a>
            </div>
            @if(Str::startsWith($comment->commentses, $prefix))
                <p class="comment001"> {!! $comment->commentses !!}</p>
            @else
                <p class="comment001">{{ $comment->commentses }}</p>
            @endif
            @php
                $isUserOwner = $comment->userComments->username === session('username');
                $loggedInUser = \App\Models\Users::where('username', session('username'))->first();
                $isAdmin = $loggedInUser && $loggedInUser->admin;
            @endphp
            @if ($isUserOwner || $isAdmin)
                <img class="delete-content" id="delete-comment-{{ $comment->commentartiestoriesid }}" data-light="{{ asset('partses/deletelm.png') }}" data-dark="{{ asset('partses/deletedm.png') }}">
            @else
            @endif
        </div>
    </div>
    <div class="wrappercom2 wrappercom2-{{ $commentlagi }}" id="wrappercom2-{{ $commentlagi }}">
        @if ($comment->replies->isEmpty())
            <div class="balaskan001" id="balaskan001-{{ $commentlagi }}">
                @include('appes.artiestories.rcm')
                <p class="balaskan002 balaskansaja-{{ $commentlagi }} " id="balaskansaja-{{ $commentlagi }}">Balas</p>
                <p class="urungkan001 urungkansaja-{{ $commentlagi }} hidden" id="urungkansaja-{{ $commentlagi }}">Urungkan</p>
                <p class="captionStoriess gg12">{{ $timeAgo }}</p>
            </div>
            <div class="dibales lagi-{{ $commentlagi }} hidden" id="lagi-{{ $commentlagi }}">
                <div class="brcmt2 hidden" id="divbrcmt2-{{ $commentlagi }}">
                    <p id="brcmt2-{{ $commentlagi }}"></p>
                    <p id="Alert-Toxic1-{{ $commentlagi }}"></p>
                </div>
                <img src="{{ asset('partses/import.png') }}" class="iclikestoryimp1" id="importbtn1-{{ $commentlagi }}">
                <input type="file" accept="image/*" id="filepicker1-{{ $commentlagi }}" class="hidden" />
                <input type="text" class="inpbalassaja inpbalassaja-{{ $commentlagi }}" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
                <input type="hidden" value="{{ $commentlagi }}" id="inpbalassajahidden-{{ $commentlagi }}">
                <button type="button" class="close-dibales close-dibales-{{ $commentlagi }} hidden" id="close-dibales-{{ $commentlagi }}"x>&times;</button>
                <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}" id="btnimg-sendcom-{{ $commentlagi }}">
                    <img class="iclikescmt1" src="{{ asset('partses/sendcomdm.png') }}">
                </button>
            </div>
        @else 
            <div class="balaskan001" id="balaskan001-{{ $commentlagi }}">
                @include('appes.artiestories.rcm')
                <p class="balaskan002" id="seerpl11-{{ $commentlagi }}">Lihat({{ count($comment->replies) }})</p>
                <p class="urungkan001 hidden" id="seerpl01-{{ $commentlagi }}">Tutup({{ count($comment->replies) }}) </p>
                <p class="captionStoriess gg12">{{ $timeAgo }}</p>
            </div>
            <div class="replies replies-{{ $commentlagi }} hidden" id="seerpl2-{{ $commentlagi }}">
                @foreach ($comment->replies as $reply)
                    <div class="reply reply-{{ $commentlagi }}">
                        @php
                            $username = $reply->userBalcom->username ?? 'defaultuser';
                            $improfil = $reply->userBalcom->improfil ?? 'default.png';
                            
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
                            <a href="{{ route('profiles.show', ['username' => $reply->userBalcom->username]) }}">
                                <img src="{{ url('/konten/' . $fileId) }}" class="creatorstories">
                            </a>
                        @endif
                        <div class="dispcard">
                            <a href="{{ route('profiles.show', ['username' => $reply->userBalcom->username]) }}">
                                <p class="dispname">{{ $reply->userBalcom->username }}</p>
                            </a>
                            @if(Str::startsWith($reply->comment, $prefix))
                                <p class="comment001">{!! $reply->comment !!}</p>
                            @else
                                <p class="comment001">{{ $reply->comment }}</p>
                            @endif                            
                            @php
                                $isUserOwner = $reply->userBalcom->username === session('username');
                                $loggedInUser = \App\Models\Users::where('username', session('username'))->first();
                                $isAdmin = $loggedInUser && $loggedInUser->admin;
                            @endphp
                            @if ($isUserOwner || $isAdmin)
                                <img class="delete-content" id="delete-comment1-{{ $commentlagi }}" data-light="{{ asset('partses/deletelm.png') }}" data-dark="{{ asset('partses/deletedm.png') }}">
                            @else
                            @endif
                        </div>
                        
                    </div>
                    <div class="wrappercom3 wrappercom3-{{ $commentlagi }}">
                        @include('appes.artiestories.rcm1')
                        @include('appes.artiestories.cek2')
                    </div>
                @endforeach
                <div class="dibales lagi-{{ $commentlagi }}" id="lagi-{{ $commentlagi }}">
                    <div class="brcmt2 hidden" id="divbrcmt2-{{ $commentlagi }}">
                        <p id="brcmt2-{{ $commentlagi }}"></p>
                    </div>
                    <img src="{{ asset('partses/import.png') }}" class="iclikestoryimp1" id="importbtn1-{{ $commentlagi }}">
                    <input type="file" accept="image/*" id="filepicker1-{{ $commentlagi }}" class="hidden" />
                    <input type="text" class="inpbalassaja inpbalassaja-{{ $commentlagi }}" id="inpbalassaja-{{ $commentlagi }}" placeholder="Kirim komentar..." required />
                    <input type="hidden" value="{{ $commentlagi }}" id="inpbalassajahidden-{{ $commentlagi }}">
                    <button type="button" class="close-dibales close-dibales-{{ $commentlagi }} hidden" id="close-dibales-{{ $commentlagi }}">&times;</button>
                    <button type="submit" class="btnimg-sendcom btnimg-sendcom-{{ $commentlagi }}" id="btnimg-sendcom-{{ $commentlagi }}">
                        <img class="iclikescmt1" id="iclikescmtbalcom-{{ $commentlagi }}" src="{{ asset('partses/sendcomdm.png') }}">
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
