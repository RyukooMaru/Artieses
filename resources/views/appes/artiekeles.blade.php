<div class="artiekeles-card1 hidden" id="artiekeles-form">
    <div class="artiekeles-card">
        <button type="button" id="close-artiekeles" class="close">&times;</button>
        <h2>Artiekeles</h2>
        <form action="{{ route('file.upload.artiekeles') }}" method="POST" enctype="multipart/form-data" target="uploadTarget">
            @csrf
            <div class="input-group">
                <label for="judul">Judul: </label>
                <input type="text" id="judul" name="judul" placeholder="Masukkan judul Artiekeles" required>
            </div>
            <div class="input-group">
                <button type="button" class="uploades" id="pilihkategorian-artiekeles">Pilih Kategori</button>
                <input type="hidden" name="kseo" id="kseo-artiekeles" required>
                <div id="pilihkategori-artiekeles" class="droparea hidden">
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Teknologi">Teknologi</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Pendidikan">Pendidikan</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Kesehatan">Kesehatan</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Makanan">Makanan</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Olahraga">Olahraga</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Transportasi">Transportasi</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Bisnis">Bisnis</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Hiburan">Hiburan</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Seni">Seni</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Politik">Politik</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Lingkungan">Lingkungan</button>
                    <button type="button" class="uploades kategori-btn-artiekeles" data-kategori-artiekeles="Pariwisata">Pariwisata</button>
                </div>
            </div>
            <div class="input-group">
                <label for="lseo">Label: </label>
                <input type="text" id="lseo" name="lseo" placeholder="Masukkan Label Artiekeles" required>
            </div>
            <div class="input-group">
                <button type="button" class="uploades" id="cardupload-artiekeles">Masukan Artikel (docx/doc)</button>
                <div id="uploadfile-artiekeles" class="uploadfiles-artiekeles hidden">
                    <div id="drop-area-artiekeles" class="drop-area">
                        <img src="{{ asset('partses/drages.png') }}">
                        <p>Pilih atau Tarik dan lepas file ke sini atau klik untuk memilih</p>
                        <input type="file" id="fileElem-artiekeles" name="file" hidden required>
                    </div>
                </div>
            </div>
            <button type="submit" class="uploades">Upload</button>
        </form>
    </div>
</div>
<script src="{{ asset('js/appes/artiekeles.js') }}"></script>