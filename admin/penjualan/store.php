<?php
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";

IsLogin();

$inputs = [];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method == 'GET') {
    header("Location:" . BaseUrl('admin/penjualan/create'));
} elseif ($request_method == 'POST') {
    $token = htmlspecialchars($_POST['token']);
    if (!$token || $token !== $_SESSION['token']) {
        echo "<p>Error: invalid form submission</p>";
        echo "<script>window.location.href(" . $_SERVER['SERVER_PROTOCOL'] . " 405 Method Not Allowed</script>";
        exit;
    } else {
        $data = [];

        foreach ($_POST as $key => $value) {
            if (strlen(trim($value)) === 0) {
                SetFlash($key . ' harus diisi', 'warning');
                header("Location:" . BaseUrl('admin/penjualan/create'));
                exit;
            } else {
                $data += [$key => htmlspecialchars($value)];
            }
        }

        if (!is_numeric($data['sawal'])) {
            SetFlash('stok awal harus diisi angka', 'warning');
            header("Location:" . BaseUrl('admin/penjualan/create'));
            exit;
        }
        if (!is_numeric($data['sakhir'])) {
            SetFlash('stok akhir harus diisi angka', 'warning');
            header("Location:" . BaseUrl('admin/penjualan/create'));
            exit;
        }
        if (!is_numeric($data['tawal'])) {
            SetFlash('totalisator awal harus diisi angka', 'warning');
            header("Location:" . BaseUrl('admin/penjualan/create'));
            exit;
        }
        if (!is_numeric($data['takhir'])) {
            SetFlash('totalisator awal harus diisi angka', 'warning');
            header("Location:" . BaseUrl('admin/penjualan/create'));
            exit;
        }


        $store = true;
        $start_transaction = mysqli_begin_transaction($koneksi);

        // get price product
        $query = mysqli_query($koneksi, "SELECT harga FROM produk WHERE id='" . $data['produk'] . "' LIMIT 1");
        if (!$query) {
            SetFlash('Data harga gagal ditemukan', 'warning');
            $store = false;
        }

        $result = mysqli_fetch_assoc($query);

        $price = $result['harga'];
        // data insert to table penjualan
        $sales = $data['takhir'] - $data['tawal'];
        $income = $sales * $price;

        $dtpenjualan = ['tanggal' => date('y-m-d', strtotime($data['tanggal'])), 'id_spbu' => $data['spbu'], 'total_penjualan' => $sales, 'total_pendapatan' => $income, 'id_pengguna' => $_SESSION['account']['id_user']];

        $query = "INSERT INTO penjualan(" . implode(', ', array_keys($dtpenjualan)) . ") VALUES ('" . implode("', '", $dtpenjualan) . "')";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            SetFlash('Data penjualan gagal ditambahkan', 'danger');
            $store = false;
        }

        $idtbpenjualan = mysqli_insert_id($koneksi);

        if ($idtbpenjualan == 0) {
            SetFlash('Data penjualan gagal ditemukan', 'danger');
            $store = false;
        }

        // data insert to table pompa
        $dtpompa = ['id_penjualan' => $idtbpenjualan, 't_awal' => $data['tawal'], 't_akhir' => $data['takhir'], 'id_produk' => $data['produk'], 'harga' => $price];
        $query = "INSERT INTO pompa(" . implode(', ', array_keys($dtpompa)) . ") VALUES ('" . implode("', '", $dtpompa) . "')";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            SetFlash('Data pompa gagal ditambahkan', 'danger');
            $store = false;
        }

        // data insert to table tangki
        $dttangki = ['id_penjualan' => $idtbpenjualan, 'stok_awal' => $data['sawal'], 'stok_akhir' => $data['sakhir']];
        $query = "INSERT INTO tangki(" . implode(', ', array_keys($dttangki)) . ") VALUES ('" . implode("', '", $dttangki) . "')";

        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            SetFlash('Data tangki gagal ditambahkan', 'danger');
            $store = false;
        }

        if ($store) {
            mysqli_commit($koneksi);
        } else {
            mysqli_rollback($koneksi);
            // SetFlash('Proses Transaksi Gagal', 'warning');
            header("Location:" . BaseUrl('admin/penjualan/create'));
            exit;
        }

        SetFlash('Proses Transaksi Berhasil', 'success');
        header("Location:" . BaseUrl('admin/penjualan/index'));
    }
}
