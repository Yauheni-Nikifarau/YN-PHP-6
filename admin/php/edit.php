<?php
include_once './authorisation.php';
$dir = $_GET['dir'] ?? false;
$file = $_GET['file'] ?? false;
$newContent = $_POST['newContent'] ?? false;

if ($dir !== false && $file !== false) {
    if ($newContent !== false) :
        file_put_contents($file, $newContent);
        header("location: /admin/?dir=$dir");
        die();
    else :
        $content = file_get_contents($file);
        $content = mb_convert_encoding($content, 'utf-8');
        $content = htmlentities($content);
        $extension = pathinfo($file);
        $extension = $extension['extension'];
        if ($extension == 'txt') {
            $extension = wordwrap($extension, 100, '<br>');
        }
        $size = filesize($file);
        $size /= 1000;
        $size = round($size);
        $creatingDate = filectime($file);
        $creatingDate = date ("d.m.y", $creatingDate);
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h2>Редактирование файла</h2>
    <p>Полный путь к файлу: <?= $file; ?>.</p>
    <p>Размер файла в Кб: <?= $size; ?>.</p>
    <p>Дата создания файла: <?= $creatingDate; ?>.</p>

    <form action="/admin/php/edit.php?dir=<?= $dir; ?>&file=<?= $file; ?>" method="POST" class="editForm">
        <textarea name="newContent"><?= $content; ?></textarea>
        <button>Подтвердить</button>
    </form>

</body>
</html>

    <?php endif;

} elseif ($dir !== false) {
    header("location: /admin/?dir=$dir");
} else {
    header("location: /admin/");
}
?>
