<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];
session_regenerate_id(true);
$_SESSION['mode'] = 'guest';
header('Location: ../produk/list.php');
exit;
