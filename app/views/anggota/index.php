<?php
require_once('../../init.php');

$peminjamans = Peminjaman::getByUserId($_SESSION['u_id']);
$overdues = count(Peminjaman::getOverdueBooks($_SESSION['u_id']));

?>


<?php require_once('../templates/header.php') ?>
<div class="container">
    <header>
        <ul>
            <li><a href="index.php" class="active">Peminjaman</a></li>
        </ul>
    </header>
    <?php require_once('peminjaman.php') ?>
</div>
<?php require_once('../templates/footer.php') ?>