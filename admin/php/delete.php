<?php
include_once './authorisation.php';
include_once "./functions.php";
$fileToRemove = $_GET['remove'] ?? false;
$type = $_GET['type'] ?? false;
$dir = $_GET['dir'] ?? false;
if ($fileToRemove !== false && $type !== false && $dir !== false) {
    $fileToRemove = $dir . '\\'.$fileToRemove;
    if (file_exists($fileToRemove)) {
        if ($type == 'file') {
            unlink($fileToRemove);
        } elseif ($type == 'dir') {
            removeDir($fileToRemove);
        }
    }
}
if ($dir !== false) {
    header("location: /admin/?dir=$dir");
} else {
    header("location: /admin/");
}

