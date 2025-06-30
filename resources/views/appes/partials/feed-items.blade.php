@foreach ($mergedFeed as $item)
    @if ($item['type'] === 'video')
        @php $video = $item['data']; @endphp
        <div class="card-artievides1 card-artievides1{{ $video->codevides }}" id="card-artievides1{{ $video->codevides }}">
            @include('appes.artievides.artievides', ['video' => $video])
        </div>
    @elseif ($item['type'] === 'story')
        @php $story = $item['data']; @endphp
        @include('appes.artiestories.artiestories', ['story' => $story])
    @endif
@endforeach
