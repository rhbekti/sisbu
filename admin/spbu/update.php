<?php
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";

$inputs = ['nomor', 'nama', 'alamat', 'longtitude', 'langtitude'];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'GET') {
    header("Location:" . BaseUrl('admin/spbu/index'));
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
                    header("Location:" . BaseUrl('admin/spbu/index'));
                    exit;
                } else {
                    $data[] = $key . "='" . htmlspecialchars($value) . "'";
                }
            }
        }
        $query = "UPDATE spbu SET " . implode(', ', $data) . " WHERE id='" . $_SESSION['id_spbu'] . "'";

        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            SetFlash('Data gagal diperbarui', 'danger');
            header("Location:" . BaseUrl('admin/spbu/index'));
            exit;
        }

        unset($_SESSION['id_spbu']);
        SetFlash('Data berhasil diperbarui', 'success');
        header("Location:" . BaseUrl('admin/spbu/index'));
    }
}
