<div class="artiestories-card1 hidden" id="artiestories-form">
<div class="artiestories-card">
    <button type="button" id="close-artiestories" class="close">&times;</button>
    <h2>Artiestories</h2>
    <form action="{{ route('file.upload.artiestories') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group">
            <label for="caption">Caption: </label>
            <input type="text" id="caption" name="caption" placeholder="Masukkan Caption Artiestories" required>
        </div>

        <div class="input-group">
            <button type="button" class="uploades" id="pilihkategorian-artiestories">Pilih Kategori</button>
            <input type="hidden" name="kseo" id="kseo-artiestories" required>
            <div id="pilihkategori-artiestories" class="droparea hidden">
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Teknologi">Teknologi</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Pendidikan">Pendidikan</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Kesehatan">Kesehatan</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Makanan">Makanan</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Olahraga">Olahraga</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Transportasi">Transportasi</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Bisnis">Bisnis</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Hiburan">Hiburan</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Seni">Seni</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Politik">Politik</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Lingkungan">Lingkungan</button>
                <button type="button" class="uploades kategori-btn-artiestories" data-kategori-artiestories="Pariwisata">Pariwisata</button>
            </div>
        </div>

        <div class="input-group">
            <label for="lseo">Label: </label>
            <input type="text" id="lseo" name="lseo" placeholder="Masukkan Label Artiestories" required>
        </div>
        <div class="input-group">
            <button type="button" class="uploades" id="cardupload-artiestories">Masukan</button>
            <div id="uploadfile-artiestories" class="uploadfiles-artiestories hidden">
                <div id="drop-area-artiestories" class="drop-area">
                    <img src="{{ asset('partses/drages.png') }}">
                    <p>Pilih atau Tarik dan lepas file ke sini atau klik untuk memilih</p>
                    <input type="file" id="fileElem-artiestories" name="file[]" multiple hidden>
                </div>
                <div id="file-preview-artiestories" class="file-preview"></div>
                @include('appes.artiestories.js.upload')
            </div>
        </div>
        <button type="submit" class="uploades">Upload</button>
    </form>
</div>
</div>
<script src="{{ asset('js/appes/artiestories.js') }}"></script>