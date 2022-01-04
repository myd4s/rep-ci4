<?= $this->extend('layout/templates'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="/img/<?= $komik['sampul']; ?>" alt="Card image cap">
                <div class="card-body tombol-middle">
                    <h5 class="card-title"><?= $komik['judul']; ?></h5>
                    <p class="card-text"><small class="text-muted"><b>Penulis: </b><?= $komik['penulis']; ?></small>
                    </p>
                    <p class="card-text"><small class="text-muted"><b>Penerbit: </b><?= $komik['penerbit']; ?></small>
                    </p>
                    <a href="" class="btn btn-warning">Edit</a>
                    <form action="/komik/<?= $komik['id']; ?>" method="POST" class="d-inline">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Hapus Data ini?')">Hapus</button>
                    </form>




                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endsection(); ?>