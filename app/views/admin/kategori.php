<?php 
$categories = Kategori::all();
?>

<div class="add-btn-wrapper">
    <a id="add-btn" href="form.php?type=kategori&action=add">Tambah Kategori</a>
</div>
<div class="table">
    <div class="table-head">
        <p>No</p>
        <p>Kategori</p>
    </div>
    <?php $num = 1 ?>
    <?php foreach ($categories as $cat) : ?>
        <div class="table-row" id="<?= $cat['f_id'] ?>">
            <p><?= $num ?></p>
            <p><?= $cat['f_kategori'] ?></p>
            <div id="dot-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                </svg>
            </div>
            <div id="action-wrapper">
                <a href="form.php?type=kategori&action=edit&id=<?= $cat['f_id'] ?>" class="action-item">Update</a>
                <p onclick="setDeleteItem(<?= $cat['f_id'] ?>, 'kategori')" class="action-item">Delete</p>
            </div>
        </div>
        <?php $num++ ?>
    <?php endforeach; ?>
</div>