<?php 
require_once '../init.php';

Auth::checkHasLoggedIn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <link rel="stylesheet" href="<?= BASEURL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/css/landing.css">
</head>
<body>
    <div class="content">
        <h1>Selamat Datang di <span>Perpustakaan</span></h1>
        <p>Masuk untuk dapat meminjam buku.</p>
        <button id="login-btn">Login</button>
        <div class="dropdown">
            <a href="auth/login.php?role=admin">Sebagai <span>admin</span></a>
            <a href="auth/login.php?role=pustakawan">Sebagai <span>pustakawan</span></a>
            <a href="auth/login.php?role=anggota">Sebagai <span>anggota</span></a>
        </div>
    </div>
    <script src="<?= BASEURL ?>/js/utils.js"></script>
    <script src="<?= BASEURL ?>/js/landing.js"></script>
</body>
</html>