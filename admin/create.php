<?php
$dir = $_GET['dir'] ?? false;
$newFile = $_POST['newFile'] ?? false;
$type = $_GET['type'] ?? false;
$extension = $_POST['extension'] ?? false;
$formats = 'js|html|txt|css';
if ($newFile !== false && $type !== false && $dir !== false) {
        if ($type == 'dir') {
            if (preg_match('/^[-a-zA-Z0-9_]+$/ui', $newFile)) {
                $newFile = $dir . '\\' . $newFile;
                while (file_exists($newFile)) {
                    $newFile .= '_копия';
                }
                mkdir($newFile);
                header("location: /admin/?dir={$dir}");
            } else {
                header("location: /admin/?dir={$dir}");
            }
        } elseif ($type == 'file' && $extension !== false) {
            $newFile = $newFile . '.' . $extension;
            if (preg_match('/^[-a-zA-Z_]+(\.('. $formats .'))$/ui', $newFile)) {
                $newFile = $dir . '\\' . $newFile;
                while (file_exists($newFile)) {
                    $index = strripos($newFile, '.');
                    if ($index !== false) {
                        $newFile = substr($newFile, 0, $index) . '_копия' . substr($newFile, $index);
                    } else {
                        $newFile .= '_копия';
                    }
                }
                $fb = fopen($newFile, "w");
                fclose($fb);
                header("location: /admin/?dir={$dir}");
            } else {
                header("location: /admin/?dir={$dir}");
            }
        } else {
            header("location: /admin/?dir=$dir");
        }
} elseif ($dir !== false) {
    header("location: /admin/?dir=$dir");
} else {
    header("location: /admin/");
}