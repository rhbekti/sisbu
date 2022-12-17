<?php
// konfigurasi server
require __DIR__ . "/config/config.php";
// konfigurasi keamanan
require __DIR__ . "/library/middleware.php";
// konfigurasi database
require __DIR__ . "/database/database.php";

IsLogin();
header('Location:' . BaseUrl('admin/spbu/index'));
