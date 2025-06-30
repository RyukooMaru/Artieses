
@php $rcmId = $comment->commentartiestoriesid; @endphp
<div class="srcard3 srcard3-{{ $rcmId }} hidden" id="srcard3-{{ $rcmId }}">
    <a href="javascript:void(0)" >
        <img src="{{ asset('partses/reaksi/suka.png') }}"  class="iclikestoriesemote3 reaksi-btn2 reaksi-btn2-{{ $rcmId }}" data-reaksi2="suka" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/senang.png') }}" class="iclikestoriesemote3 reaksi-btn2 reaksi-btn2-{{ $rcmId }}" data-reaksi2="senang" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/ketawa.png') }}" class="iclikestoriesemote3 reaksi-btn2 reaksi-btn2-{{ $rcmId }}" data-reaksi2="ketawa" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/sedih.png') }}" class="iclikestoriesemote3 reaksi-btn2 reaksi-btn2-{{ $rcmId }}" data-reaksi2="sedih" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/marah.png') }}" class="iclikestoriesemote3 reaksi-btn2 reaksi-btn2-{{ $rcmId }}" data-reaksi2="marah" data-artiestoriesid2="{{ $comment->commentartiestoriesid }}">
    </a>        
</div>