<?php 
require_once '../../init.php';

Auth::checkHasLoggedIn();

if (!isset($_GET['role'])) {
    Utils::navigateTo('../index.php');
}

if (isset($_POST['submit'])) {
    Auth::login($_POST, $_GET['role']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= ucfirst($_GET['role']) ?></title>
    <link rel="stylesheet" href="<?= BASEURL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/css/form.css">
</head>
<body>
    <?= Flasher::flash() ?>
    <form action="" method="post">
        <h2>Login <?= ucfirst($_GET['role']) ?></h2>
        <input type="text" name="username" placeholder="Username" autocomplete="none">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="submit">Masuk</button>
    </form>
<script src="<?= BASEURL ?>/js/index.js"></script>
<script src="<?= BASEURL ?>/js/utils.js"></script>
</body>
</html>