<?php
error_reporting(0);
include "../config/koneksi.php";
include "../config/rupiah.php";

$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));
$link = $idt['link_one_sender'];
$links = $idt['token'];
$wa = $idt['wa'];
//url tagihan
$page_URL = (@$_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $uri_segments = explode('');
//tahun ajaran
$t = mysqli_query($conn, "SELECT idTahunAjaran as ta FROM tahun_ajaran WHERE aktif = 'Y'");
$ta = mysqli_fetch_array($t);
$thn_ajar = $ta['ta'];

//$headers = array();
//$headers[] =  $idt[token];
//$headers[] = 'Content-Type: application/x-www-form-urlencoded';

if (isset($_POST['simpan_bulanan'])) {
    $tglBayar = date("Y-m-d H:i:s");
    $tgl = date('Y-m-d');
    $caraBayar = $_POST['caraBayar'];
    $jumlahBayar = $_POST['jumlah_bayar'];
    $query = mysqli_query($conn, "UPDATE tagihan_bulanan SET  tglBayar='$tglBayar', tglUpdate='$_POST[tanggal_bayar]', statusBayar='1' , caraBayar='$caraBayar' WHERE idTagihanBulanan='$_POST[id_tagihan_bulanan]'");
    $a = mysqli_query($conn, "SELECT nmBulan as Bulan,tagihan_bulanan.idSiswa as ids,siswa.idKelas as kelas, nmSiswa as nama,nmOrtu as atasnama, noHp as hpo,noHpOrtu as norek,noHpSis as nmBank, jumlahBayar as tagihan FROM siswa 
						 INNER JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa 
						 INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan         
						 WHERE idTagihanBulanan='$_POST[id_tagihan_bulanan]'         
                   		");
    $query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
    $saldo = mysqli_fetch_array($query_saldo);
    $saldoo =  $saldo['saldo'] - $jumlahBayar;
    mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
                            WHERE id = '$caraBayar'  ");
    $re = mysqli_fetch_array($a);
    $sis = $re['ids'];
    $kelas = $re['kelas'];
    $tagihan = $re['tagihan'];
    $siswa = $re['nama'];
    $hpo = $re['hpo'];
    $bank = $re['nmBank'];
    $norek = $re['norek'];
    $atasnama = $re['atasnama'];
    $bulan = $re['Bulan'];
    $link_url_tagihan = "$page_URL$_SERVER[HTTP_HOST]/" . $uri_segments[1] . 'kwitansi.php?tahun=' . $thn_ajar . '&kelas=' . $kelas . '&tgl=' . $tgl . '&siswa=' . $sis;


    $msg_par = '*Haii....* *' . $siswa . '*,Yeeeay ada transferan lagi nih ke:

Bank: *' . $bank . '*
Nomor Rekening: *' . $norek . '*
An: *' . $atasnama . '*
Bulan: *' . $bulan . '* 
Jumlah:  *Rp.' . rupiah($tagihan) . '*

Yuk cek saldo rekeningmu :) Terima kasih....

Download Slip Gajimu di: 
' . $link_url_tagihan . '

*Finance*,
*PT. Juragan Karya Digital Teknologi*';


    // par
    $phone = $hpo;
    $data = [
        "api_key" => $links,
        "sender" => $wa,
        "number" => $phone,
        "message" => $msg_par
    ];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $idt['link_wa'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $msg_par . '<br>';
    var_dump($response);
    echo '<br>';

    //kid


    header('Location: ../index.php?view=pembayaran&siswa=' . $_POST['siswa'] . '&cari=Cari Siswa');
} else {
    header('Location: ../index.php?view=pembayaran');
}
