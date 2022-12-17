<?php
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";

IsLogin();
$inputs = ['nomor', 'nama', 'alamat', 'longtitude', 'langtitude'];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'POST') {
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
                    header("Location:" . BaseUrl('admin/spbu/create'));
                    exit;
                } else {
                    $data += [$key => htmlspecialchars($value)];
                }
            }
        }

        $sql = "INSERT INTO spbu(" . implode(',', $inputs) . ") VALUES ('" . implode("' ,'", $data) . "')";
        $result = mysqli_query($koneksi, $sql);

        if (!$result) {
            SetFlash('Data gagal disimpan' . mysqli_error($koneksi), 'danger');
            header("Location:" . BaseUrl('admin/spbu/create'));
            exit;
        }

        SetFlash('Data berhasil disimpan', 'success');
        header("Location:" . BaseUrl('admin/spbu/index'));
    }
} else {
    echo "Invalid Request";
}
