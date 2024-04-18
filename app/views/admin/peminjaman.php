<?php 
$peminjamans = isset($_GET['search']) ? Peminjaman::search($_GET['search']) : Peminjaman::all();

if (isset($_GET['return']) && isset($_GET['id'])) {
    Peminjaman::returnBook($_GET['id']);
    Utils::reloadPage('?page=peminjaman');
}

?>
<div class="add-btn-wrapper search">
<form action="" method="get">
    <input type="search" name="search" id="search" placeholder="Cari..." autocomplete="off">
</form>
<a id="add-btn" href="form.php?type=peminjaman&action=add">Tambah Peminjaman</a>
</div>
<div class="grid">
<?php if (isset($_GET['search'])) : ?>
    <a id="return-btn" href="peminjaman.php">Kembali</a>
<?php endif; ?>
<?php if ($peminjamans) : ?>
    <?php foreach ($peminjamans as $peminjaman) : ?>
        <div class="card">
            <header>
                <p><?= $peminjaman['judul'] ?> &nbsp;<span> |  &nbsp; <?= $peminjaman['kategori'] ?></span></p>
                <div id="dot-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                    </svg>
                </div>
                <div id="action-wrapper">
                    <a href="form.php?type=peminjaman&action=edit&id=<?= $peminjaman['id_peminjaman'] ?>" class="action-item">Update</a>
                </div>
            </header>
            <div class="status-section">
                <div class="status status-<?= $peminjaman['f_tanggalkembali'] == NULL ? 'danger':'success' ?>">
                    <?= $peminjaman['f_tanggalkembali'] == NULL ? 'Belum':'Sudah' ?> Kembali
                </div>
                <div class="detail-list">
                    <p>Admin : </p>
                    <p><?= $peminjaman['nama_admin'] ?></p>
                </div>
            </div>
            <div class="content">
                <img src="<?= BASEURL ?>/<?= $peminjaman['gambar'] ?>" alt="">
                <div class="detail-lists">
                    <div class="detail-list">
                        <p>Dipinjam oleh</p>
                        <p><?= $peminjaman['nama_anggota'] ?></p>
                    </div>
                    <div class="detail-list">
                        <p>Dipinjam Tanggal</p>
                        <p><?= Utils::format_date($peminjaman['f_tanggalpeminjaman']) ?></p>
                    </div>
                    <?php if ($peminjaman['f_tanggalkembali'] != NULL) : ?>
                        <div class="detail-list">
                            <p>Dikembalikan Tanggal</p>
                            <p><?= Utils::format_date($peminjaman['f_tanggalkembali']) ?></p>
                        </div>
                    <?php else : ?>
                        <div class="detail-list">
                            <p>Tenggat Pengembalian</p>
                            <p><?= Utils::format_date($peminjaman['f_expireddate']) ?></p>
                        </div>
                    <?php endif; ?>
            </div>
            <?php if ($peminjaman['f_tanggalkembali'] == NULL) : ?>
                <form action="" method="get">
                    <input type="hidden" name="page" value="peminjaman">
                    <input type="hidden" name="return" value="true">
                    <input type="hidden" name="id" value="<?= $peminjaman['id_peminjaman'] ?>">
                    <button id="add-btn">Kembalikan Buku</button>
                </form>
            <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <h1>Belum ada peminjaman</h1>
<?php endif; ?>