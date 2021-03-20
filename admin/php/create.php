<?php
include_once './authorisation.php';
include_once "./functions.php";
$dir = $_GET['dir'] ?? false;
$newFile = $_POST['newFile'] ?? false;
$type = $_GET['type'] ?? false;
$extension = $_POST['extension'] ?? false;
$formats = 'js|html|txt|css';
if ($newFile !== false && $type !== false && $dir !== false) {
        if ($type == 'dir' && preg_match('/^[-a-zA-ZА-Яа-яЁё0-9_]+$/ui', $newFile)) {
            $newFile = $dir . '\\' . $newFile;
            $newFile = translit($newFile);
            while (file_exists($newFile)) {
                $newFile .= '_copy';
            }
            mkdir($newFile);
        } elseif ($type == 'file' && $extension !== false) {
            $newFile = $newFile . '.' . $extension;
            if (preg_match('/^[-a-zA-ZА-Яа-яЁё0-9_]+(\.(' . $formats . '))$/ui', $newFile)) {
                $newFile = $dir . '\\' . $newFile;
                $newFile = translit($newFile);
                while (file_exists($newFile)) {
                    $index = strripos($newFile, '.');
                    if ($index !== false) {
                        $newFile = substr($newFile, 0, $index) . '_copy' . substr($newFile, $index);
                    } else {
                        $newFile .= '_copy';
                    }
                }
                $fb = fopen($newFile, "w");
                fclose($fb);
            }
        }
}
if ($dir !== false) {
   header("location: /admin/?dir=$dir");
} else {
   header("location: /admin/");
}