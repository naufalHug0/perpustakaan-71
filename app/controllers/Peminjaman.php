<?php 

class Peminjaman extends Controller {
    public static function all () {
        return self::model('Peminjaman_Model')->all();
    }

    public static function create($data)
    {
        if (self::model('Peminjaman_Model')->create($data)) {
            Flasher::setFlash('Buku Berhasil Dipinjam', 'success');
            return true;
        }
    }

    public static function update($id, $data)
    {
        if (self::model('Peminjaman_Model')->update($id, $data)) {
            Flasher::setFlash(Flasher::$message['crud']['update']['success'], 'success');
            return true;
        } 
    }

    public static function search($keyword)
    {
        return self::model('Peminjaman_Model')->search($keyword);
    }

    public static function returnBook ($id) {
        if (self::model('Peminjaman_Model')->returnBook($id)) {
            Flasher::setFlash('Peminjaman berhasil dikembalikan', 'success');
        }
    }
    
    public static function getByUserId($id) {
        return self::model('Peminjaman_Model')->getByUserId($id);
    }
    public static function getOverdueBooks($id) {
        return self::model('Peminjaman_Model')->getOverdueBooks($id);
    }

    public static function getArray ($id) {
        return self::model('Peminjaman_Model')->getArray($id);
    }
}