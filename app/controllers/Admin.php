<?php 

class Admin extends Controller {
    public static function all () {
        return self::model('Admin_Model')->all();
    }

    public static function select (array $fields) {
        return self::model('Admin_Model')->select($fields);
    }

    public static function create($data)
    {
        if (self::model('Admin_Model')->create($data)) {
            Flasher::setFlash(Flasher::$message['crud']['create']['success'], 'success');
            return true;
        } else {
            Flasher::setFlash('Username sudah digunakan', 'danger');
            return false;
        }
    }

    public static function update($id, $data)
    {
        if (self::model('Admin_Model')->update($id, $data)) {
            Flasher::setFlash(Flasher::$message['crud']['update']['success'], 'success');
            return true;
        } else {
            Flasher::setFlash('Username sudah digunakan', 'danger');
            return false;
        }
    }

    public static function delete($id)
    {
        if (self::model('Admin_Model')->delete($id)) {
            Flasher::setFlash(Flasher::$message['crud']['delete']['success'], 'success');
        } else {
            Flasher::setFlash(Flasher::$message['crud']['delete']['restrict'], 'danger');
        }
    }


    public static function getArray ($id) {
        return self::model('Admin_Model')->getArray($id);
    }
}