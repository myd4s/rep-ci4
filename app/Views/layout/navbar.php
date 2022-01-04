<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">MYd4s</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url('/'); ?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('about'); ?>">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('kontak'); ?>">Kontak</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('komik'); ?>">Komik</a>
            </li>
        </ul>
    </div>
</nav>