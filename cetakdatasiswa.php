<?php
error_reporting(0);
session_start();
include 'config/koneksi.php';
include 'config/rupiah.php';
include '../../config/library.php';
include "config/fungsi_indotgl.php";
include 'lib/function.php';
ob_start();
$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas "));
$dBayar = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$_GET[jenisBayar]'")); ?>


<!DOCTYPE html>
<html>

<head>
  <title>Cetak Rekap Data Nasabah</title>
  <link rel="stylesheet" href="bootstrap/css/printer.css">
</head>

<body>
  <table width="100%">
    <tr>
      <td width="100px" align="left"><img src="./gambar/logo/<?php echo $idt['logo_kiri']; ?>" height="60px"></td>
      <td valign="top">
        <h3 align="center" style="margin-bottom:8px ">
          <?php echo $idt['nmSekolah']; ?>
          <center>Laporan Rekap Data Nasabah <br>
            <?php echo $idt['alamat']; ?></center>
        </h3>
      </td>
      <td width="100px" align="right"><img src="./gambar/logo/<?php echo $idt['logo_kanan']; ?>" height="60px"></td>
    </tr>
  </table>

  <table border="1" class="table table-bordered table-striped">

    <tr>
      <th bgcolor="silver" width="50">No</th>
      <th bgcolor="silver">ID Nasabah</th>
      <th bgcolor="silver">No Rekening</th>
      <th bgcolor="silver">Nama</th>
      <th bgcolor="silver">Kelas</th>
      <th bgcolor="silver">Orang Tua</th>
      <th bgcolor="silver">Saldo</th>

    </tr>
    <?php
    $no = 0;
    $query = mysqli_query($conn,"SELECT * FROM siswa  JOIN kelas_siswa ON siswa.idKelas=kelas_siswa.idKelas ORDER BY idSiswa DESC");
    while ($row = mysqli_fetch_array($query)) {
      $no++;
    ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $row['idSiswa']; ?></td>
        <td><?php echo $row['nisnSiswa']; ?></td>
        <td><?php echo $row['nmSiswa']; ?></td>
        <td><?php echo $row['nmKelas']; ?></td>
        <td><?php echo $row['nmOrtu']; ?></td>
        <td>Rp. <?php echo rupiah($row['saldo']); ?></td>


      </tr>
      </tr>






    <?php } ?>
    <table width="100%">
      <tr>
        <td align="center"></td>
        <td align="center" width="400px">
          <?php echo $idt['kabupaten']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?>
          <br />Bendahara,<br /><br /><br /><br />
          <b><u><?php echo $idt['nmBendahara']; ?></u><br /><?php echo $idt['nipBendahara']; ?></b>
        </td>
      </tr>
    </table>
</body>
<script>
  window.print()
</script>

</html>