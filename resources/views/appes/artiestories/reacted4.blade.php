
@php $rcmId = $comment->commentartiestoriesid; @endphp
<div class="srcard3 srcard4-{{ $rcmId }} hidden" id="srcard4-{{ $rcmId }}">
    <a href="javascript:void(0)" >
        <img src="{{ asset('partses/reaksi/suka.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="suka" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/senang.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="senang" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/ketawa.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="ketawa" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/sedih.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="sedih" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/marah.png') }}" class="iclikestoriesemote3 reaksi-btn3 reaksi-btn3-{{ $rcmId }}" data-reaksi3="marah" data-artiestoriesid3="{{ $comment->commentartiestoriesid }}">
    </a>
</div>