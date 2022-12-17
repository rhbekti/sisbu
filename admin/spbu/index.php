<?php
$judul = "Data Spbu";
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";
require __DIR__ . "/../../template/header.php";
require __DIR__ . "/../../template/nav.php";
IsLogin();

$query = "SELECT * FROM spbu ORDER BY id ASC";
$result = mysqli_query($koneksi, $query);
?>
<!-- content -->
<div class="container">
    <div class="row py-4">
        <div class="col">
            <div class="d-flex justify-content-between mb-3">
                <h5>Daftar Persebaran SPBU</h5>
                <a href="<?= BaseUrl('admin/spbu/create') ?>" class="btn btn-primary">Tambah</a>
            </div>
            <hr>
            <?= Flash(); ?>
            <div id="map" style="width: 100%;height:60vh;"></div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor SPBU</th>
                            <th>Nama SPBU</th>
                            <th>Alamat</th>
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
                                    <td><?= $row['nomor']; ?></td>
                                    <td><?= $row['nama']; ?></td>
                                    <td><?= $row['alamat']; ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <form class="me-3" action="<?= BaseUrl('admin/spbu/edit') ?>" method="post">
                                                <?= Csrf(); ?>
                                                <button type="submit" name="id" value="<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</button>
                                            </form>
                                            <form action="<?= BaseUrl('admin/spbu/destroy') ?>" method="post">
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
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    const map = L.map('map').setView([-7.808208, 110.416342], 9);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    <?php
    foreach ($result as $row) : ?>
        setMarker(<?= $row['longtitude']; ?>, <?= $row['langtitude']; ?>, "<?= $row['nomor'] . ' ' . $row['nama']; ?>");
    <?php
    endforeach;
    ?>

    function setMarker(longtitude, langtitude, kode) {
        let mKer = L.marker([longtitude, langtitude], {}).bindPopup(kode).addTo(map);
    }
</script>
</body>

</html>
