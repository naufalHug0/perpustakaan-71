<?php 
$admins = Admin::all();
?>
<div class="add-btn-wrapper">
<a id="add-btn" href="form.php?type=admin&action=add">Tambah Admin</a>
</div>
<div class="table">
    <div class="table-head">
        <p>No</p>
        <p>Nama</p>
        <p>Password</p>
        <p>Status</p>
        <p>Level</p>
    </div>
    <?php $num = 1 ?>
    <?php foreach ($admins as $admin) : ?>
        <div class="table-row">
            <p><?= $num ?></p>
            <p><?= $admin['f_nama'] ?></p>
            <p><?= substr($admin['f_password'],0,7) ?>...</p>
            <p><?= $admin['f_status'] ?></p>
            <p><?= $admin['f_level'] ?></p>
            <div id="dot-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                </svg>
            </div>
            <div id="action-wrapper">
                <a href="form.php?type=admin&action=edit&id=<?= $admin['f_id'] ?>" class="action-item">Update</a>
                <p onclick="setDeleteItem(<?= $admin['f_id'] ?>, 'admin')" class="action-item">Delete</p>
            </div>
        </div>
        <?php $num++ ?>
    <?php endforeach; ?>
</div>