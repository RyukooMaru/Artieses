@php
    $now = \Carbon\Carbon::now();
    $waktunya1 = $reply->created_at;
    $diffInMinutes002 = $waktunya1->diffInMinutes($now);
    $diffInHours002 = $waktunya1->diffInHours($now);
    $diffInDays002 = $waktunya1->diffInDays($now);
    $diffInWeeks002 = $waktunya1->diffInWeeks($now);
    $diffInMonths002 = $waktunya1->diffInMonths($now);
    $diffInYears002 = $waktunya1->diffInYears($now);

    
    $diffInMinutes1 = (int) $diffInMinutes002;
    $diffInHours1 = (int) $diffInHours002;
    $diffInDays1 = (int) $diffInDays002;
    $diffInWeeks1 = (int) $diffInWeeks002;
    $diffInMonths1 = (int) $diffInMonths002;
    $diffInYears1 = (int) $diffInYears002;

    if ($diffInMinutes1 < 60) {
        $timeAgo = $diffInMinutes1 . ' menit yang lalu';
    } elseif ($diffInHours1 < 24) {
        $timeAgo = $diffInHours1 . ' jam yang lalu';
    } elseif ($diffInDays1 < 7) {
        $timeAgo = $diffInDays1 . ' hari yang lalu';
    } elseif ($diffInWeeks1 < 4) {
        $timeAgo = $diffInWeeks1 . ' minggu yang lalu';
    } elseif ($diffInMonths1 < 12) {
        $timeAgo = $diffInMonths1 . ' bulan yang lalu';
    } else {
        $timeAgo = $diffInYears1 . ' tahun yang lalu';
    }
@endphp
<p class="captionStoriess gg2">{{ $timeAgo }}</p>