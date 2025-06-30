
@php 
$rcm2 = $reply->balcomstoriesid; @endphp
<div class="srcard4 srcard5-{{ $rcm2 }} hidden" id="srcard5-{{ $rcm2 }}">
    <a href="javascript:void(0)" >
        <img src="{{ asset('partses/reaksi/suka.png') }}"class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="suka" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/senang.png') }}"class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="senang" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/ketawa.png') }}"class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="ketawa" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/sedih.png') }}"class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="sedih" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
    </a>
    <a href="javascript:void(0)">
        <img src="{{ asset('partses/reaksi/marah.png') }}"class="iclikestory reaksi-btn4-{{ $rcm2 }}" data-reaksi4="marah" data-artiestoriesid4="{{ $reply->balcomstoriesid }}">
    </a>
</div>