        @php
            $check = $story->reactStories->pluck('reaksi')->unique();
            
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
        @endphp
        @if($check->isEmpty()) 
        <div class="iclikeswrap1"></div>
        @else
        <div class="iclikeswrap1">
            <div class="iclikeswrap">
            @foreach($check as $reaksi)
                <img src="{{ asset('partses/reaksi/' . $reaksi . '.png') }}" class="iclikestories">
            @endforeach
            </div>
        </div>
        @endif