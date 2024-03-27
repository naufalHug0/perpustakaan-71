<?php 

class Buku_Model {
    public function all() {
        return Database::result_set(
            Database::query(
                "SELECT 
                t_buku.f_id,
                t_buku.f_judul,
                t_buku.f_gambar,
                t_buku.f_pengarang,
                t_buku.f_penerbit,
                t_kategori.f_kategori,
                COUNT(CASE WHEN t_detailbuku.f_status = 'Tersedia' THEN 1 END) AS f_stok
                FROM t_buku INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id
                INNER JOIN t_detailbuku ON t_buku.f_id = t_detailbuku.f_idbuku
                group by t_buku.f_id"
            )
        );
    }

    public function select(array $fields, $type) {
        $query = "SELECT distinct ";

        for ($i = 0; $i < count($fields); $i++) {
            $query .= $fields[$i]['name'] .($fields[$i]['alias'] ? (' as '.$fields[$i]['alias']) : '');
            if ($i + 1 < count($fields))  {
                $query .= ',';
            }
        }

        $query .= " FROM t_buku INNER JOIN t_detailbuku ON t_detailbuku.f_idbuku = t_buku.f_id".($type == 'add'?" WHERE t_detailbuku.f_status = 'Tersedia'":'');

        return Database::result_set(
            Database::query(
                $query
            )
        );
    }

    public function create ($data, $files) {
        global $conn;
        $judul = $data['judul'];
        $pengarang = $data['pengarang'];
        $penerbit = $data['penerbit'];
        $id_kategori = $data['kategori'];
        $stok = $data['stok'];
        $desc = $data['desc'];

        $is_book_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_buku WHERE upper(f_judul)='".strtoupper($judul)."'"
            )
        );

        if ($is_book_exist) {
            $id = $is_book_exist[0]['f_id'];

            $stok_query = "INSERT INTO t_detailbuku VALUES ";

            for ($i = 1; $i <= intval($stok); $i++) {
                $stok_query .= "(
                    NULL, $id, 'Tersedia'
                )".($i < intval($stok) ? ",":'');
            }

            Database::query(
                $stok_query
            );

            return ['message'=>'Stok buku berhasil ditambah'];
        }

        $image = self::uploadImg($files);

        Database::query(
            "INSERT INTO t_buku VALUES (
                NULL,
                '$id_kategori',
                '$judul',
                '$image',
                '$pengarang',
                '$penerbit',
                '$desc'
            )"
        );

        $id_buku = mysqli_insert_id($conn);

        $stok_query = "INSERT INTO t_detailbuku VALUES ";

        for ($i = 1; $i <= intval($stok); $i++) {
            $stok_query .= "(
                NULL, $id_buku, 'Tersedia'
            )".($i < intval($stok) ? ",":'');
        }

        Database::query(
            $stok_query
        );
        
        return ['message'=>'Buku berhasil ditambah'];
    }

    public function update ($id, $data, $files) {
        $judul = $data['judul'];
        $pengarang = $data['pengarang'];
        $penerbit = $data['penerbit'];
        $id_kategori = $data['kategori'];
        $stok = $data['stok'];
        $desc = $data['desc'];
        
        $is_book_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_buku WHERE upper(f_judul)='".strtoupper($judul)."' AND f_id != $id"
                )
            );
            
        if ($is_book_exist) {
            return ['success'=>false, 'message'=>'Nama buku sudah ada'];
        }

        $current_stock = intval(Database::result_set(
            Database::query("SELECT count(*) as total_stok from t_detailbuku where f_idbuku = $id")
        )[0]['total_stok']);

        if (intval($stok) < $current_stock) {
            return ['success'=>false, 'message'=>'Stok tidak dapat dikurangi'];
        }

        $image = self::uploadImg($files, $data['old_img']);
        var_dump("");

        Database::query(
            "UPDATE t_buku SET
                f_idkategori='$id_kategori',
                f_judul='$judul',
                f_gambar='$image',
                f_pengarang='$pengarang',
                f_penerbit='$penerbit',
                f_deskripsi='$desc'
                WHERE f_id = $id
            "
        );

        if (intval($stok) > $current_stock) {
            $stok_query = "INSERT INTO t_detailbuku VALUES ";
            $date = date('Y-m-d H:i:s');

            for ($i = $current_stock; $i < intval($stok); $i++) {
                $stok_query .= "(
                    NULL, $id, 'Tersedia', '$date'
                )". ($i < intval($stok) - 1 ? ",":'');
            }

            Database::query(
                $stok_query
            );
        }
        
        return ['success'=>true];
    }

    public function delete($id)
    {
        Database::query(
            "DELETE FROM t_buku WHERE f_id = $id"
        );

        if (Database::get_error()) {
            return false;
        }
        
        return Database::getAffectedRows() > 0;
    }

    public function uploadImg ($files, $old_img = null) {
        if (strlen($files["image"]["name"]) == 0) {
            return $old_img;
        }
        
        $namaFile = $files["image"]["name"];
        $temp = $files["image"]["tmp_name"];
        $extension = explode('.', $namaFile)[1];
        
        $uniqName = uniqid().'.'.$extension;
    
        $thumb = 'assets/book-img/'. $uniqName;
    
        move_uploaded_file($temp, __DIR__.'/../../public/'.$thumb);
    
        return $thumb;
    }

    public function getArray ($id) {
        return Database::result_set_array(
            Database::query(
                "SELECT 
                t_buku.f_judul,
                t_buku.f_pengarang,
                t_buku.f_penerbit,
                t_kategori.f_kategori,
                t_buku.f_gambar,
                count(*) as f_stok, 
                t_buku.f_deskripsi
                FROM t_buku INNER JOIN t_kategori ON t_buku.f_idkategori = t_kategori.f_id
                INNER JOIN t_detailbuku ON t_buku.f_id = t_detailbuku.f_idbuku
                WHERE t_buku.f_id = $id
                group by t_buku.f_id"
            )
        );
    }
}