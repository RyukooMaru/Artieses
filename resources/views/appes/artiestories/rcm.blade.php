        @php
            $check = $comment->rcm1->pluck('reaksi')->unique();
            
            $getreactsuka = $check->where('reaksi', 'suka')->first();
            $getreactsenang = $check->where('reaksi', 'senang')->first();
            $getreactsedih = $check->where('reaksi', 'sedih')->first();
            $getreactmarah = $check->where('reaksi', 'marah')->first();
            $getreactketawa = $check->where('reaksi', 'ketawa')->first();
            
            $reactions = [
                'suka' => $getreactsuka,
                'marah' => $getreactmarah,
                'sedih' => $getreactsedih,
                'ketawa' => $getreactketawa,
                'senang' => $getreactsenang,
            ];
            $rcmId = $comment->commentartiestoriesid; 
        @endphp
        @if($check->isEmpty()) 
            @include('appes.artiestories.reacted3')
            <p class="inint rbtnry3-{{ $rcmId }}" id="rbtnry3-{{ $rcmId }}">Suka</p>
        @else
            @include('appes.artiestories.reacted4')
            <div class="iclikeswrap rbtnry4-{{ $rcmId }}" id="rbtnry4-{{ $rcmId }}">
            @foreach($check as $reaksi)
                <img src="{{ asset('partses/reaksi/' . $reaksi . '.png') }}" id="iclikeswrapimg-{{ $rcmId }}">
            @endforeach
            </div>
        @endif