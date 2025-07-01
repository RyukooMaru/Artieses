<link rel="stylesheet" href="{{ asset('css/partses/topbares.css') }}">
<link rel="stylesheet" href="{{ asset('css/partses/sidebares.css') }}">
<header class="top-navbar">
    <a href="{{ url('/') }}">
        <img src="{{ asset('partses/icouth.png') }}" alt="artieses, artiekeles" class="brandes"/>
    </a>
    <div class="search-wrapper">
        <form action="{{ route('appes.searches') }}" method="POST" class="search-form">
            @csrf
            <input type="text" name="search" id="search-input" placeholder="Cari sesuatu..." required />
            <button type="button" id="clear-btn">&times;</button>
        </form>
    </div>
    <button class="toggle-mode" data-mode="light">
        <img class="icon-img" data-light="{{ asset('partses/togglel.png') }}" 
            data-dark="{{ asset('partses/toggled.png') }}" alt="Toggle Mode" loading="lazy">
    </button>
    <button class="toggle-mode hidden" data-mode="dark">
        <img class="icon-img" 
            data-light="{{ asset('partses/togglel.png') }}" 
            data-dark="{{ asset('partses/toggled.png') }}" alt="Toggle Mode" loading="lazy">
    </button>
    <a href="javascript:void(0);" id="profile-icon">
    @if(session('isLoggedIn'))
        @php
            $viewUrl = session('improfil');
            $matches = [];
            preg_match('/\/d\/(.*?)\//', $viewUrl, $matches);
            $fileId = $matches[1] ?? null;
            $imgSrc = "https://drive.google.com/uc?export=view&id=$fileId";
        @endphp
        <img src="{{ url($imgSrc) }}" alt="Profile" class="improfiles" loading="lazy" data-light="{{ url($imgSrc) ?? asset('partses/logincon.png') }}" data-dark="{{ url($imgSrc) ?? asset('partses/loginconlm.png') }}"/>
    @else
        <img src="{{ asset('partses/logincon.png') }}" alt="Profile" class="improfiles" loading="lazy" data-light="{{ asset('partses/logincon.png') }}" data-dark="{{ asset('partses/loginconlm.png') }}"/>
    @endif
    </a>
        <div class="cardprof" id="cardprof">
            <div class="button-list">
                @if(session('isLoggedIn'))
                    <button class="button-group" onclick="window.location.href='{{ route('profiles.show', ['username' => session('username')]) }}'">
                        <span>{{ session('username') }}</span>
                        @php
                            $viewUrl = session('improfil');
                            $matches = [];
                            preg_match('/\/d\/(.*?)\//', $viewUrl, $matches);
                            $fileId = $matches[1] ?? null;
                            $imgSrc = "https://drive.google.com/uc?export=view&id=$fileId";
                        @endphp
                        <img src="{{ url($imgSrc) }}" alt="Profile" style="width:40px; height:40px;">
                    </button>
                @else
                    <button class="button-group" onclick="window.location.href='/logineses'">
                        <span>Login</span>
                        <img alt="Login" loading="lazy" data-light="{{ session('improfil') ?? asset('partses/logincon.png') }}" data-dark="{{ session('improfil') ?? asset('partses/loginconlm.png') }}">
                    </button>
                @endif
                <button class="button-group tm">
                    <span id="mode-text" data-dark="Dark Mode" data-light="Light Mode"></span>
                    <img class="icon-img1" loading="lazy"
                        data-light="{{ asset('partses/togglel.png') }}" 
                        data-dark="{{ asset('partses/toggled.png') }}"alt="Toggle Mode">
                </button>
            </div>
        </div>
</header>
<body>
    @if (!(request()->is('Artievides') && request()->has('GetContent')) && !(request()->is('profiles/*')) && !(Route::currentRouteName() === 'null.page'))
        <nav class="sidebar ">
            <a href="{{ url('/') }}" class="nav-item">
                <img class="icon-img" loading="lazy"
                    data-light="{{ asset('partses/hlm.png') }}"
                    data-dark="{{ asset('partses/hdm.png') }}">
                <span>Beranda</span>
            </a>
            <a href="javascript:void(0);" class="nav-item" id="buates">
                <img class="icon-img" loading="lazy" data-light="{{ asset('partses/alm.png') }}" data-dark="{{ asset('partses/adm.png') }}">
                <span>Buat</span>
            </a>
            <div class="cardbu" id="cardbu">
                <button id="show-artiekeles" class="nav-item">
                    <img class="icon-img" loading="lazy" data-light="{{ asset('partses/artiekeles.png') }}" data-dark="{{ asset('partses/artiekelesdm.png') }}">
                    <span>Artiekeles(BETA)</span>
                </button>
                @include('appes.artiekeles')
                <button id="show-artievides" class="nav-item">
                    <img class="icon-img" loading="lazy" data-light="{{ asset('partses/artievides.png') }}" data-dark="{{ asset('partses/artievidesdm.png') }}">
                    <span>Artievides</span>
                </button>
                @include('appes.artievides')
                <button id="show-artiestories" class="nav-item">
                    <img class="icon-img" loading="lazy" data-light="{{ asset('partses/artiestories.png') }}" data-dark="{{ asset('partses/artiestoriesdm.png') }}">
                    <span>Artiestories</span>
                </button>
                @include('appes.artiestories')
            </div> 
            <div class="carlert" id="carlert" style="{{ session('alert') ? 'display: block;' : 'display: none;' }}">
                @if(session('alert'))
                    <div class="feedback error">
                        {{ session('alert') }}
                    </div>
                @endif
            </div>
            @php
                $username = session('username');
            @endphp
            @if ($username)
                <a href="javascript:void(0);" class="nav-item" id="toggle-settings">
                    <img class="icon-img" loading="lazy"
                        data-light="{{ asset('partses/slm.png') }}"
                        data-dark="{{ asset('partses/sdm.png') }}">
                    <span>Settings</span>
                </a>
                <div class="card-setting hidden" id="card-setting">
                        <button class="nav-item" onclick="window.location.href='{{ route('profiles.show', ['username' => session('username')]) }}'">
                            <span>Edit Profil</span>
                        </button>
                    <a href="{{ url('/hapus-content') }}">
                        <button class="nav-item">
                            <span>Hapus Konten</span>
                        </button>
                    </a>
                    <button class="nav-item" id="show-delete-confirm">
                        <span>Hapus Akun</span>
                    </button>
                 </div>
            @else
            @endif
            @if(session('isLoggedIn'))
                <a href="{{ url('/logout') }}" class="nav-item">
                    <img class="icon-img" loading="lazy"
                        data-light="{{ asset('partses/llm.png') }}"
                        data-dark="{{ asset('partses/ldm.png') }}">
                    <span>Logout</span>
                </a>
            @elseif(!session('isLoggedIn'))
                <a href="{{ url('/logineses') }}" class="nav-item">
                    <img class="icon-img" loading="lazy"
                        data-light="{{ asset('partses/llm.png') }}"
                        data-dark="{{ asset('partses/ldm.png') }}">
                    <span>Login</span>
                </a>
            @endif
        </nav>
    @endif
</body>
@include('partses.js.deleteprofil')<!-- delete account -->
<script src="{{ asset('js/appes/artieses.js') }}"></script> 
<script src="{{ asset('js/partses/topbares.js') }}"></script>
<script src="{{ asset('js/partses/sidebares.js') }}"></script>
