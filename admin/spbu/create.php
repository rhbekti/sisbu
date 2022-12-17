<?php
$judul = "Tambah SPBU";
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
        <div class="col-lg-8">
            <div class="d-flex justify-content-between mb-3">
                <h4>Tambah SPBU</h4>
                <a href="<?= BaseUrl('admin/spbu/index'); ?>" class="btn btn-primary">Kembali</a>
            </div>
            <?= Flash(); ?>
            <form action="<?= BaseUrl('admin/spbu/store'); ?>" method="post">
                <?= Csrf(); ?>
                <div class="mb-3">
                    <label for="nomor" class="form-label">Nomor SPBU</label>
                    <input type="text" name="nomor" id="nomor" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama SPBU</label>
                    <input type="text" name="nama" id="nama" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" cols="10" rows="5"></textarea>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Titik Lokasi</label>
                    <div id="map" style="width: 100%; height: 300px;"></div>
                    <input type="hidden" name="longtitude" id="longtitude">
                    <input type="hidden" name="langtitude" id="langtitude">
                </div>
                <div class="text-end my-3">
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
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    const map = L.map('map').setView([-7.808208, 110.416342], 13);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    const marker = L.marker([-7.808208, 110.416342]).addTo(map)

    const popup = L.popup()

    function onMapClick(e) {
        marker
            .setLatLng(e.latlng)
            .bindPopup(`Lokasi Baru SPBU`)
            .openPopup();
        let mapValue = e.latlng;
        document.getElementById('langtitude').value = mapValue.lng.toString();
        document.getElementById('longtitude').value = mapValue.lat.toString();
    }

    map.on('click', onMapClick);
</script>
</body>

</html>
