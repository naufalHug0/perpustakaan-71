<?php 
require_once '../../init.php';

Auth::preventUnauthenticated();
Auth::preventUnauthorized(["admin"]);

if (!isset($_GET['page'])) {
    $_GET['page'] = 'kategori';
}

?>

<?php require_once '../templates/header.php' ?>
    <div class="overlay"></div>
    <div class="modal">
        <header>
            Delete
            <div class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>
        </header>
        <div class="content">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" fill="currentColor" class="bi bi-database-x" viewBox="0 0 16 16">
            <path d="M12.096 6.223A4.92 4.92 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.493 4.493 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.525 4.525 0 0 1-.813-.927C8.5 14.992 8.252 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.552 4.552 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10c.262 0 .52-.008.774-.024a4.525 4.525 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777ZM3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4Z"/>
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708Z"/>
            </svg>
            <p>Delete item ini?</p>
            <p>Item tidak dapat dikembalikan</p>
        </div>
        <footer>
            <button onclick="deleteItem()">Delete item</button>
        </footer>
    </div>
    <div class="container">
        <header>
            <ul>
                <li><a href="index.php" class="<?= $_GET['page'] == 'kategori'? 'active':'' ?>">Kategori</a></li>
                <li><a href="?page=buku" class="<?= $_GET['page'] == 'buku'? 'active':'' ?>">Buku</a></li>
                <li><a href="?page=anggota" class="<?= $_GET['page'] == 'anggota'? 'active':'' ?>">Anggota</a></li>
                <li><a href="?page=admin" class="<?= $_GET['page'] == 'admin'? 'active':'' ?>">Admin</a></li>
                <li><a href="?page=peminjaman" class="<?= $_GET['page'] == 'peminjaman'? 'active':'' ?>">Peminjaman</a></li>
                <li><a href="?page=laporan" class="<?= $_GET['page'] == 'laporan'? 'active':'' ?>">Laporan</a></li>
            </ul>
        </header>
        <?php require_once($_GET['page'].".php") ?>
    </div>
<?php require_once '../templates/footer.php' ?>