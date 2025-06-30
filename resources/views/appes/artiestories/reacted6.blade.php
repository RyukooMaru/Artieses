
@php 
$rcm2 = $reply->balcomstoriesid; @endphp
<div class="srcard3 srcard6-{{ $rcm2 }} hidden"style="margin-top:-40px; margin-left:-15px; z-index:999;" id="srcard6-{{ $rcm2 }}">
    <a href="javascript:void(0)" >
        <img src="{{ asset('partses/reaksi/suka.png') }}" style="margin-left: 5px; margin-top:-10px !important;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="suka" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/senang.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="senang" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/ketawa.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="ketawa" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/sedih.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="sedih" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/marah.png') }}" style="margin-top: 5px;" class="iclikestory reaksi-btn5-{{ $rcm2 }}" data-reaksi5="marah" data-artiestoriesid5="{{ $reply->balcomstoriesid }}">
    </a>
</div>