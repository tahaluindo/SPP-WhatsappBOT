<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_seo.php";
if (isset($_SESSION[id])) {
	if ($_SESSION['level'] == 'admin') {
		$iden = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM users where username='$_SESSION[id]'"));
		$nama =  $iden['nama_lengkap'];
		$level = 'Administrator';
		$foto = 'dist/img/user.png';
	}

	$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas where npsn='10700295'"));
	
	

	

	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=laporan_mitra_" . date('dmyHis') . ".xls");
?>
	<table border="1">
	<thead>
  <tr>
              <th>No</th>
              <th>Nama Mitra</th>
              <th>Link Mitra</th>
              <th>Alamat</th>
              <th>Kota</th>
              <th>Provinsi</th>
              <th>Negara</th>
              <th>Nomor</th>
             
            </tr>
          </thead>
          <tbody>
            <?php
            $tampil = mysqli_query($conn,"SELECT * FROM mitra ORDER BY id ASC");
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
              echo "<tr><td>$no</td>
                          
                              <td>$r[nmMitra]</td>
                              <td>$r[linkMitra]</td>
                              <td>$r[alamat]</td>
                              <td>$r[kota]</td>
                              <td>$r[provinsi]</td>
                              <td>$r[negara]</td>
                              <td>'$r[nomor]</td>
                            
                              ";
              echo "</tr>";
              $no++;
            }
            if (isset($_GET[hapus])) {
              mysqli_query($conn,"DELETE FROM mitra where id='$_GET[id]'");
              echo "<script>document.location='?view=mitra';</script>";
            }

            ?>
          </tbody>
        </table>
<?php
} else {
	include "login.php";
}
?>