<?php 

class Utils {
    public static function navigateTo ($target) {
        header("Location: $target");
        exit;
    }

    public static function directToRole ($role) {
        $path = "/perpustakaan/app/views/$role";
        self::navigateTo($path);
    }

    public static function reloadPage ($params = null) {
        if ($params) {
            $params = '?'.$params;
        }
        self::navigateTo($_SERVER['PHP_SELF'].$params);
    }

    public static function getUserRole () {
        return $_SESSION['u_rl'];
    }

    public static function destroySession () {
        session_unset();
        session_destroy();
    }

    public static function get_month ($month) {
        switch ($month) {
            case "01":
                return "Jan";
            case "02":
                return "Feb";
            case "03":
                return "Mar";
            case "04":
                return "Apr";
            case "05":
                return "May";
            case "06":
                return "Jun";
            case "07":
                return "Jul";
            case "08":
                return "Aug";
            case "09":
                return "Sept";
            case "10":
                return "Oct";
            case "11":
                return "Nov";
            case "12":
                return "Dec";
            default:
            return "Invalid Month";
        }
    }
    
    public static function format_date ($date) {
        $date = explode('-', $date);
        return $date[2] . ' ' . self::get_month($date[1]) . ' ' . $date[0];
    }
    
    public static function createTable ($data,$type = null) {
        global $EXPORT_TABLE_COLUMNS;
        require_once '../library/fpdf/fpdf.php';
    
        $columns = null;
        $title = null;
        
        $pdf=new FPDF('P','mm','A3');
        $pdf->AddPage();
    
        if (self::getUserRole() == 'anggota') {
            $columns = $EXPORT_TABLE_COLUMNS['peminjaman'];
            $title = 'Peminjaman';
            $type = 'anggota';
        } else {
            switch ($type) {
                case 'most_rent':
                    $columns = $EXPORT_TABLE_COLUMNS['laporan']['most_rent'];
                    $title = 'Buku dengan Peminjaman Terbanyak';
                    break;
                case 'unreturned_book':
                    $columns = $EXPORT_TABLE_COLUMNS['laporan']['unreturned_book'];
                    $title = 'Buku yang Belum dikembalikan';
                    break;
                case 'unreturned_books_member':
                    $columns = $EXPORT_TABLE_COLUMNS['laporan']['unreturned_books_member'];
                    $title = 'Anggota yang Belum Mengembalikan Buku';
                    break;
                case 'most_rent_member':
                    $columns = $EXPORT_TABLE_COLUMNS['laporan']['most_rent_member'];
                    $title = 'Anggota yang Sering Meminjam Buku';
                    break;
            }
        }
    
        if ($columns == null) {
            self::directToRole(self::getUserRole());
        }
    
        $pdf->SetFont('Times','B',13);
        $pdf->Cell(200,10,$title,0,0,'C');
    
        $pdf->Cell(10,15,'',0,1);
        $pdf->SetFont('Times','B',9);
        $pdf->Cell(8,7,'No',1,0,'C');
    
        foreach ($columns as $c) {
            $pdf->Cell($c['width'],7,$c['title'],1,0,'C');
        }
    
        $pdf->Cell(10,7,'',0,1);
        $pdf->SetFont('Times','',8);
    
    
        $num = 1;
        foreach($data as $value){
            $pdf->Cell(8, 7, $num, 1, 0,'C');
            self::setRowData($type, $pdf, $value, $columns);
            $num++;
        }
    
        ob_end_clean();
        $pdf->Output();
    }
    
    public static function setRowData ($type, $pdf, $data, $col) {
        switch ($type) {
            case 'most_rent':
                $pdf->Cell($col[0]['width'], 7, $data['judul'], 1, 1,'C');
                break;
            case 'unreturned_book':
                $pdf->Cell($col[0]['width'], 7, $data['judul'], 1, 0,'C');
                $pdf->Cell($col[1]['width'], 7, $data['pengarang'], 1, 0,'C');
                $pdf->Cell($col[2]['width'], 7, $data['penerbit'], 1, 0,'C');
                $pdf->Cell($col[3]['width'], 7, $data['stok'], 1, 1,'C');
                break;
            case 'unreturned_books_member':
                $pdf->Cell($col[0]['width'], 7, $data['nama'], 1, 0,'C');
                $pdf->Cell($col[1]['width'], 7, $data['total_book'], 1, 1,'C');
                break;
            case 'most_rent_member':
                $pdf->Cell($col[0]['width'], 7, $data['nama'], 1, 0,'C');
                $pdf->Cell($col[1]['width'], 7, $data['total_book'], 1, 1,'C');
                break;
            case 'anggota':
                $pdf->Cell($col[0]['width'], 7, $data['judul'], 1, 0,'C');
                $pdf->Cell($col[1]['width'], 7, $data['kategori'], 1, 0,'C');
                $pdf->Cell($col[2]['width'], 7, $data['nama_admin'], 1, 0,'C');
                $pdf->Cell($col[3]['width'], 7, $data['nama_anggota'], 1, 0,'C');
                $pdf->Cell($col[4]['width'], 7, $data['f_tanggalpeminjaman'], 1, 0,'C');
                $pdf->Cell($col[5]['width'], 7, $data['f_tanggalkembali'] == null ? '-':$data['f_tanggalkembali'], 1, 0,'C');
                $pdf->Cell($col[6]['width'], 7, $data['f_tanggalkembali'] == null ? 'Belum Kembali':'Sudah Kembali', 1, 1,'C');
                break;
        }
    }
}