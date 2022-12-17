<?php
$judul = "Daftar Pengguna";
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";
require __DIR__ . "/../../template/header.php";
require __DIR__ . "/../../template/nav.php";
IsLogin();

$query = "SELECT * FROM akun";
$result = mysqli_query($koneksi, $query);
?>
<!-- content -->
<div class="container">
    <div class="row py-4">
        <div class="col">
            <div class="d-flex justify-content-between mb-3">
                <h5>Daftar Pengguna</h5>
                <a href="<?= BaseUrl('admin/pengguna/create') ?>" class="btn btn-primary">Tambah</a>
            </div>
            <?= Flash(); ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) :
                            $no = 1;
                            foreach ($result as $row) :
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $row['username']; ?></td>
                                    <td><?= $row['level']; ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <form class="me-3" action="<?= BaseUrl('admin/pengguna/edit') ?>" method="post">
                                                <?= Csrf(); ?>
                                                <button type="submit" name="id" value="<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</button>
                                            </form>
                                            <form action="<?= BaseUrl('admin/pengguna/destroy') ?>" method="post">
                                                <?= Csrf(); ?>
                                                <button type="submit" name="id" value="<?= $row['id'] ?>" onclick="return confirm('Data akan dihapus?')" name="id" class="btn btn-sm btn-danger" <?= ($row['id'] == $_SESSION['account']['id_user']) ? 'disabled' : ''; ?>>Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            endforeach;
                        else :
                            echo "<tr>";
                            echo "<td colspan='4'>Tidak Ada Data</td>";
                            echo "</tr>";
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- end content -->
<?php
require __DIR__ . "/../../template/footer.php";
?>
</body>

</html>
