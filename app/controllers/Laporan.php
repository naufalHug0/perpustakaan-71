<?php 

class Laporan extends Controller {
    public static function all () {
        return [
            'most_rent' => self::model('Peminjaman_Model')->mostRent(),
            'book_return' => self::model('Peminjaman_Model')->bookReturn(),
            'members_with_unreturned_books' => self::model('Peminjaman_Model')->membersWithUnreturnedBooks(),
            'members_with_most_rent_books' => self::model('Peminjaman_Model')->membersWithMostRentBooks(),
        ];
    }
}