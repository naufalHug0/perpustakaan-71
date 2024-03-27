<?php 

class Buku extends Controller {
    public static function all () {
        return self::model('Buku_Model')->all();
    }

    public static function select (array $fields, $type) {
        return self::model('Buku_Model')->select($fields, $type);
    }

    public static function create($post, $files)
    {
        $response = self::model('Buku_Model')->create($post, $files);
        if ($response) {
            Flasher::setFlash($response['message'], 'success');
            return true;
        }
    }
    public static function update($id, $data, $files)
    {
        $result = self::model('Buku_Model')->update($id, $data, $files);
        if ($result['success']) {
            Flasher::setFlash(Flasher::$message['crud']['update']['success'], 'success');
            return true;
        } else {
            Flasher::setFlash($result['message'], 'danger');
            return false;
        }
    }

    public static function delete($id)
    {
        if (self::model('Buku_Model')->delete($id)) {
            Flasher::setFlash(Flasher::$message['crud']['delete']['success'], 'success');
        } else {
            Flasher::setFlash(Flasher::$message['crud']['delete']['restrict'], 'danger');
        }
    }

    public static function getArray ($id) {
        return self::model('Buku_Model')->getArray($id);
    }
}