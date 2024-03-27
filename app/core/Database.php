<?php 
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
class Database {
    public static function query ($query) {
        global $conn;
        return mysqli_query($conn, $query);
    }

    public static function result_set ($result) {
        $data = [];
        
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public static function result_set_array ($result) {
        $data = [];

        while ($row = mysqli_fetch_array($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public static function get_error() {
        global $conn;
        return mysqli_error($conn);
    }

    public static function getAffectedRows()
    {
        global $conn;
        return mysqli_affected_rows($conn);
    }
}