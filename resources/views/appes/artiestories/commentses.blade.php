@php 
    $storyCode = $story->coderies;
@endphp
<div class="wrappercom1" id="wrappercom1-{{ $storyCode }}">
@if ($story->comments->isEmpty())
    <p class="noncomments" id="noncomments-{{ $storyCode }}">Belum ada komentar</p>
@else
    @foreach ($story->comments as $i => $comment)
        @include('appes.artiestories.commentses1')
    @endforeach
@endif
</div>
