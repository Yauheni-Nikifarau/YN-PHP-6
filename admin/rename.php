<?php
$fileToRename = $_GET['rename'] ?? false;
$newName = $_POST['newName'] ?? false;
$dir = $_GET['dir'] ?? false;
if ($fileToRename !== false && $dir !== false) {

    $fileToRename = $dir . '\\'.$fileToRename;
    $extension = pathinfo($fileToRename)['extension'];
    if ($newName !== false) :

        if (preg_match('/^[-a-zA-Z0-9_]+$/ui',$_POST['newName'])) :
            rename($fileToRename, $dir . '\\' . "{$_POST['newName']}.$extension");
        endif;
        header("location: /admin/?dir={$dir}");

    else : ?>
        <form action="/admin/rename.php?dir=<?= $dir; ?>&rename=<?= $_GET['rename']; ?>" method="POST">
            <label>Новое имя<input type="text" name="newName" placeholder="new name"></label>
            <button>OK</button>
        </form>

    <?php endif;
} elseif ($dir !== false) {
    header("location: /admin/?dir=$dir");
} else {
    header("location: /admin/");
}