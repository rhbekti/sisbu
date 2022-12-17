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

    $_SESSION['id_spbu'] = $_POST['id'];
    $query = "SELECT * FROM spbu WHERE id = '" . $_POST['id'] . "'";
    $result = mysqli_query($koneksi, $query) or die("Query Gagal" . mysqli_error($koneksi));
    $row = mysqli_fetch_assoc($result);
?>
    <!-- content -->
    <div class="container pt-5">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6">
                <div class="d-flex justify-content-between mb-3">
                    <h4>Edit SPBU</h4>
                    <a href="<?= BaseUrl('admin/spbu/index'); ?>" class="btn btn-primary">Kembali</a>
                </div>
                <?= Flash(); ?>
                <form action="<?= BaseUrl('admin/spbu/update'); ?>" method="post">
                    <?= Csrf(); ?>
                    <div class="mb-3">
                        <label for="nomor" class="form-label">Nomor SPBU</label>
                        <input type="text" name="nomor" id="nomor" class="form-control" value="<?= $row['nomor']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama SPBU</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= $row['nama']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" cols="10" rows="5"><?= htmlspecialchars(trim($row['alamat'])); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Titik Lokasi</label>
                        <div id="map" style="width: 100%; height: 300px;"></div>
                        <input type="hidden" name="longtitude" id="longtitude" value="<?= $row['longtitude']; ?>">
                        <input type="hidden" name="langtitude" id="langtitude" value="<?= $row['langtitude']; ?>">
                    </div>
                    <div class="text-end my-4">
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
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    const map = L.map('map').setView([<?= $row['longtitude'] ?>, <?= $row['langtitude'] ?>], 13);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    const marker = L.marker([<?= $row['longtitude'] ?>, <?= $row['langtitude'] ?>]).bindPopup(`Lokasi SPBU`).openPopup().addTo(map)

    const popup = L.popup()

    function onMapClick(e) {
        marker
            .setLatLng(e.latlng)
            .bindPopup(`Lokasi Baru SPBU`)
            .openPopup();
        let mapValue = e.latlng;
        document.getElementById('longtitude').value = mapValue.lat.toString();
        document.getElementById('langtitude').value = mapValue.lng.toString();
    }

    map.on('click', onMapClick);
</script>
</body>

</html>
