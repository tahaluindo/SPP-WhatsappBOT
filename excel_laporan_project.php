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
	header("Content-Disposition: attachment; filename=laporan_project_" . date('dmyHis') . ".xls");
?>
	<table border="1">
	<thead>
            <tr>
              <th>No</th>
             
              <th>Nama</th>
              <th>Nilai Project</th>
             
             
            </tr>
          </thead>
		  <tbody>
            <?php
            $tampil = mysqli_query($conn, "SELECT *
           
            FROM project 
            
            ORDER BY idProject ASC");
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
              echo "<tr><td>$no</td>
                             
                              <td>$r[nmProject]</td>
                              <td>" . buatRp($r['nilai']) . "</td>
                            
                              ";
              echo "</tr>";
              $no++;
            }
           

            ?>
            
          </tbody>
	</table>
<?php
} else {
	include "login.php";
}
?>