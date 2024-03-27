<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst($_SESSION['u_rl']) ?> | <?= $_SESSION['u_rl'] == 'anggota' ? 'Peminjaman' : ucfirst($_GET['page']) ?></title>
    <link rel="stylesheet" href="<?= BASEURL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/css/admin.css">
    <?php if ($_SESSION['u_rl'] == 'admin'||$_SESSION['u_rl'] == 'pustakawan') : ?>
        <?= $_GET['page'] == 'anggota'||$_GET['page'] == 'admin' ? "<link rel='stylesheet' href='".BASEURL."/css/anggota.css'>" :'' ?>
        <?= $_GET['page'] == 'peminjaman' ? "<link rel='stylesheet' href='".BASEURL."/css/peminjaman.css'>" :'' ?>
        <?= $_GET['page'] == 'laporan' ? "<link rel='stylesheet' href='".BASEURL."/css/laporan.css'>" :'' ?>
        <?= $_GET['page'] == 'buku' ? "<link rel='stylesheet' href='".BASEURL."/css/buku.css'>" :'' ?>
    <?php elseif ($_SESSION['u_rl'] == 'anggota') : ?>
        <link rel="stylesheet" href="<?= BASEURL ?>/css/peminjaman.css">
    <?php endif; ?>
</head>
<body>
    <?= Flasher::flash() ?>
    <nav>
        <h2>Perpustakaan</h2>
        <a href="<?= BASE_PAGE_URL ?>/auth/logout.php" id="logout">
            Logout
        </a>
    </nav>
    <div class="profile">
        <h1>Welcome, <?= $_SESSION['u_name'] ?></h1>
        <p><?= ucfirst($_SESSION['u_rl']) ?></p>
    </div>