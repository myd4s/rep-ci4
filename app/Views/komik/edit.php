<?= $this->extend('layout\templates'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="mt-3">Edit Data Komik</h2>
            <form action="/komik/update/<?= $komik['id']; ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" id="slug" value="<?= $komik['slug']; ?>">
                <input type="hidden" name="sampulLama" id="sampulLama" value="<?= $komik['sampul']; ?>">
                <div class="form-group row">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text"
                            class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul"
                            placeholder="judul" name="judul" autofocus
                            value="<?= (old('judul')) ? old('judul') :  $komik['judul'];   ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penulis" placeholder="penulis" name="penulis"
                            value="<?= (old('penulis')) ? old('penulis') : $komik['penulis']; ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penerbit" placeholder="penerbit" name="penerbit"
                            value="<?= (old('penerbit')) ? old('penerbit') : $komik['penerbit']; ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                    <div class="col-sm-2">
                        <img src="/img/<?= $komik['sampul']; ?>" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file"
                                class="custom-file-input <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?>"
                                id="sampul" name="sampul" onchange="previewImg()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('sampul'); ?>
                            </div>
                            <label class="custom-file-label" for="sampul"><?= $komik['sampul']; ?></label>
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<?= $this->endsection(); ?>