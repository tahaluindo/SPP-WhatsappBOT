<?php
session_start();
error_reporting(0);
include "../../config/koneksi.php";
include "../../config/fungsi_indotgl.php";
header('Content-Type: application/json');

$idTahunAjaran = $_GET['thnAjaran'];
$ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran where idTahunAjaran='$idTahunAjaran'"));

$data = array();
$sqlBulan = mysqli_query($conn, "SELECT * FROM bulan ORDER BY urutan ASC");
while ($bln = mysqli_fetch_array($sqlBulan)) {
    $data1 = array();

    $bulan = $bln['idBulan'];
    $ta_pisah = explode("/", $ta['nmTahunAjaran']);
    if ($bln['urutan'] <= 6) {
        $tahun = $ta_pisah[1];
    } else {
        $tahun = $ta_pisah[0];
    }
    // Hitung Pemasukan
    $totalKeluar = 0;
    $dBulananMasuk = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalMasuk  FROM tagihan_bulanan 
                                                          WHERE month(tglBayar) = '$bulan' AND year(tglBayar)='$tahun' and statusBayar='1'"));
    $totalKeluar += $dBulananMasuk['totalMasuk'] ;
    $dBebasMasuk = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalMasuk FROM tagihan_bebas_bayar 
                                                      WHERE month(tglBayar) = '$bulan' AND year(tglBayar)='$tahun'"));
    $totalKeluar += $dBebasMasuk['totalMasuk'] ;
    // Hitung Pengeluaran
    $dJurnalKeluar = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(pengeluaran) AS totalKeluar FROM jurnal_umum WHERE month(tgl)='$bulan' AND year(tgl)='$tahun'"));
    $totalKeluar += $dJurnalKeluar['totalKeluar'];
    $totalMasuk = 0;
    $dJurnalMasuk = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(penerimaan) AS totalMasuk FROM jurnal_umums WHERE month(tgl)='$bulan' AND year(tgl)='$tahun'"));
    $totalMasuk += $dJurnalMasuk['totalMasuk'];
    $data1['y'] = getBulan($bln['idBulan']) . ' ' . $tahun;
    $data1['a'] = $totalMasuk;
    $data1['b'] = $totalKeluar;
    $data[] = $data1;
}
echo json_encode($data);
