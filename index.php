<?php
    error_reporting(0);

    function wtnntw ($p1, $rev) { 
        //Word to Number, Number to Word
        //Fungsi ini hanya handle sampai 20 saja

        $angka = array(
            0 => "nol", 
            1 => "satu", 
            2 => "dua", 
            3 => "tiga", 
            4 => "empat", 
            5 => "lima", 
            6 => "enam", 
            7 => "tujuh", 
            8 => "delapan",
            9 => "sembilan",
            10 => "sepuluh",
            11 => "sebelas"
        );
        
        //pake foreach, biar bisa bolak balik arraynya, bisa handle key dan value juga
        foreach ($angka as $key => $value) {
            $angkax[$key] = $value;
            $angkay[$value] = $key;
        }

        if ($rev == "wtn") { //handle Word to Number
            //apakah satu atau dua kata 
            //satu kata -> nol s/d sebelas
            //dua kata -> dua belas s/d dua puluh
            $p1x = explode(" ", strtolower($p1));

            if ($p1x[1] == "belas") {
                return "1".$angkay[$p1x[0]];
            } elseif ($p1x[1] == "puluh") {
                return $angkay[$p1x[0]]."0";
            } elseif ($p1x[1] == "") {
                return $angkay[$p1x[0]];
            }
        } else { //handle Number to Word -> sampai angka 400, 20*20
            if ($p1 < 12) { //handle angka dibawah sebelas
                return $angkax[$p1];
            } elseif ($p1 < 20) { //handle angka dibawah 20
                //dikurang 10, misal angka adalah 15, utk mendapat 5 = 15-10
                return $angkax[$p1 - 10]." belas";
            } elseif ($p1 < 100) {
                //dibagi 10, misal angka adalah 21, utk mendapat 2 = 21/10 -> hasil bagi
                //dimod 10, misal angka adalah 21, utk mendapat 1 = 21%10 -> sisa bagi
                //ada str_replace karena bisa handle "nol"
                return $angkax[$p1 / 10]." puluh ".str_replace("nol", "", $angkax[$p1 % 10]);
            } elseif ($p1 < 200) {
                //dikurang 100, misal angka adalah 103, utk mendapat 3 = 103-100
                //ada str_replace karena bisa handle "nol"
                //panggil fungsi wtnntw supaya tidak perlu jalankan routine 0-99
                return "seratus ".str_replace("nol", "", wtnntw($p1 - 100));
            } elseif ($p1 < 1000) {
                //dibagi 100, misal angka adalah 205, utk mendapat 2 = 205/100 -> hasil bagi
                //dimod 100, misal angka adalah 205, utk mendapat 5 = 205%100 -> sisa bagi
                //ada str_replace karena bisa handle "nol"
                //panggil fungsi wtnntw supaya tidak perlu jalankan routine 0-99
                return $angkax[$p1 / 100]." ratus ".str_replace("nol", "", wtnntw($p1 % 100));
            }
        }
    }

    //simple interfaces
    echo "
        <center>
        <h1>Words Arithmetic</h1>
        <form method='POST'>
            <input type='text' name='tulisan'>
            <input type='submit' value='proses'>
        </form>
    ";
    
    $tulisan = $_POST["tulisan"];
    $tulisan = strtolower($tulisan);

    $tambah = strpos($tulisan, "tambah");
    $tambahx = explode(" tambah ", $tulisan);

    $kurang = strpos($tulisan, "kurang");
    $kurangx = explode(" kurang ", $tulisan);

    $kali   = strpos($tulisan, "kali");
    $kalix = explode(" kali ", $tulisan);

    if ($tambah == true) {
        $angka1 = wtnntw($tambahx[0], "wtn");
        $angka2 = wtnntw($tambahx[1], "wtn");
        $hasil = $angka1 + $angka2;
        echo $tulisan." sama dengan ".wtnntw($hasil);
    } elseif ($kurang == true) {
        $angka1 = wtnntw($kurangx[0], "wtn");
        $angka2 = wtnntw($kurangx[1], "wtn");
        $hasil = $angka1 - $angka2;
        echo $tulisan." sama dengan ".wtnntw($hasil);
    } elseif ($kali == true) {
        $angka1 = wtnntw($kalix[0], "wtn");
        $angka2 = wtnntw($kalix[1], "wtn");
        $hasil = $angka1 * $angka2;
        echo $tulisan." sama dengan ".wtnntw($hasil);
    }
?>
