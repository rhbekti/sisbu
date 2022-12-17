<?php
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";

IsLogin();

$inputs = ['kode', 'nama', 'harga'];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'GET') {
    header("Location:" . BaseUrl('admin/produk/create'));
} elseif ($request_method === 'POST') {
    $token = htmlspecialchars($_POST['token']);

    if (!$token || $token !== $_SESSION['token']) {
        echo "<p>Error: invalid form submission</p>";
        echo "<script>window.location.href(" . $_SERVER['SERVER_PROTOCOL'] . " 405 Method Not Allowed</script>";
        exit;
    } else {
        $data = [];
        foreach ($_POST as $key => $value) {
            if (in_array($key, $inputs)) {
                if (strlen(trim($value)) === 0) {
                    SetFlash($key . ' harus diisi', 'warning');
                    header("Location:" . BaseUrl('admin/produk/create'));
                    exit;
                } else {
                    $data += [$key => htmlspecialchars($value)];
                }
            }
        }

        if (!filter_var($data['harga'], FILTER_VALIDATE_INT)) {
            SetFlash('harga harus diisi bilangan bulat', 'warning');
            header("Location:" . BaseUrl('admin/produk/create'));
            exit;
        }

        $query = "INSERT INTO produk(" . implode(",", $inputs) . ") VALUES ('" . implode("', '", $data) . "')";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            SetFlash('Data gagal disimpan', 'danger');
            header("Location:" . BaseUrl('admin/produk/create'));
            exit;
        }

        SetFlash('Data berhasil disimpan', 'success');
        header("Location:" . BaseUrl('admin/produk/index'));
    }
}
