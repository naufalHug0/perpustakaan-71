<?php 
$books = Buku::all();
?>
<div class="add-btn-wrapper">
    <a id="add-btn" href="form.php?type=buku&action=add">Tambah Buku</a>
</div>
<div class="grid">
    <?php foreach ($books as $book) : ?>
        <div class="card <?= intval($book['f_stok']) < 1 ? 'disabled' : '' ?>">
        <header>
            <?= $book['f_judul'] ?>
            <div id="dot-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                </svg>
            </div>
            <div id="action-wrapper">
                <a href="form.php?type=buku&action=edit&id=<?= $book['f_id'] ?>" class="action-item">Update</a>
                <p onclick="setDeleteItem(<?= $book['f_id'] ?>, 'buku')" class="action-item">Delete</p>
            </div>
        </header>
        <div class="img-wrapper">
            <img src="<?= BASEURL ?>/<?= $book['f_gambar'] ?>" alt="">
        </div>
        <div class="detail-list">
            <p>Kategori</p>
            <p><?= $book['f_kategori'] ?></p>
        </div>
        <div class="detail-list">
            <p>Pengarang</p>
            <p><?= $book['f_pengarang'] ?></p>
        </div>
        <div class="detail-list">
            <p>Penerbit</p>
            <p><?= $book['f_penerbit'] ?></p>
        </div>
        <div class="detail-list">
            <p>Stok</p>
            <p><?= $book['f_stok'] ?></p>
        </div>
        <div class="detail-list">
            <p>Status</p>
            <div class="label label-<?= intval($book['f_stok']) < 1 ? 'danger' : 'success' ?>"><?= intval($book['f_stok']) < 1 ? 'Tidak Tersedia' : 'Tersedia' ?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>