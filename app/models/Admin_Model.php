<?php
class Admin_Model {
    private $table = 't_admin';

    public function withCredentials($username, $password, $role) {
        return Database::result_set(
            Database::query("SELECT * FROM $this->table WHERE f_username = '$username' AND f_password = '$password' AND f_level = '$role'")
        );
    }

    public function all() {
        return Database::result_set(
            Database::query(
                "SELECT * FROM t_admin"
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

        $query .= " FROM $this->table";

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
        $status = $data['status'];
        $level = $data['level'];
        

        $is_admin_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_admin WHERE upper(f_username)='".strtoupper($username)."'"
            )
        );

        $is_anggota_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_anggota WHERE upper(f_username)='".strtoupper($username)."'"
            )
        );

        if ($is_admin_exist || $is_anggota_exist) {
            return false;
        }

        $date = date('Y-m-d H:i:s');

        Database::query(
            "INSERT INTO t_admin VALUES (
                NULL,
                '$nama',
                '$username',
                '$password',
                '$status',
                '$level',
                '$date',
                '$date'
            )"
        );

        
        return true;
    }

    public function update ($id, $data) {
        $nama = $data['nama'];
        $username = $data['username'];
        $password = $data['password'] == $data['old_password'] ? $data['password'] : md5($data['password']);
        $status = $data['status'];
        $level = $data['level'];

        $is_admin_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_admin WHERE upper(f_username)='".strtoupper($username)."' AND f_id != $id"
            )
        );

        if ($is_admin_exist) {
            return false;
        }

        Database::query(
            "UPDATE t_admin SET
            f_nama = '$nama',
            f_username = '$username',
            f_password = '$password',
            f_status = '$status',
            f_level = '$level'
            WHERE f_id = $id"
        );

        
        return Database::getAffectedRows() > 0;
    }

    public function delete ($id) {
        if ($_SESSION['u_id'] == $id && $_SESSION['u_rl'] == 'admin') {
            return false;
        }

        Database::query(
            "DELETE FROM t_admin WHERE f_id = $id"
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
                f_status,
                f_level
                FROM t_admin WHERE f_id = $id"
            )
        );
    }
}