<?php
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
    if ($dir !== false) {
        header("location: /admin/?dir=$dir");
    } else {
        header("location: /admin/");
    }
} elseif ($dir !== false) {
    header("location: /admin/?dir=$dir");
} else {
    header("location: /admin/");
}

function translit($name) {
    $name = trim($name);
    $name = mb_strtolower($name);
    $name = strtr($name, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>'', ' '=>'_'));
    return $name;
}