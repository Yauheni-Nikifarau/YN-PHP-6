<?php
function prent ($arr) {
    echo '<pre>';
    var_dump($arr);
    echo '</pre>';
}
$checkUrl = preg_match('/\/explorer\.php$/',$_SERVER['PHP_SELF']);
if ($checkUrl == 1) {
    header('location: /admin/index.php');
}

$dir = $_GET['dir'] ?? realpath('.\\');
chdir($dir);
$curDir = getcwd();
$arHere = scandir($curDir);



if ($fileToRename = $_GET['rename'] ?? false) {
    $fileToRename = $dir . '\\'.$fileToRename;
    if ($newName = $_POST['newName'] ?? false) :
        if (preg_match('/^[-a-zA-Zа-яА-ЯёЁ0-9 _]+\.?[-a-zA-Zа-яА-ЯёЁ0-9 _]+$/ui',$_POST['newName'])) {
            rename($fileToRename, $dir . '\\' . $_POST['newName']);
        }
        header("location: /admin/?dir={$dir}");
    else : ?>
        <form action="/admin/?dir=<?= $dir; ?>&rename=<?= $_GET['rename']; ?>" method="POST">
            <input type="text" name="newName" placeholder="new name">
            <button>OK</button>
        </form>
    <?php endif;
} else {

if (($fileToRemove = $_GET['remove'] ?? false) && ($type = $_GET['type'] ?? false)) {
    $fileToRemove = $dir . '\\'.$fileToRemove;
    if (file_exists($fileToRemove)) {
        if ($type == 'file') {
            unlink($fileToRemove);
        } elseif ($type == 'dir') {
            rmdir($fileToRemove);
        }
    }
}

if (($newFile = $_POST['newFile'] ?? false) && ($type = $_POST['type'] ?? false)) {
    if (preg_match('/^[-a-zA-Zа-яА-ЯёЁ0-9 _]+\.?[-a-zA-Zа-яА-ЯёЁ0-9 _]+$/ui',$newFile)) {
        $newFile = $dir . '\\' . $newFile;
        if ($type == 'dir') {
            mkdir($newFile);
            header("location: /admin/?dir={$dir}");
        } elseif ($type == 'file') {
            $fb = fopen($newFile, "w");
            fclose($fb);
            header("location: /admin/?dir={$dir}");
        }
    }
}





?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<ul>
<?php foreach ($arHere as $index => $path) {
        if ($index == 0) continue;
        if (is_dir($dir . '\\' . $path)) : ?>

            <li>
                <a href="/admin/?dir=<?= $dir . '\\'.$path; ?>"><?= $path; ?></a>
                <?php if ($path != '..') :?>
                <a href="/admin/?dir=<?= $dir; ?>&remove=<?= $path;?>&type=dir">Удалить</a>
                <a href="/admin/?dir=<?= $dir; ?>&rename=<?= $path;?>">Переименовать</a>
                <?php endif; ?>
            </li>

        <?php else: ?>

            <li>
                <?= $path; ?>
                <a href="/admin/?dir=<?= $dir; ?>&remove=<?= $path;?>&type=file">Удалить</a>
                <a href="/admin/?dir=<?= $dir; ?>&rename=<?= $path;?>">Переименовать</a>
            </li>

        <?php endif;
}?>
            <li><a href="/admin/">Вернуться в исходное положение</a></li>
    </ul>


<?php } ?>

<form action="/admin/?dir=<?= $dir; ?>" method="post">
    <input type="text" name="newFile"placeholder="Имя нового файла">
    <input type="radio" name="type" value="file">Файл
    <input type="radio" name="type" value="dir">Директория
    <button>CREATE</button>
</form>


</body>
</html>




