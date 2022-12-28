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

  $idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas where npsn='10700295'"));





  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=laporan_barang_" . date('dmyHis') . ".xls");
?>
  <h3 align="center">Laporan Jumlah Assets - <?php echo   $idt['nmSekolah']; ?> </h3>
  <table border="1">

    <thead>
      <tr>
        <th>No</th>
        <th>Nama Inventaris</th>
        <th>Jumlah Inventaris</th>
        <th>Total Harga</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $tampil = mysqli_query($conn, "SELECT rb_barang.jumlahBarang,rb_barang.nmBarang,rb_inv_masuk.harga,sum(rb_inv_masuk.harga) as Harga FROM rb_barang 
            inner join rb_inv_masuk on rb_barang.idBarang=rb_inv_masuk.idBarang
            GROUP BY rb_barang.idBarang ASC");
      $no = 1;
      while ($r = mysqli_fetch_array($tampil)) {
        echo "<tr><td>$no</td>
                            
                              <td>$r[nmBarang]</td>
                              <td align='center'>$r[jumlahBarang]</td>
                              <td>" . buatRp($r[Harga]) . "</td>
                             ";
        echo "</tr>";
        $no++;
        $total += $r['Harga'];
      }
      if (isset($_GET[hapus])) {
        mysqli_query($conn, "DELETE FROM rb_barang where idBarang='$_GET[id]'");
        echo "<script>document.location='?view=inventaris';</script>";
      }

      ?>
      <tr>
        <td colspan="3" align="center"><b>Total Assets</b></td>
        <td align="right"><b><?php echo buatRp($total); ?></b></td>
      </tr>
    </tbody>
  </table>
<?php
} else {
  include "login.php";
}
?>