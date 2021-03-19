<?php
function translit($name) {
    $name = trim($name);
    $name = mb_strtolower($name);
    $name = strtr($name, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>'', ' '=>'_'));
    return $name;
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
