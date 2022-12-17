<?php
$judul = "Edit Produk";
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";

IsLogin();
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);
if ($request_method === 'POST') :
    require __DIR__ . "/../../template/header.php";
    require __DIR__ . "/../../template/nav.php";

    $token = htmlspecialchars($_POST['token']);

    if (!$token || $token !== $_SESSION['token']) {
        echo "<p>Error: invalid form submission</p>";
        echo "<script>window.location.href(" . $_SERVER['SERVER_PROTOCOL'] . " 405 Method Not Allowed</script>";
        exit;
    }

    $_SESSION['id_produk'] = $_POST['id'];
    $query = "SELECT * FROM produk WHERE id = '" . $_POST['id'] . "'";
    $result = mysqli_query($koneksi, $query) or die("Query Gagal" . mysqli_error($koneksi));
    $row = mysqli_fetch_assoc($result);
?>
    <!-- content -->
    <div class="container pt-5">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Edit Produk</h4>
                    <a href="<?= BaseUrl('admin/produk/index'); ?>" class="btn btn-primary">Kembali</a>
                </div>
                <?= Flash(); ?>
                <form action="<?= BaseUrl('admin/produk/update'); ?>" method="post">
                    <?= Csrf(); ?>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Produk</label>
                        <input type="text" name="kode" id="kode" value="<?= $row['kode']; ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input type="text" name="nama" id="nama" value="<?= $row['nama']; ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga Jual Produk</label>
                        <input type="number" name="harga" value="<?= $row['harga']; ?>" id="harga" class="form-control">
                    </div>
                    <div class="text-end">
                        <button type="reset" class="btn btn-danger">Batal</button>
                        <button type="submit" class="btn btn-success">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end content -->
<?php
    require __DIR__ . "/../../template/footer.php";
else :
    echo "Request Not Found";
endif;
?>
</body>

</html>
