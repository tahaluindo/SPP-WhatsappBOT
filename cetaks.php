<?php
error_reporting(0);
session_start();
include "config/koneksi.php";
include 'config/rupiah.php';
include '../../config/library.php';
include "config/fungsi_indotgl.php";
include 'lib/function.php';
ob_start();
$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas"));
$dBayar = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$_GET[jenisBayar]'")); ?>

<html>

<head>

  <title>Cetak Laporan</title>
  <link rel="stylesheet" href="bootstrap/css/printer.css">

</head>

<body>

  <!-- laporan transaksi -->
  <?php

  if ($_GET['p'] == '1') {
    $query = mysqli_query($conn,"SELECT * FROM pengaturan LIMIT 1");
    $r = mysqli_fetch_array($query);
    $nama_file = 'lap_transaksi_periode';
    $tanggal1 = $_GET[t1];
    $tanggal2 = $_GET[t2];


    $id1 = ($tanggal1);
    $id2 = ($tanggal2);
    $tgl1 = date('Y-m-d', strtotime($id1));
    $tgl2 = date('Y-m-d', strtotime($id2));

  ?>

    <table width="100%">
      <tr>
        <td width="100px" align="left"><img src="./gambar/logo/<?php echo $idt['logo_kiri']; ?>" height="60px"></td>
        <td valign="top">
          <h3 align="center" style="margin-bottom:8px ">
            <?php echo $idt['nmSekolah']; ?>
            <center>Laporan Rekap Transaksi Periode <br>
              <?php echo $idt['alamat']; ?></center>
          </h3>
        </td>
        <td width="100px" align="right"><img src="./gambar/logo/<?php echo $idt['logo_kanan']; ?>" height="60px"></td>
      </tr>
    </table>

    <div class="divider-dashed"></div>
    <center>
      <p>Tanggal : <?php echo $id1; ?> s.d <?php echo $id2; ?></p>
    </center>

    <br>
    <table border="1" class="table table-bordered table-striped">
      <tr>
        <th bgcolor="silver">Tanggal</th>
        <th bgcolor="silver">No Transaksi</th>

        <th bgcolor="silver">siswa</th>
        <th bgcolor="silver">Debit</th>
        <th bgcolor="silver">Kredit</th>
        <th bgcolor="silver" width="110">Saldo</th>
        <th bgcolor="silver" width="110">Keterangan</th>

      </tr>
      <?php
      $query = "SELECT DATE_FORMAT(transaksi.tanggal, '%Y-%m-%d') as tgl,
                    transaksi.id_transaksi,
                    siswa.nmSiswa,
                    transaksi.debit,
					transaksi.keterangan,
                    transaksi.kredit    
                FROM transaksi JOIN siswa ON transaksi.nisnSiswa=siswa.nisnSiswa WHERE (tanggal BETWEEN '$id1' AND '$id2') order by id_transaksi asc "; // Tampilkan semua data gambar
      $sql = mysql_query($query); // Eksekusi/Jalankan query dari variabel $query
      $row = mysql_num_rows($sql); // Ambil jumlah data dari hasil eksekusi $sql

      if ($row > 0) {
        $count = 2;
        while ($data = mysqli_fetch_array($sql)) { ?>
          <tr>
            <td><?php echo $data['tgl']; ?></td>
            <td><?php echo $data['id_transaksi']; ?></td>
            <td><?php echo $data['nmSiswa']; ?></td>

            <?php if ($count == 1) { ?>

              <td><?php echo "Rp. " . rupiah($data['debit']); ?></td>
              <td><?php echo "Rp. " . rupiah($data['kredit']); ?></td>

              <td>
                <?php
                $debit = $data['debit'];
                $saldo = $data['debit'];
                echo "Rp. " . rupiah($saldo);
                ?>
              </td>

              <?php } else {
              if ($data['debit'] != 0) { ?>
                <td><?php echo "Rp. " . rupiah($data['debit']); ?></td>
                <td><?php echo "Rp. " . rupiah($data['kredit']); ?></td>
                <td>
                <?php
                $debit = $denit + $data['debit'];
                $saldo = $saldo + $data['debit'];
                echo "Rp. " . rupiah($saldo);
              } else { ?>
                <td><?php echo "Rp. " . rupiah($data['debit']); ?></td>
                <td><?php echo "Rp. " . rupiah($data['kredit']); ?></td>

                <td>
              <?php
                $kredit = $kredit + $data['kredit'];
                $saldo = $saldo - $data['kredit'];
                echo "Rp. " . rupiah($saldo);
              }
            }
            $count++
              ?>
                <td><?php echo $data['keterangan']; ?></td>
          </tr>
      <?php
        }
      } else {
        echo "<tr><td colspan='6'>Data tidak ada</td></tr>";
      }
      ?>
    </table>

    <!-- laporan per siswa -->
  <?php } elseif ($_GET['p'] == '2') {
    $nama_file = 'lap_transaksi_siswa';
    $query = mysqli_query($conn,"SELECT * FROM pengaturan LIMIT 1");
    $r2 = mysqli_fetch_array($query);


    $tanggal1 = $_GET[t1];
    $tanggal2 = $_GET[t2];
    $siswa = $_GET[id];

    $id1 = ($tanggal1);
    $id2 = ($tanggal2);
    $id_siswa = ($siswa);
    $tgl1 = date('Y-m-d', strtotime($id1));
    $tgl2 = date('Y-m-d', strtotime($id2));

    $query_rek = mysqli_query($conn,"SELECT * FROM siswa WHERE nisnSiswa='$id_siswa'");
    $r = mysqli_fetch_array($query_rek);

  ?>

    <div class="col-xs-12">
      <table width="100%">
        <tr>

          <td width="100px" align="left"><img src="./gambar/logo/<?php echo $idt['logo_kiri']; ?>" height="60px"></td>
          <td valign="top">
            <h3 align="center" style="margin-bottom:8px ">
              <?php echo $idt['nmSekolah']; ?>
              <center>Laporan Transaksi siswa <br>
                <?php echo $idt['alamat']; ?>
            </h3>
            </center>
          </td>
          <td width="100px" align="right"><img src="./gambar/logo/<?php echo $idt['logo_kanan']; ?>" height="60px"></td>
        </tr>
      </table>
      <br>
      <div class="divider-dashed"></div>
      <center>
        <p>Tanggal : <?php echo $id1; ?> s.d <?php echo $id2; ?></p>
        <p><b><?php echo $r['nmSiswa']; ?></b> <i> ( <?php echo $r['nisnSiswa']; ?> )</i></p>
      </center>

      <br>
      <table border="1" class="table table-bordered table-striped">
        <tr>
          <th bgcolor="silver">Tanggal</th>
          <th bgcolor="silver">No Transaksi</th>

          <th bgcolor="silver">Debit</th>
          <th bgcolor="silver">Kredit</th>
          <th bgcolor="silver" width="110">Saldo</th>
          <th bgcolor="silver" width="110">Keterangan</th>

        </tr>
        <?php

        $query = "SELECT DATE_FORMAT(transaksi.tanggal, '%d-%m-%Y') as tgl,
                    transaksi.id_transaksi,
                    siswa.nmSiswa,
                    transaksi.debit,
					transaksi.keterangan,
                    transaksi.kredit    
                FROM transaksi JOIN siswa ON transaksi.nisnSiswa=siswa.nisnSiswa WHERE (tanggal BETWEEN '$id1' AND '$id2') AND transaksi.nisnSiswa ='$id_siswa' order by id_transaksi asc "; // Tampilkan semua data gambar
        $sql = mysql_query($query); // Eksekusi/Jalankan query dari variabel $query
        $row = mysql_num_rows($sql); // Ambil jumlah data dari hasil eksekusi $sql

        if ($row > 0) {
          $count = 2;
          while ($data = mysqli_fetch_array($sql)) { ?>

            <tr>
              <td><?php echo $data['tgl']; ?></td>
              <td><?php echo $data['id_transaksi']; ?></td>

              <?php if ($count == 1) { ?>

                <td><?php echo "Rp. " . rupiah($data['debit']); ?></td>
                <td><?php echo "Rp. " . rupiah($data['kredit']); ?></td>

                <td>
                  <?php
                  $debit = $data['debit'];
                  $saldo = $data['debit'];
                  echo "Rp. " . rupiah($saldo);
                  ?>
                </td>

                <?php } else {
                if ($data['debit'] != 0) { ?>
                  <td><?php echo "Rp. " . rupiah($data['debit']); ?></td>
                  <td><?php echo "Rp. " . rupiah($data['kredit']); ?></td>
                  <td>
                  <?php
                  $debit = $denit + $data['debit'];
                  $saldo = $saldo + $data['debit'];
                  echo "Rp. " . rupiah($saldo);
                } else { ?>
                  <td><?php echo "Rp. " . rupiah($data['debit']); ?></td>
                  <td><?php echo "Rp. " . rupiah($data['kredit']); ?></td>

                  <td>
                <?php
                  $kredit = $kredit + $data['kredit'];
                  $saldo = $saldo - $data['kredit'];
                  echo "Rp. " . rupiah($saldo);
                }
              }
              $count++
                ?>
                  <td><?php echo $data['keterangan']; ?></td>
            </tr>
        <?php }
        } else {
          echo "<tr><td colspan='6'>Data tidak ada</td></tr>";
        }
        ?>
      </table>
    <?php } elseif ($_GET['p'] == '3') {
    $kelas = $_GET[k];
    $id = ($kelas);

    $query_rek = mysqli_query($conn,"SELECT * FROM siswa WHERE idKelas='$id'");
    if (mysql_num_rows($query_rek) == 0) {
      $query_rek = mysqli_query($conn,"SELECT * FROM siswa");
    }

    while ($r = mysqli_fetch_array($query_rek)) {;
      echo $r[nama];
    }
    ?>

      <?php

      ?>

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