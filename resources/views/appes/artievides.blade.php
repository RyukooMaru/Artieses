<div class="artievides-card1 hidden" id="artievides-form">
<div class="artievides-card">
    <button type="button" id="close-artievides" class="close">&times;</button>
    <h2>Artievides</h2>
    <form action="{{ route('file.upload.artievides') }}" method="POST" enctype="multipart/form-data" target="uploadTarget">
        @csrf
        <div class="input-group">
            <label for="judul">Judul: </label>
            <input type="text" id="judul" name="judul" placeholder="Masukkan judul Artievides" required>
        </div>
        <div class="input-group">
            <button type="button" class="uploades" id="pilihkategorian-artievides">Pilih Kategori</button>
            <input type="hidden" name="kseo" id="kseo-artievides" required>
            <div id="pilihkategori-artievides" class="droparea hidden">
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Teknologi">Teknologi</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Pendidikan">Pendidikan</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Kesehatan">Kesehatan</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Makanan">Makanan</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Olahraga">Olahraga</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Transportasi">Transportasi</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Bisnis">Bisnis</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Hiburan">Hiburan</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Seni">Seni</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Politik">Politik</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Lingkungan">Lingkungan</button>
                <button type="button" class="uploades kategori-btn-artievides" data-kategori-artievides="Pariwisata">Pariwisata</button>
            </div>
        </div>
        <div class="input-group">
            <label for="lseo">Deskripsi: </label>
            <input type="text" id="lseo" name="lseo" placeholder="Masukkan Deskripsi Artievides" required>
        </div>
        <div class="input-group">
            <button type="button" class="uploades" id="cardupload-artievides">Pilih Video</button>
            <div id="uploadfile-artievides" class="uploadfiles-artievides hidden">
                <div id="drop-area-artievides" class="drop-area">
                    <img src="{{ asset('partses/drages.png') }}">
                    <p>Pilih atau Tarik dan lepas file ke sini atau klik untuk memilih</p>
                    <input type="file" id="fileElem-artievides" name="video" hidden required>
                </div>
            </div>
        </div>
        <div class="input-group">
            <button type="button" class="uploades" id="cardupload1-artievides">Buat Thumbnail</button>
            <div id="uploadfile1-artievides" class="uploadfiles-artievides hidden">
                <div id="drop-area-artievides1" class="drop-area">
                    <img src="{{ asset('partses/drages.png') }}">
                    <p>Pilih atau Tarik dan lepas file ke sini atau klik untuk memilih</p>
                    <input type="file" id="fileElem-artievides1" name="thumbnail" hidden required>
                </div>
            </div>
        </div>
        <button type="submit" class="uploades">Upload</button>
    </form>
</div>
</div>
<script src="{{ asset('js/appes/artievides.js') }}"></script>