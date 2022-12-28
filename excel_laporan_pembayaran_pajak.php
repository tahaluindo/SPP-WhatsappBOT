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

	$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas "));
	$ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
	$dBayar = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM jenis_penerimaan WHERE idPenerimaan='$_GET[jenisBayar]'"));

	$tahun = $_GET['tahun'];
	$jenis = $_GET['jenisBayar'];
	$bulan = $_GET['bulan'];

	if ($_GET['bulan'] == 'all') {
		$buland = 'Semua Bulan';

		$sqlTagihanBebas = mysqli_query($conn, "SELECT
								jurnal_umums.*,
								jenis_penerimaan.idPenerimaan,
								jenis_penerimaan.nmPenerimaan,
								jurnal_umums.penerimaan,
								jurnal_umums.ket
						
							FROM
							jurnal_umums
							INNER JOIN jenis_penerimaan ON jurnal_umums.idPenerimaan = jenis_penerimaan.idPenerimaan
								WHERE jurnal_umums.idPenerimaan='$jenis' and year(jurnal_umums.tgl)='$tahun' ORDER BY jurnal_umums.idPenerimaan ASC");
	} else {
		$bulans = mysqli_fetch_array(mysqli_query($conn, " SELECT * FROM bulan where idBulan='$_GET[bulan]'"));
		$buland = $bulans['nmBulan'];
		$sqlTagihanBebas = mysqli_query($conn, "SELECT
								jurnal_umums.*,
								jenis_penerimaan.idPenerimaan,
								jenis_penerimaan.nmPenerimaan,
								jurnal_umums.penerimaan,
								jurnal_umums.ket
						
							FROM
							jurnal_umums
							INNER JOIN jenis_penerimaan ON jurnal_umums.idPenerimaan = jenis_penerimaan.idPenerimaan
								WHERE jurnal_umums.idPenerimaan='$jenis' and year(jurnal_umums.tgl)='$tahun' and month(jurnal_umums.tgl)='$bulan' ORDER BY jurnal_umums.idPenerimaan ASC");
	}
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=laporan_pajak_" . str_replace(" ", "_", $kls['nmKelas']) . "_" . date('dmyHis') . ".xls");
?>
	<h3 align="center">Laporan Pajak Penerimaan <?php echo $dBayar['nmPenerimaan']; ?></h3>
	<h4>Bulan: <?php echo $buland; ?> - Tahun: <?php echo $tahun; ?></h4>
	<table border="1">
		<thead class="thead">
			<tr>
				<th>No.</th>

				<th>Nama Jenis Penerimaan</th>
				<th>Total Bayar</th>
				<th>Pajak 0.5%</th>

			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			while ($rtb = mysqli_fetch_array($sqlTagihanBebas)) {

				$ppn = $rtb['penerimaan'] * 0.5 / 100;
				echo "<tr>
								<td>$no</td>
								<td>$rtb[ket]</td>
								<td>" . buatRp($rtb['penerimaan']) . "</td>
								
								<td>" . buatRp($ppn) . "</td>
							
							</tr>";
				$no++;
				$totDibayar += $rtb['penerimaan'];
				$pajak += $ppn;
			}
			?>
			<tr>
				<td colspan="2">Jumlah Pembayaran</td>
				<td><b><?php echo buatRp($totDibayar); ?></b></td>
				<td><b><?php echo buatRp($pajak); ?></b></td>
			</tr>
		</tbody>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>
	<br />
	<table width="100%">
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td align="right" width="40%">
				<center><?php echo $idt['kabupaten']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?>
					<br />Finance,<br />
					<?= $lokasi_ttd_ketua ?>
					<br>

					<b><u>Rivani Noer Maulidi</u></b>
				</center>
				<br>
				<?= $npm_ketua ?>
			</td>

		</tr>
	</table>
<?php
} else {
	include "login.php";
}
?>