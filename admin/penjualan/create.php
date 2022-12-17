<?php
$judul = "Tambah Penjualan";
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";
require __DIR__ . "/../../template/header.php";
require __DIR__ . "/../../template/nav.php";
IsLogin();

// data produk
$query = "SELECT * FROM produk ORDER BY nama ASC";
$products = mysqli_query($koneksi, $query);

// data spbu
$query = "SELECT * FROM spbu ORDER BY nomor ASC";
$spbus = mysqli_query($koneksi, $query);

?>
<!-- content -->
<div class="container pt-5">
    <div class="row align-items-center justify-content-center">
        <div class="col-lg-6">
            <div class="d-flex justify-content-between mb-3">
                <h4>Tambah Penjualan</h4>
                <a href="<?= BaseUrl('admin/penjualan/index'); ?>" class="btn btn-primary">Kembali</a>
            </div>
            <?= Flash(); ?>
            <form action="<?= BaseUrl('admin/penjualan/store'); ?>" method="post">
                <?= Csrf(); ?>
                <div class="mb-3">
                    <input type="date" name="tanggal" id="tanggal" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Spbu</label>
                    <select name="spbu" id="spbu" class="form-select">
                        <option value="" disabled selected>-- Pilih Spbu --</option>
                        <?php
                        foreach ($spbus as $row) : ?>
                            <option value="<?= $row['id']; ?>"><?= $row['nomor'] . ' | ' . $row['nama']; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Produk</label>
                    <select name="produk" id="produk" class="form-select">
                        <option value="" disabled selected>-- Pilih Produk --</option>
                        <?php
                        foreach ($products as $row) : ?>
                            <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="sawal" class="form-label">Stok Awal</label>
                            <input type="text" name="sawal" id="sawal" value="0" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="sakhir" class="form-label">Stok Akhir</label>
                            <input type="text" name="sakhir" id="sakhir" value="0" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="tawal" class="form-label">Totalisator Awal</label>
                            <input type="text" name="tawal" id="tawal" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="takhir" class="form-label">Totalisator Akhir</label>
                            <input type="text" name="takhir" id="takhir" class="form-control">
                        </div>
                    </div>
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
