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

	$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));
	$dBayar = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM jenis_pengeluaran WHERE idPengeluaran='$_GET[jenisPengeluaran]'"));
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=laporan_pengeluaran_" . date('dmyHis') . ".xls");
?>


	<?php
	$tgl1 = $_GET['tgl1'];
	$jenis = $_GET['jenisPengeluaran'];
	$tgl2 = $_GET['tgl2'];
	?>


	<h3 align="center">Laporan Pengeluaran - <?php echo 	$dBayar['nmPengeluaran']; ?> </h3>
	<h4>Dari tanggal: <?php echo tgl_indo($tgl1); ?> - Sampai dengan: <?php echo tgl_indo($tgl2); ?></h4>
	<table border="1">
		<thead class="thead">
			<tr>
				<th width="40px">No.</th>
				<th>Tanggal</th>
				<th>Uraian (Keterangan)</th>
				<th>Pengeluaran</th>
			</tr>
		</thead>
		<tbody>


			<?php
			if ($_GET['jenisPengeluaran'] == 'all') {
				$no = 1;
				$total = 0;
				$sqlJU = mysqli_query($conn, "SELECT * FROM jurnal_umum WHERE pengeluaran!=0 AND DATE(tgl) BETWEEN '$tgl1' AND '$tgl2'  ORDER BY tgl ASC");
				while ($d = mysqli_fetch_array($sqlJU)) {
					echo "<tr>
							<td align='center'>$no</td>
							<td align='left'>" . tgl_raport($d['tgl']) . "</td>
							<td>$d[ket]</td>
							<td align='right'>" . buatRp($d['pengeluaran']) . "</td>
						</tr>";
					$no++;
					$total += $d['pengeluaran'];
				}
			} else {
				$no = 1;
				$total = 0;
				$sqlJU = mysqli_query($conn, "SELECT * FROM jurnal_umum WHERE pengeluaran!=0 AND DATE(tgl) BETWEEN '$tgl1' AND '$tgl2' and idPengeluaran='$jenis' ORDER BY tgl ASC");
				while ($d = mysqli_fetch_array($sqlJU)) {
					echo "<tr>
								<td align='center'>$no</td>
								<td align='left'>" . tgl_raport($d['tgl']) . "</td>
								<td>$d[ket]</td>
								<td align='right'>" . buatRp($d['pengeluaran']) . "</td>
							</tr>";
					$no++;
					$total += $d['pengeluaran'];
				}
			}


			?>
			<?php
			if ($_GET['jenisPengeluaran'] == 'all') {
				$dPJU = mysqli_fetch_array(mysqli_query($conn, "SELECT  SUM(pengeluaran) AS totalKeluar FROM jurnal_umum where DATE(tgl) BETWEEN '$tgl1' AND '$tgl2' "));

				$totalPengeluaran = $dPJU['totalKeluar'];
			} else {
				$dPJU = mysqli_fetch_array(mysqli_query($conn, "SELECT  SUM(pengeluaran) AS totalKeluar FROM jurnal_umum where DATE(tgl) BETWEEN '$tgl1' AND '$tgl2' and idPengeluaran='$jenis'"));

				$totalPengeluaran = $dPJU['totalKeluar'];
			}




			$totsd = $totalPengeluaran;
			?>
			<tr>
				<td colspan="3" align="center"><b>Total Pengeluaran</b></td>
				<td align="right"><b><?php echo buatRp($totsd); ?></b></td>
			</tr>
		</tbody>
	</table>

	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>
	<br />
	<table width="100%">
		<tr>
			<td align="center"></td>
			<td align="center" width="400px">
				<?php echo $idt['kabupaten']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?>
				<br />Finance,<br /><br /><br /><br />
				<b><u><?php echo $idt['nmBendahara']; ?></u></b>
			</td>
		</tr>
	</table>


<?php
} else {
	include "login.php";
}
?>