
@php $storyCode = $story->coderies; @endphp
<div class="srcard1 srcard1-{{ $storyCode }} hidden"style="margin-top:-15px; z-index:999;" id="srcard1-{{ $storyCode }}">
    <a href="javascript:void(0)" >
        <img src="{{ asset('partses/reaksi/suka.png') }}" style="margin-left: 5px; margin-top:-10px !important;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="suka" data-artiestoriesid="{{ $story->artiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/senang.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="senang" data-artiestoriesid="{{ $story->artiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/ketawa.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="ketawa" data-artiestoriesid="{{ $story->artiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/sedih.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="sedih" data-artiestoriesid="{{ $story->artiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/marah.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn-{{ $storyCode }}" data-reaksi="marah" data-artiestoriesid="{{ $story->artiestoriesid }}">
    </a>
</div>