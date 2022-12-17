<?php
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../library/session.php";
require __DIR__ . "/../../library/middleware.php";

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
        $query = "DELETE FROM produk WHERE id='" . $_POST['id'] . "'";

        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            SetFlash('Data gagal dihapus', 'danger');
            header("Location:" . BaseUrl('admin/produk/index'));
            exit;
        }

        SetFlash('Data berhasil dihapus', 'success');
        header("Location:" . BaseUrl('admin/produk/index'));
    }
}
