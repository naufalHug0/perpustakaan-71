<?php 

class Kategori_Model {
    public function all() {
        return Database::result_set(
            Database::query(
                "SELECT * FROM t_kategori"
            )
        );
    }

    public function create ($data) {
        $kategori = $data['kategori'];
        
        $is_kategori_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_kategori WHERE upper(f_kategori)='".strtoupper($kategori)."'"
            )
        );

        if ($is_kategori_exist) {
            return false;
        }

        Database::query(
            "INSERT INTO t_kategori VALUES (
                NULL,
                '$kategori'
            )"
        );

        return Database::getAffectedRows() > 0;
    }

    public function update ($id, $data) {
        $kategori = $data['kategori'];

        $is_kategori_exist = Database::result_set(
            Database::query(
                "SELECT * FROM t_kategori WHERE upper(f_kategori)='".strtoupper($kategori)."' AND f_id != $id"
            )
        );
        
        if ($is_kategori_exist) {
            return false;
        }

        Database::query(
            "UPDATE t_kategori SET f_kategori = '$kategori' WHERE f_id = $id"
        );

        return Database::getAffectedRows() > 0;
    }

    public function delete ($id) {
        Database::query(
            "DELETE FROM t_kategori WHERE f_id = $id"
        );

        if (Database::get_error()) {
            return false;
        }

        return Database::getAffectedRows() > 0;
    }

    public function select(array $fields) {
        $query = "SELECT ";

        for ($i = 0; $i < count($fields); $i++) {
            $query .= $fields[$i]['name'] .($fields[$i]['alias'] ? (' as '.$fields[$i]['alias']) : '');
            if ($i + 1 < count($fields))  {
                $query .= ',';
            }
        }

        $query .= " FROM t_kategori";

        return Database::result_set(
            Database::query(
                $query
            )
        );
    }

    public function getArray ($id) {
        return Database::result_set_array(
            Database::query(
                "SELECT f_kategori FROM t_kategori WHERE f_id = $id"
            )
        );
    }
}