<?php
$fileToRename = $_GET['rename'] ?? false;
$newName = $_POST['newName'] ?? false;
$dir = $_GET['dir'] ?? false;
$formats = 'php|html|txt|css';
if ($fileToRename !== false && $dir !== false) {

    $fileToRename = $dir . '\\'.$fileToRename;

    if ($newName !== false) :

        if (preg_match('/^[-a-zA-Z0-9_]+(\.('.$formats.'))?$/ui',$_POST['newName'])) {
            rename($fileToRename, $dir . '\\' . $_POST['newName']);
        }
        header("location: /admin/?dir={$dir}");

    else : ?>

        <form action="/admin/rename.php?dir=<?= $dir; ?>&rename=<?= $_GET['rename']; ?>" method="POST">
            <label>Новое имя<input type="text" name="newName" placeholder="new name"></label>
            <button>OK</button>
        </form>

    <?php endif;
echo '<pre>';
print_r($_SERVER);
echo '</pre>';
} elseif ($dir !== false) {
    header("location: /admin/?dir=$dir");
} else {
    header("location: /admin/");
}