        @php
            $now = \Carbon\Carbon::now();
            $waktu = $story->created_at;
            $coderies = $story->coderies;
            $diffInMinutes1 = $waktu->diffInMinutes($now);
            $diffInHours1 = $waktu->diffInHours($now);
            $diffInDays1 = $waktu->diffInDays($now);
            $diffInWeeks1 = $waktu->diffInWeeks($now);
            $diffInMonths1 = $waktu->diffInMonths($now);
            $diffInYears1 = $waktu->diffInYears($now);
            
            $diffInMinutes = (int) $diffInMinutes1;
            $diffInHours = (int) $diffInHours1;
            $diffInDays = (int) $diffInDays1;
            $diffInWeeks = (int) $diffInWeeks1;
            $diffInMonths = (int) $diffInMonths1;
            $diffInYears = (int) $diffInYears1;

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
        <p class="captionStories" id="captionStories-{{ $coderies }}">{{ $timeAgo }}</p>