<?php
// membuat struktur tabel spbu dari file .sql
$query = file_get_contents('database/spbu.sql');
$result = mysqli_multi_query($koneksi, $query);
while (mysqli_next_result($koneksi));

if (!$result) {
    die("eksekusi sql gagal " . mysqli_errno($koneksi));
}

$akun = mysqli_query($koneksi, "SELECT * FROM akun");

if (mysqli_num_rows($akun) <= 0) {
    $username = "rhbekti";
    $id = time() . uniqid() . sha1($username);
    $password = password_hash("12345", PASSWORD_BCRYPT);

    $query = "INSERT INTO akun VALUES ('$id','$username','$password',1)";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "gagal membuat akun";
        die;
    }
}
