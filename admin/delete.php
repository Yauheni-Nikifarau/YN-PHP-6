<?php
$fileToRemove = $_GET['remove'] ?? false;
$type = $_GET['type'] ?? false;
$dir = $_GET['dir'] ?? false;
if ($fileToRemove !== false && $type !== false && $dir !== false) {
    $fileToRemove = $dir . '\\'.$fileToRemove;
    if (file_exists($fileToRemove)) {
        if ($type == 'file') {
            unlink($fileToRemove);
            header("location: /admin/?dir=$dir");
        } elseif ($type == 'dir') {
            removeDir($fileToRemove);
            header("location: /admin/?dir=$dir");
        }
    }
} elseif ($dir !== false) {
    header("location: /admin/?dir=$dir");
} else {
    header("location: /admin/");
}

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