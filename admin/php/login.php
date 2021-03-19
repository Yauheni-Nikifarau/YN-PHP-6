<?php
$inputLogin = $_POST['login'] ?? false;
$inputPassword = $_POST['password'] ?? false;
if ($inputLogin !== false && $inputPassword !== false) :
    $data = parse_ini_file('../data/pas.ini')['data'];
    $data = unserialize($data)['admin'];
    $login = $data['login'];
    $password = $data['password'];
    $result = password_verify($inputPassword, $password) && ($login == md5($inputLogin));
    if ($result === true) :
        echo "Вы успешно авторизированы";
        setcookie("authorization", "admin", time()+(60*30), '/');
        header('refresh:5;url=/admin/');
    else :
        echo "Неверный логин или пароль";
        header('refresh:5;url=/admin/php/login.php');
    endif;
else:?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<form action="/admin/php/login.php" method="POST" class="login-form">
    <input type="text" name="login" placeholder="login">
    <input type="password" name="password" placeholder="password">
    <button>OK</button>
</form>

</body>
</html>
<?php endif; ?>
