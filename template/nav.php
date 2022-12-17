<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">SISBU</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BaseUrl('admin/spbu/index'); ?>">Daftar SPBU</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BaseUrl('admin/produk/index'); ?>">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BaseUrl('admin/pengguna/index'); ?>">Pengguna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BaseUrl('admin/penjualan/index'); ?>">Penjualan</a>
                </li>
                <div class="d-flex" role="logout">
                    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-body my-3 text-center">
                                    Apakah anda ingin keluar?
                                </div>
                                <form action="<?= BaseUrl('auth/logout') ?>" method="post">
                                    <div class="modal-footer justify-content-between">
                                        <?= Csrf(); ?>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Logout</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-danger ms-3" type="button" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
                </div>

            </ul>
        </div>
    </div>
</nav>
