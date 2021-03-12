<?php
function removeDir ($path) {
    $dd = opendir($path);
    while (($item = readdir($dd)) !== false) {
        if($item == '.' || $item == '..') {
            continue;
        }

        $item = $path . '\\' . $item;

        if (is_dir($item)) {
            removeDir($item);
        } else {
            unlink($item);
        }
    }
    rmdir($path);

}


$checkUrl = preg_match('/\/explorer\.php$/',$_SERVER['PHP_SELF']);
if ($checkUrl == 1) {
    header('location: /admin/index.php');
}

$dir = $_GET['dir'] ?? '.\\';
$dir = realpath($dir);
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
            <label>Новое имя<input type="text" name="newName" placeholder="new name"></label>
            <button>OK</button>
        </form>
    <?php endif;
} else {

if (($fileToRemove = $_GET['remove'] ?? false) && ($type = $_GET['type'] ?? false)) {
    $fileToRemove = $dir . '\\'.$fileToRemove;
    if (file_exists($fileToRemove)) {
        if ($type == 'file') {
            unlink($fileToRemove);
            header("location: $dir");
        } elseif ($type == 'dir') {
            removeDir($fileToRemove);
            header("location: $dir");
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
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<ul>
<?php foreach ($arHere as $index => $path) {
        if ($index == 0) continue;
        if (is_dir($dir . '\\' . $path)) : ?>

            <li>
                <a href="/admin/?dir=<?= $dir . '\\'.$path; ?>"><?= ($path == '..') ? 'Назад' : $path; ?></a>
                <?php if ($path != '..') :?>
                <a href="/admin/?dir=<?= $dir; ?>&remove=<?= $path;?>&type=dir" class="button">Удалить</a>
                <a href="/admin/?dir=<?= $dir; ?>&rename=<?= $path;?>" class="button">Переименовать</a>
                <?php endif; ?>
            </li>

        <?php else: ?>

            <li>
                <?= $path; ?>
                <a href="/admin/?dir=<?= $dir; ?>&remove=<?= $path;?>&type=file" class="button">Удалить</a>
                <a href="/admin/?dir=<?= $dir; ?>&rename=<?= $path;?>" class="button">Переименовать</a>
            </li>

        <?php endif;
}?>
            <li><a href="/admin/">Вернуться в исходное положение</a></li>
    </ul>

<form action="/admin/?dir=<?= $dir; ?>" method="post">
    <label>Имя нового создаваемого элемента<input type="text" name="newFile" placeholder="Имя нового файла"></label>
    <label>Файл<input type="radio" name="type" value="file"></label>
    <label>Директория<input type="radio" name="type" value="dir"></label>
    <button>CREATE</button>
</form>

<?php } ?>

</body>
</html>




