<?php
include_once './authorisation.php';
include_once "./functions.php";
define('UPLOADS' , "{$_SERVER['CONTEXT_DOCUMENT_ROOT']}\\admin\\uploads");
if (!file_exists(UPLOADS)) {
    mkdir(UPLOADS);
}
$dir = $_GET['dir'] ?? false;
$tmp = $_FILES['file']['tmp_name'] ?? false;
$name = $_FILES['file']['name'] ?? false;
if ($tmp !== false && $name !== false) {
    foreach ($name as $key => $value) {
        $fname = translit($value);
        $file = UPLOADS . '\\' . $fname;
        while (file_exists($file)) {
            $index = strripos($file, '.');
            if ($index !== false) {
                $file = substr($file, 0, $index) . '_copy' . substr($file, $index);
            } else {
                $file .= '_copy';
            }
        }
        move_uploaded_file($tmp[$key] , $file);
    }
}
if ($dir !== false) {
    header("location: /admin/?dir=$dir");
} else {
    header("location: /admin/");
}

