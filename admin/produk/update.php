<?php
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";

$inputs = ['kode', 'nama', 'harga'];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'GET') {
    header("Location:" . BaseUrl('admin/produk/index'));
} elseif ($request_method === 'POST') {
    $token = htmlspecialchars($_POST['token']);

    if (!$token || $token !== $_SESSION['token']) {
        echo "<p>Error: invalid form submission</p>";
        echo "<script>window.location.href(" . $_SERVER['SERVER_PROTOCOL'] . " 405 Method Not Allowed</script>";
        exit;
    } else {
        $data = [];

        if (!filter_var($_POST['harga'], FILTER_VALIDATE_INT)) {
            SetFlash('harga harus diisi bilangan bulat', 'warning');
            header("Location:" . BaseUrl('admin/produk/index'));
            exit;
        }

        foreach ($_POST as $key => $value) {
            if (in_array($key, $inputs)) {
                if (strlen(trim($value)) === 0) {
                    SetFlash($key . ' harus diisi', 'warning');
                    header("Location:" . BaseUrl('admin/produk/index'));
                    exit;
                } else {
                    $data[] = $key . "='" . htmlspecialchars($value) . "'";
                }
            }
        }

        $query = "UPDATE produk SET " . implode(', ', $data) . " WHERE id='" . $_SESSION['id_produk'] . "'";

        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            SetFlash('Data gagal diperbarui', 'danger');
            header("Location:" . BaseUrl('admin/produk/index'));
            exit;
        }

        unset($_SESSION['id_produk']);
        SetFlash('Data berhasil diperbarui', 'success');
        header("Location:" . BaseUrl('admin/produk/index'));
    }
}
