<?php 

class Anggota_Model {
    public function all() {
        return Database::result_set(
            Database::query(
                "SELECT * FROM t_anggota"
            )
        );
    }

    public function select(array $fields) {
        $query = "SELECT ";

        for ($i = 0; $i < count($fields); $i++) {
            $query .= $fields[$i]['name'] .($fields[$i]['alias'] ? (' as '.$fields[$i]['alias']) : '');
            if ($i + 1 < count($fields))  {
                $query .= ',';
            }
        }

        $query .= " FROM t_anggota";

        return Database::result_set(
            Database::query(
                $query
            )
        );
    }

    public function create ($data) {
        $nama = $data['nama'];
        $username = $data['username'];
        $password = md5($data['password']);
        $tempat_lahir = $data['tempat-lahir'];
        $tgl_lahir = $data['tgl-lahir'];

        $is_anggota_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_anggota WHERE upper(f_username)='".strtoupper($username)."'"
            )
        );

        $is_admin_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_admin WHERE upper(f_username)='".strtoupper($username)."'"
            )
        );

        if ($is_anggota_exist || $is_admin_exist) {
            return false;
        }

        Database::query(
            "INSERT INTO t_anggota VALUES (
                NULL,
                '$nama',
                '$username',
                '$password',
                '$tempat_lahir',
                '$tgl_lahir'
            )"
        );

        
        return true;
    }

    public function update ($id, $data) {
        $nama = $data['nama'];
        $username = $data['username'];
        $password = $data['password'] == $data['old_password'] ? $data['password'] : md5($data['password']);
        $tempat_lahir = $data['tempat-lahir'];
        $tgl_lahir = $data['tgl-lahir'];

        $is_anggota_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_anggota WHERE upper(f_username)='".strtoupper($username)."' AND f_id != $id"
            )
        );

        if ($is_anggota_exist) {
            return false;
        }

        Database::query(
            "UPDATE t_anggota SET
            f_nama = '$nama',
            f_username = '$username',
            f_password = '$password',
            f_tempatlahir = '$tempat_lahir',
            f_tanggallahir = '$tgl_lahir'
            WHERE f_id = $id"
        );

        
        return Database::getAffectedRows() > 0;
    }

    public function delete ($id) {
        if ($_SESSION['u_id'] == $id && $_SESSION['u_rl'] == 'anggota') {
            return false;
        }

        Database::query(
            "DELETE FROM t_anggota WHERE f_id = $id"
        );

        if (Database::get_error()) {
            return false;
        }
        
        return Database::getAffectedRows() > 0;
    }

    public function getArray ($id) {
        return Database::result_set_array(
            Database::query(
                "SELECT 
                f_nama,
                f_username,
                f_password,
                f_tempatlahir,
                f_tanggallahir
                FROM t_anggota WHERE f_id = $id"
            )
        );
    }
}