<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = [];
session_destroy();

session_start();
$_SESSION['flash'] = [
    'type'  => 'success',
    'pesan' => 'Kamu sudah logout.',
];

header('Location: ../index.php');
exit;
