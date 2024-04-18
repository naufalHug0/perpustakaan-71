<?php 

class Peminjaman_Model {
    public function all() {
        $user_id = $_SESSION['u_id'];
        return Database::result_set(
            Database::query(
                "SELECT 
                t_peminjaman.f_id as id_peminjaman,
                t_peminjaman.f_tanggalpeminjaman,
                t_peminjaman.f_expireddate,
                t_detailpeminjaman.f_tanggalkembali,
                t_admin.f_nama as nama_admin,
                t_anggota.f_nama as nama_anggota,
                t_buku.f_judul as judul,
                t_kategori.f_kategori as kategori,
                t_buku.f_gambar as gambar
                FROM t_peminjaman 
                INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
                INNER JOIN t_admin ON t_peminjaman.f_idadmin = t_admin.f_id
                INNER JOIN t_anggota ON t_peminjaman.f_idanggota = t_anggota.f_id
                INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
                INNER JOIN t_buku ON t_buku.f_id = t_detailbuku.f_idbuku
                INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id 
                ". ($_SESSION['u_rl'] == 'pustakawan' ? "WHERE t_peminjaman.f_idadmin = $user_id":'') .
                " ORDER BY t_peminjaman.f_tanggalpeminjaman DESC
                "
            )
        );
    }

    public function create ($data) {
        global $conn;
        $id_admin = $_SESSION['u_id'];
        $id_anggota = $data['anggota'];
        $id_buku = $data['judul'];
        $tanggal_pinjam = $data['tgl-pinjam'];
        $exp_date = (new DateTime($data['tgl-pinjam']))->modify('+3 day')->format('Y-m-d');

        Database::query(
            "INSERT INTO t_peminjaman VALUES (
                NULL,
                '$id_admin',
                '$id_anggota',
                '$tanggal_pinjam',
                '$exp_date'
            )"
        );

        $id_peminjaman = mysqli_insert_id($conn);

        $id_detailbuku = Database::result_set(Database::query(
            "SELECT f_id as id from t_detailbuku where f_idbuku = $id_buku AND f_status = 'Tersedia' LIMIT 1"
        ))[0]['id'];

        Database::query(
            "INSERT INTO t_detailpeminjaman VALUES (
                NULL,
                '$id_peminjaman',
                '$id_detailbuku',
                NULL
            )"
        );

        Database::query(
            "UPDATE t_detailbuku SET f_status = 'Tidak Tersedia' WHERE f_id = '$id_detailbuku'"
        );

        return Database::getAffectedRows() > 0;
    }

    public function update ($id, $data) {
        $updated_id_buku = $data['judul'];
        $tanggal_pinjam = $data['tgl-pinjam'];

        $peminjaman = Database::result_set(Database::query(
            "SELECT * from t_peminjaman inner join t_detailpeminjaman on t_peminjaman.f_id = 
            t_detailpeminjaman.f_idpeminjaman where t_peminjaman.f_id = $id"
        )
        )[0];

        $updated_id_detail_buku = Database::result_set(Database::query(
            "SELECT f_id from t_detailbuku WHERE f_idbuku = $updated_id_buku"
        )
        )[0]['f_id'];

        Database::query(
            "UPDATE t_peminjaman SET
                f_tanggalpeminjaman='$tanggal_pinjam'
                WHERE f_id = $id
            "
        );

        Database::query(
            "UPDATE t_detailpeminjaman SET
                f_iddetailbuku = $updated_id_detail_buku
                WHERE t_detailpeminjaman.f_idpeminjaman = $id
            "
        );

        if ($updated_id_detail_buku != $peminjaman['f_iddetailbuku']) {
            Database::query(
                "UPDATE t_detailbuku SET
                    f_status = 'Tersedia'
                    WHERE f_id = {$peminjaman['f_iddetailbuku']} AND f_status = 'Tidak Tersedia'
                    LIMIT 1
                "
            );

            Database::query(
                "UPDATE t_detailbuku SET
                    f_status = 'Tidak Tersedia'
                    WHERE f_id = {$updated_id_detail_buku} AND f_status = 'Tersedia'
                    LIMIT 1
                "
            );
        }

        return true;
    }

    public function getArray($id) {
        return Database::result_set_array(
            Database::query(
                "SELECT 
                t_buku.f_judul as judul,
                t_peminjaman.f_tanggalpeminjaman
                FROM t_peminjaman 
                INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
                INNER JOIN t_admin ON t_peminjaman.f_idadmin = t_admin.f_id
                INNER JOIN t_anggota ON t_peminjaman.f_idanggota = t_anggota.f_id
                INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
                INNER JOIN t_buku ON t_detailbuku.f_idbuku = t_buku.f_id 
                INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id
                WHERE t_peminjaman.f_id = $id"
            )
        );
    }

    public function getByUserId($id) {
        return Database::result_set(
            Database::query (
                "SELECT 
                t_peminjaman.f_id as id_peminjaman,
                t_peminjaman.f_tanggalpeminjaman,
                t_detailpeminjaman.f_tanggalkembali,
                t_peminjaman.f_expireddate,
                t_admin.f_nama as nama_admin,
                t_anggota.f_nama as nama_anggota,
                t_buku.f_judul as judul,
                t_kategori.f_kategori as kategori,
                t_buku.f_gambar as gambar
                FROM t_peminjaman 
                INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
                INNER JOIN t_admin ON t_peminjaman.f_idadmin = t_admin.f_id
                INNER JOIN t_anggota ON t_peminjaman.f_idanggota = t_anggota.f_id
                INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
                INNER JOIN t_buku ON t_buku.f_id = t_detailbuku.f_idbuku
                INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id
                WHERE t_peminjaman.f_idanggota = $id
                ORDER BY t_peminjaman.f_tanggalpeminjaman DESC
                "
            )
        );
    }

    public function getOverdueBooks($id)
    {
        return Database::result_set(
            Database::query (
                "SELECT 
                t_peminjaman.f_id
                FROM t_peminjaman 
                INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
                INNER JOIN t_anggota ON t_peminjaman.f_idanggota = t_anggota.f_id
                WHERE t_peminjaman.f_idanggota = 2
                AND t_detailpeminjaman.f_tanggalkembali IS NULL
                AND DATE(NOW()) > t_peminjaman.f_expireddate
                ORDER BY t_peminjaman.f_tanggalpeminjaman DESC"
            )
        );
    }

    public function mostRent() {
        $user_id = $_SESSION['u_id'];

        $total_data = Database::result_set(
            Database::query(
                "SELECT COUNT(*) as total_data FROM `t_detailpeminjaman`
                INNER JOIN t_peminjaman ON t_detailpeminjaman.f_idpeminjaman = t_peminjaman.f_id
                "
                . ($_SESSION['u_rl'] == 'pustakawan' ? "WHERE t_peminjaman.f_idadmin = $user_id ":'')
            )
        )[0]['total_data'];
        
        $data = Database::result_set(
            Database::query(
                "SELECT t_buku.f_judul as judul,COUNT(*) as total_rent FROM `t_detailpeminjaman` 
                INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
                INNER JOIN t_peminjaman ON t_detailpeminjaman.f_idpeminjaman = t_peminjaman.f_id
                INNER JOIN t_buku ON t_buku.f_id = t_detailbuku.f_idbuku "
                . ($_SESSION['u_rl'] == 'pustakawan' ? "WHERE t_peminjaman.f_idadmin = $user_id ":'') .
                "GROUP BY f_iddetailbuku ORDER BY total_rent DESC LIMIT 5 OFFSET 0"
            )
        );

        return [
            'total_data' => $total_data,
            'data' => $data
        ];
    }

    public function bookReturn () {
        $user_id = $_SESSION['u_id'];

        $total_data = Database::result_set(
            Database::query(
                "SELECT COUNT(*) as total_data FROM `t_detailpeminjaman`
                INNER JOIN t_peminjaman ON t_detailpeminjaman.f_idpeminjaman = t_peminjaman.f_id
                "
                . ($_SESSION['u_rl'] == 'pustakawan' ? "WHERE t_peminjaman.f_idadmin = $user_id ":'')
            )
        )[0]['total_data'];

        $data_book = Database::result_set(
            Database::query(
                "SELECT t_buku.f_judul as judul , t_buku.f_pengarang as pengarang , t_buku.f_penerbit as penerbit , COUNT(CASE WHEN t_detailbuku.f_status = 'Tersedia' THEN 1 END) as stok FROM `t_detailpeminjaman` 
                INNER JOIN t_detailbuku ON t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
                INNER JOIN t_peminjaman ON t_detailpeminjaman.f_idpeminjaman = t_peminjaman.f_id
                INNER JOIN t_buku ON t_buku.f_id = t_detailbuku.f_idbuku
                WHERE t_detailpeminjaman.f_tanggalkembali IS NULL "
                . ($_SESSION['u_rl'] == 'pustakawan' ? "AND t_peminjaman.f_idadmin = $user_id ":'') .
                "group by t_buku.f_id"
            )
        );

        $total_returned = Database::result_set(
            Database::query(
                "SELECT 
                count(*) as count
                FROM `t_detailpeminjaman` 
                INNER JOIN t_peminjaman ON t_detailpeminjaman.f_idpeminjaman = t_peminjaman.f_id
                WHERE t_detailpeminjaman.f_tanggalkembali IS NOT NULL "
                . ($_SESSION['u_rl'] == 'pustakawan' ? "AND t_peminjaman.f_idadmin = $user_id ":'')
            )
        )[0]['count'];

        $total_not_returned = Database::result_set(
            Database::query(
                "SELECT 
                count(*) as count
                FROM `t_detailpeminjaman` 
                INNER JOIN t_peminjaman ON t_detailpeminjaman.f_idpeminjaman = t_peminjaman.f_id
                WHERE t_detailpeminjaman.f_tanggalkembali IS NULL "
                . ($_SESSION['u_rl'] == 'pustakawan' ? "AND t_peminjaman.f_idadmin = $user_id ":'')
            )
        )[0]['count'];

        return [
            'total_data' => $total_data,
            'total_returned' => $total_returned,
            'total_not_returned' => $total_not_returned,
            'data' => $data_book
        ];
    }

    public function membersWithUnreturnedBooks () {
        // $total_data = Database::result_set(
        //     Database::query(
        //         "SELECT COUNT(*) as total_data FROM `t_detailpeminjaman` WHERE t_detailpeminjaman.f_tanggalkembali IS NULL"
        //     )
        // )[0]['total_data'];

        $user_id = $_SESSION['u_id'];

        $data = Database::result_set(
            Database::query(
                "SELECT COUNT(*) as total_book, t_anggota.f_nama as nama FROM `t_peminjaman` 
                INNER JOIN t_anggota ON t_peminjaman.f_idanggota = t_anggota.f_id 
                INNER JOIN t_detailpeminjaman ON t_peminjaman.f_id = t_detailpeminjaman.f_idpeminjaman
                WHERE t_detailpeminjaman.f_tanggalkembali IS NULL "
                . ($_SESSION['u_rl'] == 'pustakawan' ? "AND t_peminjaman.f_idadmin = $user_id ":'').
                "GROUP BY t_peminjaman.f_idanggota ORDER BY total_book DESC"
            )
        );

        return [
            'total_data' => count($data),
            'data' => $data
        ];
    }

    public function membersWithMostRentBooks () {
        $user_id = $_SESSION['u_id'];

        $data = Database::result_set(
            Database::query(
                "SELECT COUNT(*) as total_book, t_anggota.f_nama as nama FROM `t_peminjaman` 
                INNER JOIN t_anggota ON t_peminjaman.f_idanggota = t_anggota.f_id " 
                . ($_SESSION['u_rl'] == 'pustakawan' ? "WHERE t_peminjaman.f_idadmin = $user_id ":'').
                "GROUP BY t_peminjaman.f_idanggota ORDER BY total_book DESC LIMIT 2 OFFSET 0"
            )
        );

        return $data;
    }

    public function search ($keyword) {
        return Database::result_set(
            Database::query (
                "SELECT 
                t_peminjaman.f_id as id_peminjaman,
                t_peminjaman.f_tanggalpeminjaman,
                t_detailpeminjaman.f_tanggalkembali,
                t_admin.f_nama as nama_admin,
                t_anggota.f_nama as nama_anggota,
                t_buku.f_judul as judul,
                t_kategori.f_kategori as kategori,
                t_buku.f_gambar as gambar
                FROM `t_peminjaman` 
                inner join t_detailpeminjaman on t_detailpeminjaman.f_idpeminjaman = t_peminjaman.f_id
                inner join t_detailbuku on t_detailpeminjaman.f_iddetailbuku = t_detailbuku.f_id
                inner join t_buku on t_detailbuku.f_idbuku = t_buku.f_id
                inner join t_admin on t_peminjaman.f_idadmin = t_admin.f_id
                inner join t_anggota on t_peminjaman.f_idanggota = t_anggota.f_id
                INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id
                where 
                t_buku.f_judul like '%$keyword%' OR
                t_kategori.f_kategori like '%$keyword%' OR
                t_buku.f_pengarang like '%$keyword%' OR
                t_buku.f_penerbit like '%$keyword%' OR
                t_admin.f_nama like '%$keyword%' OR
				t_anggota.f_nama like '%$keyword%'"
            )
        );
    }

    public function returnBook ($id) {
        $date = date("Y-m-d");

        $detail_peminjaman = Database::result_set(Database::query(
            "SELECT * FROM t_detailpeminjaman where f_idpeminjaman = $id"
        )
        )[0];

        Database::query("UPDATE t_detailpeminjaman SET t_detailpeminjaman.f_tanggalkembali = '$date' where f_id = {$detail_peminjaman['f_id']}");

        Database::query(
            "UPDATE t_detailbuku SET
                f_status = 'Tersedia'
                WHERE f_id = {$detail_peminjaman['f_iddetailbuku']} AND f_status = 'Tidak Tersedia'
                LIMIT 1
            "
        );

        return Database::getAffectedRows() > 0;
    }

}