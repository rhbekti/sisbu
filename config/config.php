<?php

/**
 * konfigurasi zona waktu
 */
date_default_timezone_set("Asia/Jakarta");
/**
 * konfigurasi server database
 */
define('BASE_URL', 'http://localhost/sisbu/');
define('SERVER', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', 'root');
define('DBNAME', 'spbu');

$koneksi = mysqli_connect(SERVER, USERNAME, PASSWORD) or die("koneksi error" . mysqli_connect_errno());
$pilih_db = mysqli_select_db($koneksi, DBNAME);

if (!$pilih_db) {
    $pilih_db = mysqli_query($koneksi, "CREATE DATABASE IF NOT EXISTS " . DBNAME);
    if ($pilih_db) {
        $pilih_db = mysqli_select_db($koneksi, DBNAME);
    } else {
        die("Gagal membuat database" . mysqli_error($koneksi));
    }
}
