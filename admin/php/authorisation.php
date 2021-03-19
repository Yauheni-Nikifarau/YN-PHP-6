<?php
$auth = $_COOKIE['authorization'] ?? false;
if ($_COOKIE['authorization'] != 'admin') {
    header('location: /admin/php/login.php');
    die();
}
