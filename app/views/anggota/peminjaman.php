<div class="grid">
<?php if ($peminjamans) : ?>
<!-- notif overdue -->

    <?php if ($overdues > 0) : ?>
    <div style="background-color: #fdd2d2;display:flex;align-items: center;gap: 10px; padding: 18px 25px; border: 1px solid #f5c6cb;color: #cc1b1b;border-radius: 8px;font-weight: 300;font-size: 14px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
        <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
        <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
        </svg>
        <p>Ada <?= $overdues ?> Buku melebihi tenggat waktu, segera kembalikan!</p>
    </div>
    <?php endif; ?>
    <?php foreach ($peminjamans as $peminjaman) : ?>
        <div class="card">
            <header>
                <p><?= $peminjaman['judul'] ?> &nbsp;<span> | &nbsp; <?= $peminjaman['kategori'] ?></span></p>
            </header>
            <div class="status-section">
                <div style="display: flex;align-items: center;gap: 5px;">
                    <div class="status status-<?= $peminjaman['f_tanggalkembali'] == NULL ? 'danger':'success' ?>">
                        <?= $peminjaman['f_tanggalkembali'] == NULL ? 'Belum':'Sudah' ?> Kembali
                    </div>
                    <div style="color: rgb(193, 193, 193); font-weight: 300;border: 1px solid rgb(193, 193, 193);display:flex;align-items: center;gap:5px;
                    <?= date('Y-m-d') ==  $peminjaman['f_expireddate'] ? 'background-color: #ffd000 ;border: none; color: #0d1117;':''?>;
                    <?= strtotime(date('Y-m-d')) > strtotime($peminjaman['f_expireddate']) ? 'background-color: red ;border: none; color: white;':''?>
                    <?= $peminjaman['f_tanggalkembali'] != NULL ? 'background-color:#4bce97;color: white;border: none;':'' ?>
                    "  class="status" >
                        <?php if ($peminjaman['f_tanggalkembali'] == NULL) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                        </svg>
                        <?php else : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
                        </svg>
                        <?php endif; ?>
                        <?= Utils::format_date($peminjaman['f_tanggalpeminjaman']) ?> - <?= Utils::format_date($peminjaman['f_expireddate']) ?>
                    </div>
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
                    <div class="detail-list">
                        <p>Tenggat Pengembalian</p>
                        <p><?= Utils::format_date($peminjaman['f_expireddate']) ?></p>
                    </div>
                    <?php if ($peminjaman['f_tanggalkembali'] != NULL) : ?>
                        <div class="detail-list">
                            <p>Dikembalikan Tanggal</p>
                            <p><?= Utils::format_date($peminjaman['f_tanggalkembali']) ?></p>
                        </div>
                    <?php endif; ?>
            </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <h1>Belum ada peminjaman</h1>
<?php endif; ?>