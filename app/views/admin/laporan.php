<?php
$laporan = Laporan::all();

?>

<div class="grid">
    <div class="chart-section">
        <p>Buku dengan Peminjaman Terbanyak</p>
        <h1><?= $laporan['most_rent']['data'] ? $laporan['most_rent']['data'][0]['judul'] : 'Belum ada data' ?></h1>
        <?php if ($laporan['most_rent']['data']) : ?>
        <div class="chart chart-bar">
            <?php foreach ($laporan['most_rent']['data'] as $book) : ?>
                <div class="bar"><div style="height: <?= round(($book['total_rent'] / $laporan['most_rent']['total_data']) * 100) ?>%"></div></div>
            <?php endforeach; ?>
        </div>
        <div class="bar-qty">
            <?php foreach ($laporan['most_rent']['data'] as $book) : ?>
                <p><?= $book['total_rent'] ?></p>
            <?php endforeach; ?>
        </div>
        <form action="../export.php?type=most_rent" method="post" target="_blank">
            <input type="hidden" name="data" value="<?= htmlspecialchars(serialize($laporan['most_rent']['data'])) ?>">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z"/>
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
                Cetak
            </button>
        </form>
        <?php endif; ?>
    </div>
    <div class="chart-section">
        <p>Buku yang Belum Kembali</p>
        <h1><?= $laporan['book_return']['data']? ($laporan['book_return']['total_not_returned']." Buku") : 'Belum ada data' ?></h1>
        <?php if ($laporan['book_return']['data']) : ?>
        <div class="chart chart-load">
            <div class="desc">
                <div>
                    <p>Belum Kembali</p>
                    <h1><?= round(($laporan['book_return']['total_not_returned'] / $laporan['book_return']['total_data']) * 100) ?>%</h1>
                </div>
                <div>
                    <p>Sudah Kembali</p>
                    <h1><?= round(($laporan['book_return']['total_returned'] / $laporan['book_return']['total_data']) * 100) ?>%</h1>
                </div>
            </div>
            <div class="load-bar"><div style="width: <?= round(($laporan['book_return']['total_not_returned'] / $laporan['book_return']['total_data']) * 100) ?>%"></div></div>
        </div>
        <form action="../export.php?type=unreturned_book" method="post" target="_blank">
            <input type="hidden" name="data" value="<?= htmlspecialchars(serialize($laporan['book_return']['data'])) ?>">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z"/>
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
                Cetak
            </button>
        </form>
        <?php endif; ?>
    </div>
    <div class="chart-section">
        <p>Anggota yang Belum Mengembalikan Buku</p>
        <h1><?= $laporan['members_with_unreturned_books']['data'] ? ($laporan['members_with_unreturned_books']['total_data']."Anggota") : 'Belum ada data' ?> </h1>
        <?php if ($laporan['members_with_unreturned_books']['data']) : ?>
        <div class="chart chart-list">
            <ul>
                <?php foreach ($laporan['members_with_unreturned_books']['data'] as $member) : ?>
                <li>
                    <p><?= $member['nama'] ?></p>
                    <p><?= $member['total_book'] ?> Buku</p>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <form action="../export.php?type=unreturned_books_member" method="post" target="_blank">
            <input type="hidden" name="data" value="<?= htmlspecialchars(serialize($laporan['members_with_unreturned_books']['data'])) ?>">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z"/>
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
                Cetak
            </button>
        </form>
        <?php endif; ?>
    </div>
    <div class="chart-section">
        <p>Anggota yang Sering Meminjam Buku</p>
        <h1><?= $laporan['members_with_most_rent_books'] ? $laporan['members_with_most_rent_books'][0]['nama'] : 'Belum ada data' ?></h1>
        <?php if ($laporan['members_with_most_rent_books']) : ?>
        <div class="chart chart-list">
            <ul>
                <?php foreach ($laporan['members_with_most_rent_books'] as $member) : ?>
                    <li>
                        <p><?= $member['nama'] ?></p>
                        <p><?= $member['total_book'] ?> Buku</p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <form action="../export.php?type=most_rent_member" method="post" target="_blank">
            <input type="hidden" name="data" value="<?= htmlspecialchars(serialize($laporan['members_with_most_rent_books'])) ?>">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z"/>
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
                Cetak
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>