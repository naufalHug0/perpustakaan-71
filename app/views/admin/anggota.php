<?php 
$anggotas = Anggota::all();
?>
<div class="add-btn-wrapper">
<a id="add-btn" href="form.php?type=anggota&action=add">Tambah Anggota</a>
</div>
<div class="table">
    <div class="table-head">
        <p>No</p>
        <p>Nama</p>
        <p>Username</p>
        <p>Tempat Lahir</p>
        <p>Tanggal Lahir</p>
    </div>
    <?php $num = 1 ?>
    <?php foreach ($anggotas as $anggota) : ?>
        <div class="table-row">
            <p><?= $num ?></p>
            <p><?= $anggota['f_nama'] ?></p>
            <p><?= $anggota['f_username'] ?></p>
            <p><?= $anggota['f_tempatlahir'] ?></p>
            <p><?= $anggota['f_tanggallahir'] ?></p> 
            <div id="dot-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                </svg>
            </div>
            <div id="action-wrapper">
                <a href="form.php?action=edit&type=anggota&id=<?= $anggota['f_id'] ?>" class="action-item">Update</a>
                <p onclick="setDeleteItem(<?= $anggota['f_id'] ?>, 'anggota')" class="action-item">Delete</p>
            </div>
        </div>
        <?php $num++ ?>
    <?php endforeach; ?>
</div>