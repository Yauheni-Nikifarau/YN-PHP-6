<?php

$checkUrl = preg_match('/\/explorer\.php$/', $_SERVER['PHP_SELF']);
if ($checkUrl == 1) :
    header('location: /admin/index.php');
else:
    $dir = $_GET['dir'] ?? '.\\';
    $dir = realpath($dir);
    $rootDir = $_SERVER['CONTEXT_DOCUMENT_ROOT'];
    $rootDir = realpath($rootDir);
    $dir = str_starts_with($dir, $rootDir) ? $dir : $rootDir;
    chdir($dir);
    $curDir = getcwd();
    $arHere = scandir($curDir);
?>


<!DOCTYPE html>
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
<div class="site">
    <ul>
        <?php foreach ($arHere as $index => $path) :
            if ($index == 0) continue;
            if (is_dir($dir . '\\' . $path)) :
        ?>

        <li>
            <?php if($path == '..'):?>

            <a href="/admin/?dir=<?= realpath($dir . '/..'); ?>">Назад</a>

            <?php else: ?>

            <a href="/admin/?dir=<?= $dir . '\\'.$path; ?>"><?= $path; ?></a>
            <a href="/admin/delete.php?dir=<?= $dir; ?>&remove=<?= $path;?>&type=dir" class="button del">Удалить</a>
            <a href="/admin/rename.php?dir=<?= $dir; ?>&rename=<?= $path;?>" class="button rename">Переименовать</a>

            <?php endif; ?>
        </li>

        <?php else: ?>

        <li>
            <?= $path; ?>
            <a href="/admin/delete.php?dir=<?= $dir; ?>&remove=<?= $path;?>&type=file" class="button del">Удалить</a>
            <a href="/admin/rename.php?dir=<?= $dir; ?>&rename=<?= $path;?>" class="button rename">Переименовать</a>
            <?php $path = $dir . '\\'.$path;
            $pathinfo = pathinfo($path);
            $extension = $pathinfo['extension'] ?? 'none';
            if (preg_match('/txt|css|html|js/ui', $extension)) :?>
            <a href="/admin/edit.php?dir=<?= $dir; ?>&file=<?= $path; ?>"  class="button edit">Редактировать</a>
            <?php endif; ?>
        </li>

            <?php endif; ?>
        <?php endforeach; ?>

        <li><a href="/admin/">Вернуться в исходное положение</a></li>
    </ul>

    <div class="forms">
        <form action="/admin/create.php?dir=<?= $dir; ?>&type=dir" method="post">
            <label>Имя новой директории<input type="text" name="newFile" placeholder="Имя новой директории"></label>
            <button>CREATE DIRECTORY</button>
        </form>

        <form action="/admin/create.php?dir=<?= $dir; ?>&type=file" method="post">
            <label>Имя нового файла<input type="text" name="newFile" placeholder="Имя нового файла"></label>
            <label>Расширение:
                <select name="extension">
                    <option value="txt" selected>txt</option>
                    <option value="html">html</option>
                    <option value="css">css</option>
                    <option value="js">js</option>
                </select>
            </label>
            <button>CREATE FILE</button>
        </form>

        <form enctype="multipart/form-data" action="/admin/upload.php?dir=<?= $dir; ?>" method="POST">
            <label>Загрузить файл <input type="file" name="file[]" multiple></label>
            <button>UPLOAD</button>
        </form>
    </div>
</div>



</body>
</html>

<?php endif; ?>

