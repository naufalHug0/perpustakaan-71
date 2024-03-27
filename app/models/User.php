<?php 

class User {
    private $table = 't_anggota';

    public function withCredentials($username, $password) {
        return Database::result_set(
            Database::query("SELECT * FROM $this->table WHERE f_username = '$username' AND f_password = '$password'")
        );
    }
}