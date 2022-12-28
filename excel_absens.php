<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_seo.php";
if (isset($_SESSION[id])) {
  if ($_SESSION['level'] == 'admin') {
    $iden = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users where username='$_SESSION[id]'"));
    $nama =  $iden['nama_lengkap'];
    $level = 'Administrator';
    $foto = 'dist/img/user.png';
  }

  $tgl_mulai = $_GET['tgl_mulai'];
  $tgl_akhir = $_GET['tgl_akhir'];


 


  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=laporan_absen_" . date('dmyHis') . ".xls");
?>
  <?php
  $tgl_mulai = $_GET['tgl_mulai'];
  $tgl_akhir = $_GET['tgl_akhir'];





  $ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
 


  ?>
  <table border="1">

    <h3 align='center'>Rekap Data Absensi TIM </b></h3>

    <h3></h3>
    
    <h4 class='box-title'>Dari Tanggal : <?php echo  tgl_indo($tgl_mulai); ?> Sampai <?php echo   tgl_indo($tgl_akhir); ?>

    </h4>


    <thead>
      <tr>
        <th>No</th>
        <th>Nama TIM</th>
   
        <th>Kode Kehadiran</th>
        <th>Waktu Input</th>
      
        <th>Lokasi</th>
        <th>Keterangan</th>
        <th>Link Foto Selfie</th>

      </tr>
    </thead>
    <tbody>
      <?php

   
          $tampil = mysqli_query($conn, "SELECT nmSiswa,waktu_input,nama,latlng,keterangan,kode_kehadiran FROM rb_absensi_guru 
              INNER JOIN view_detil_siswa ON rb_absensi_guru.nip = view_detil_siswa.username
              where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  ");
          
     

      $no = 1;
      while ($r = mysqli_fetch_array($tampil)) {

        $total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' GROUP BY tanggal"));
        if ($total == 'null') {
          $sw = "<center style='padding:60px; color:red'>Maaf Tidak ada data...</center>";
        } else {

          $hadir = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='H'"));
          $sakit = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='S'"));
          $izin = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='I'"));
          $alpa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='A'"));
          $telat = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='T'"));
          //hitung keseluruhan siswa
          if ($idKelas == 'all') {
            $hadirs = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='H'"));
            $sakits = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='S'"));
            $izins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='I'"));
            $alpas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='A'"));
            $telats = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='T'"));
            $totals = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' and kode_kehadiran!='H' "));
          } else {
            $hadirs = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='H'"));
            $sakits = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='S'"));
            $izins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='I'"));
            $alpas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='A'"));
            $telats = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='T'"));
            $totals = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  and kode_kehadiran!='H' "));
          }
          $tambah = $hadir + $telat;
          $persen = $tambah / ($total) * 100;
          $data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'"));
          if (!file_exists("images/$r[nama]") or $r['nama'] == '') {
            $foto_user = "blank.png";
          } else {
            $foto_user = $r['nama'];
          }
          $page_URL = (@$_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
          $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
          $uri_segments = explode('');
          $link = "$page_URL$_SERVER[HTTP_HOST]/" . $uri_segments[1] . 'images/' . $r['nama'] . '';

          echo "<tr bgcolor=$warna>
                <td align='center'>$no</td>
                <td>$r[nmSiswa]</td>
             
                <td align='center'>$r[kode_kehadiran]</td>
                
                <td>$r[waktu_input]</td>
                <td >" . $r['latlng'] . "</td>
              <td>$r[keterangan]</td>
                <td align=center> $link  </td>
               
               ";
          echo " 
    </tr>
    ";
          $no++;
        }
      }
      echo "</tbody></table> <tr>
<td colspan='1'><b>Keterangan</b></td>

</tr>
<table  border='1'>

<tr>
<td colspan='1'>TIM Izin</td>
<td > $izins</td>
</tr>
<tr>
<td colspan='1'>TIM Sakit</td>
<td > $sakits</td>
</tr>
<tr>
<td colspan='1'>TIM Alpha</td>
<td > $alpas</td>
</tr>
<tr>
<td colspan='1'>TIM Terlambat</td>
<td > $telats</td>
</tr>
<tr>
<td colspan='1'><b>Jumlah Total</b></td>
<td >  $totals</td>
</tr>
";
      echo " ";
      ?>

    </tbody>
  </table>
<?php
} else {
  include "login.php";
}
?>