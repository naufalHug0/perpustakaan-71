<?php
require_once('../../init.php');

if (!isset($_GET['page'])) {
    $_GET['page'] = 'peminjaman';
}
?>

<?php require_once('../templates/header.php') ?>
<div class="container">
    <header>
        <ul>
            <li><a href="index.php" class="<?= $_GET['page'] == 'peminjaman'? 'active':'' ?>">Peminjaman</a></li>
            <li><a href="?page=laporan" class="<?= $_GET['page'] == 'laporan'? 'active':'' ?>">Laporan</a></li>
        </ul>
    </header>
    <?php require_once("../admin/".$_GET['page'].".php") ?>
</div>
<?php require_once('../templates/footer.php') ?>