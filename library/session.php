<?php
if (!session_id()) session_start();
/**
 * membuat token csrf
 *
 * @return String
 **/
function Csrf()
{
    if (isset($_SESSION['token'])) {
        $_SESSION['token'] = $_SESSION['token'];
    } else {
        CreateToken();
    }
    echo "<input type='hidden' name='token' value='" . $_SESSION['token'] . "'>";
}

/**
 * membuat token
 *
 * @return String
 **/
function CreateToken()
{
    $_SESSION['token'] = bin2hex(random_bytes(35));
}

/**
 * membuat session flash message
 *
 * @return Session
 **/
function SetFlash($message, $type)
{
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}
/**
 * menampilkan session flash message
 *
 * @return String
 **/
function Flash()
{
    if (isset($_SESSION['flash'])) {
        echo '<div class="alert alert-' . $_SESSION["flash"]["type"] . '" role="alert">' . $_SESSION["flash"]["message"] . '</div>';
        unset($_SESSION['flash']);
    }
}
