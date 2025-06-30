
@php $storyCode = $story->coderies; @endphp
<div class="srcard2 srcard2-{{ $storyCode }} hidden"style="margin-top:-15px; z-index:999;" id="srcard2-{{ $storyCode }}">
    <a href="javascript:void(0)" >
        <img src="{{ asset('partses/reaksi/suka.png') }}" style="margin-left: 5px; margin-top:-10px !important;" class="iclikestory reaksi-btn1-{{ $storyCode }}" data-reaksi1="suka" data-artiestoriesid1="{{ $story->artiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/senang.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn1-{{ $storyCode }}" data-reaksi1="senang" data-artiestoriesid1="{{ $story->artiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/ketawa.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn1-{{ $storyCode }}" data-reaksi1="ketawa" data-artiestoriesid1="{{ $story->artiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/sedih.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn1-{{ $storyCode }}" data-reaksi1="sedih" data-artiestoriesid1="{{ $story->artiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/marah.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn1-{{ $storyCode }}" data-reaksi1="marah" data-artiestoriesid1="{{ $story->artiestoriesid }}">
    </a>
</div>