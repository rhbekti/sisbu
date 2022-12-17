<?php
if (!session_id()) session_start();
/**
 * membuat url utama
 *
 *
 * @param Type $url = String
 * @return String
 **/
function BaseUrl($url = null)
{
    if ($url !== null) {
        return htmlspecialchars(BASE_URL . $url . '.php');
    }
    return BASE_URL;
}

/**
 * mengecek sesi login pengguna
 *
 * @return Boolean
 **/
function IsLogin()
{
    if (!$_SESSION['account']['is_login']) {
        header("Location:" . BaseUrl('auth/login'));
    }
}

function HasLogin()
{
    if (isset($_SESSION['account']['is_login'])) {
        echo "<script>
        setInterval( () => {
            self.history.back()
         }, 100);
        </script>";
    }
}
