<?php
require __DIR__ . "/../config/config.php";
require __DIR__ . "/../library/session.php";
require __DIR__ . "/../library/middleware.php";

HasLogin();

$inputs = [];
$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if ($request_method === 'GET') :
    $judul = "Login";
elseif ($request_method === 'POST') :
    $inputs['username'] = htmlspecialchars($_POST['username']);
    $inputs['password'] = htmlspecialchars($_POST['password']);
    $token = htmlspecialchars($_POST['token']);

    if (!$token || $token !== $_SESSION['token']) :
        echo "<p>Error: invalid form submission</p>";
        echo "<script>window.location.href(" . $_SERVER['SERVER_PROTOCOL'] . " 405 Method Not Allowed</script>";
        exit;
    else :
        foreach ($inputs as $key => $value) :
            if ($value === "") :
                SetFlash($key . ' harus di isi', 'danger');
                header('Location:' . $_SERVER['PHP_SELF']);
                exit;
            else :
                $query = "SELECT * FROM akun WHERE username = '" . $inputs['username'] . "' LIMIT 1";
                $result = mysqli_query($koneksi, $query);
                if (mysqli_num_rows($result) > 0) :
                    $account = mysqli_fetch_assoc($result);
                    if (password_verify($inputs['password'], $account['password'])) :
                        $_SESSION['account'] = [
                            'is_login' => true,
                            'id_user' => $account['id'],
                            'username' => $account['username'],
                            'level' => $account['level']
                        ];
                        echo "<script>alert('oke')</script>";
                        header('Location:' . BaseUrl('index'));
                        exit;
                    endif;
                endif;
                SetFlash('Info yang dimasukkan tidak sesuai', 'danger');
                header('Location:' . $_SERVER['PHP_SELF']);
                exit;
            endif;
        endforeach;
    endif;
endif;
require __DIR__ . "/../template/header.php";
?>
<!-- content -->
<div class="container">
    <div class="row vh-100 align-items-center justify-content-center">
        <div class="col-lg-6">
            <div class="text-center mb-3">
                <img src="../assets/images/logo.png" alt="logo" class="img-fluid" width="350" height="300">
                <h4>Sistem Informasi SPBU</h4>
                <?= Flash(); ?>
            </div>
            <div class="card border-0 shadow p-3">
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                    <?= Csrf(); ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end content -->
<?php
require __DIR__ . "/../template/footer.php";
?>
</body>

</html>
