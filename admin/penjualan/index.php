<?php
$judul = "Data Penjualan";
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";
require __DIR__ . "/../../template/header.php";
require __DIR__ . "/../../template/nav.php";
IsLogin();

$today = date('y-m-d');
$lastWeek = date('y-m-d', strtotime('-7 days', strtotime($today)));
$query = "SELECT * FROM penjualan INNER JOIN spbu ON spbu.id = penjualan.id_spbu WHERE tanggal BETWEEN '$lastWeek' AND '$today'";
$result = mysqli_query($koneksi, $query);
?>

<!-- content -->
<div class="container">
    <div class="row py-4">
        <div class="col">
            <div class="d-flex justify-content-between mb-3">
                <h5>Daftar Penjualan SPBU</h5>
                <a href="<?= BaseUrl('admin/penjualan/create') ?>" class="btn btn-primary">Tambah</a>
            </div>
            <hr>
            <?= Flash(); ?>
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama SPBU</th>
                            <th>Penjualan (L)</th>
                            <th>Pendapatan (Rp)</th>
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
                                    <td><?= date('d F y', strtotime($row['tanggal'])); ?></td>
                                    <td><?= $row['nama']; ?></td>
                                    <td><?= number_format($row['total_penjualan'], 0, ',', '.'); ?></td>
                                    <td><?= number_format($row['total_pendapatan'], 0, ',', '.'); ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <form class="me-3" action="<?= BaseUrl('admin/penjualan/edit') ?>" method="post">
                                                <?= Csrf(); ?>
                                                <button type="submit" name="id" value="<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</button>
                                            </form>
                                            <form action="<?= BaseUrl('admin/penjualan/destroy') ?>" method="post">
                                                <?= Csrf(); ?>
                                                <button type="submit" name="id" value="<?= $row['id'] ?>" onclick="return confirm('Data akan dihapus?')" name="id" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            endforeach;
                        else :
                            echo "<tr>";
                            echo "<td colspan='5'>Tidak Ada Data</td>";
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
