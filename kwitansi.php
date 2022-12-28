<?php 
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
$tgl_jam=date("Y-m-d h:i:s");
$id_siswa=$_GET[siswa];

$query = mysqli_query($conn,"SELECT max(id_kwitansi) as kodeTerbesar FROM kwitansi");
$data = mysqli_fetch_array($query);
$kode_ID = $data['kodeTerbesar'];

$urutan = (int) substr($kode_ID, 1, 8);
$urutan++;
$kode_ID = sprintf("%08s", $urutan);
$hasil_ID = 'KWT'.$kode_ID;

mysqli_query($conn,"INSERT INTO kwitansi (id_kwitansi,id_siswa,tgl_cetak) VALUES ('$hasil_ID','$id_siswa','$tgl_jam')");

echo "<script>document.location.href='./slip_bulanan_persiswa_peritem_sekarang.php?kwt=$hasil_ID&tahun=$_GET[tahun]&tgl=$_GET[tgl]&siswa=$_GET[siswa]'</script>";


?>