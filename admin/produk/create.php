<?php
$judul = "Tambah Produk";
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";
require __DIR__ . "/../../template/header.php";
require __DIR__ . "/../../template/nav.php";
IsLogin();
?>
<!-- content -->
<div class="container pt-5">
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-6">
            <div class="d-flex justify-content-between mb-3">
                <h4>Tambah Produk</h4>
                <a href="<?= BaseUrl('admin/produk/index'); ?>" class="btn btn-primary">Kembali</a>
            </div>
            <?= Flash(); ?>
            <form action="<?= BaseUrl('admin/produk/store'); ?>" method="post">
                <?= Csrf(); ?>
                <div class="mb-3">
                    <label for="kode" class="form-label">Kode Produk</label>
                    <input type="text" name="kode" id="kode" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" name="nama" id="nama" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga Jual Produk</label>
                    <input type="number" name="harga" id="harga" class="form-control">
                </div>
                <div class="text-end">
                    <button type="reset" class="btn btn-danger">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end content -->
<?php
require __DIR__ . "/../../template/footer.php";
?>
</body>

</html>
