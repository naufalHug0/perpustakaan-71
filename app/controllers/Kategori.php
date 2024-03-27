<?php 

class Kategori extends Controller {
    public static function all () {
        return self::model('Kategori_Model')->all();
    }

    public static function create($data)
    {
        if (self::model('Kategori_Model')->create($data)) {
            Flasher::setFlash(Flasher::$message['crud']['create']['success'], 'success');
            return true;
        } else {
            Flasher::setFlash('Nama kategori sudah ada', 'danger');
            return false;
        }
    }

    public static function select (array $fields) {
        return self::model('Kategori_Model')->select($fields);
    }

    public static function getArray ($id) {
        return self::model('Kategori_Model')->getArray($id);
    }

    public static function update($id, $data)
    {
        if (self::model('Kategori_Model')->update($id, $data)) {
            Flasher::setFlash(Flasher::$message['crud']['update']['success'], 'success');
            return true;
        } else {
            Flasher::setFlash('Nama kategori sudah ada', 'danger');
            return false;
        }
    }

    public static function delete($id)
    {
        if (self::model('Kategori_Model')->delete($id)) {
            Flasher::setFlash(Flasher::$message['crud']['delete']['success'], 'success');
        } else {
            Flasher::setFlash(Flasher::$message['crud']['delete']['restrict'], 'danger');
        }
    }
}