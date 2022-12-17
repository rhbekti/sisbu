<?php
require __DIR__ . "/../config/config.php";
require __DIR__ . "/../library/session.php";
require __DIR__ . "/../library/middleware.php";

$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === "POST") :
    $token = htmlspecialchars($_POST['token']);
    if (!$token || $token != $_SESSION['token']) :
        echo "<p>Error: invalid form submission</p>";
        echo "<script>window.location.href(" . $_SERVER['SERVER_PROTOCOL'] . " 405 Method Not Allowed</script>";
        exit;
    else :
        unset($_SESSION['account']);
        session_destroy();
        header("Location:" . BaseUrl('index'));
    endif;
endif;
