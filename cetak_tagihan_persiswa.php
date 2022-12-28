<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/fungsi_indotgl.php";
include "config/library.php";

$ta = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
$idTahun = $ta['idTahunAjaran'];
$tahun = $ta['nmTahunAjaran'];

$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas where npsn='10700295'"));
$pos = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar where idPosBayar='$_GET[pos]'"));

$idsiswa = $_GET['siswa'];
$dtsiswa = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM view_detil_siswa where idSiswa='$_GET[siswa]'"));
$nissiswa = $dtsiswa['nisSiswa'];
$namasiswa = $dtsiswa['nmSiswa'];
$namakelas = $dtsiswa['nmKelas'];
?>
<!DOCTYPE html>
<html>

<head>
	<title>Cetak - Laporan Tagihan Siswa</title>
	<link rel="stylesheet" href="bootstrap/css/printer.css">
</head>

<body>
	<table width="100%">
		<tr>
			<td width="100px" align="left"><img src="./gambar/logo/<?php echo $idt['logo_kiri']; ?>" height="60px"></td>
			<td valign="top">
				<h3 align="center" style="margin-bottom:8px ">
					<?php echo $idt['nmSekolah']; ?>
				</h3>
				<center><?php echo $idt['alamat']; ?></center>
			</td>
			<td width="100px" align="right"><img src="./gambar/logo/<?php echo $idt['logo_kanan']; ?>" height="60px"></td>
		</tr>
	</table>
	<hr />
	<table width="100%">
		<tr>
			<td width="200px">NIS </td>
			<td width="10px">:</td>
			<td> <?php echo $nissiswa; ?></td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td> <?php echo $namasiswa; ?></td>
		</tr>
		<tr>
			<td>Kelas </td>
			<td>:</td>
			<td> <?php echo $namakelas; ?></td>
		</tr>
		<tr>
			<td>Tahun Pelajaran</td>
			<td>:</td>
			<td> <?php echo $tahun; ?></td>
		</tr>
	</table>
	<br>
	<table border="1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No.</th>
				<th>Pos Pembayaran</th>
				<th>Jenis Pembayaran</th>
				<th>Tagihan</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$totDibayar = 0;
			$totTagihan = 0;
			$sqlJenisBayar = mysqli_query($conn,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar 
				FROM jenis_bayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
 				WHERE jenis_bayar.idTahunAjaran='$idTahun'");
			while ($djb = mysqli_fetch_array($sqlJenisBayar)) {
				if ($djb['tipeBayar'] == 'bulanan') {
					//menghitung semua tagihan bulanan
					$tgbul 	=	mysqli_fetch_array(mysqli_query($conn,"SELECT
						jenis_bayar.idPosBayar,
						pos_bayar.nmPosBayar,
						tagihan_bulanan.idSiswa,
						Sum(tagihan_bulanan.jumlahBayar) AS TotalSemuaTagihanBulanan
						FROM
						tagihan_bulanan
						INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
						INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
						WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bulanan.idSiswa='$idsiswa'
						GROUP BY
						jenis_bayar.idPosBayar"));
					$semuaTagihan = $tgbul['TotalSemuaTagihanBulanan'];

					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
						jenis_bayar.idPosBayar,
						pos_bayar.nmPosBayar,
						jenis_bayar.idTahunAjaran,
						tahun_ajaran.nmTahunAjaran,
						jenis_bayar.nmJenisBayar,
						Sum(tagihan_bulanan.jumlahBayar) AS TotalPembayaranPerJenis,
						tagihan_bulanan.statusBayar
						FROM
						tagihan_bulanan
						INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
						INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
						INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
						WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.idSiswa='$idsiswa'
						GROUP BY
						tagihan_bulanan.idJenisBayar"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];
					$tagihan 	= $semuaTagihan - $jBayar;
				} else {
					//menghitung semua tagihan bebas
					$tgb 	= 	mysqli_fetch_array(mysqli_query($conn,"SELECT
							tagihan_bebas.idTagihanBebas,
							jenis_bayar.idPosBayar,
							pos_bayar.nmPosBayar,
							tagihan_bebas.idSiswa,
							SUM(tagihan_bebas.totalTagihan) As TotalSemuaTagihanBebas
							FROM
							tagihan_bebas
							INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
							INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
							WHERE tagihan_bebas.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bebas.idSiswa='$idsiswa'
							GROUP BY
							jenis_bayar.idPosBayar"));
					$semuaTagihan = $tgb['TotalSemuaTagihanBebas'];

					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
						tagihan_bebas.idJenisBayar,
						jenis_bayar.nmJenisBayar,
						jenis_bayar.idTahunAjaran,
						tahun_ajaran.nmTahunAjaran,
						tagihan_bebas_bayar.idTagihanBebas,
						Sum(tagihan_bebas_bayar.jumlahBayar) AS TotalPembayaranPerJenis,
						tagihan_bebas_bayar.ketBayar
						FROM
						tagihan_bebas_bayar
						INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
						INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
						INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
						WHERE tagihan_bebas_bayar.idTagihanBebas='$tgb[idTagihanBebas]'
						GROUP BY
						tagihan_bebas_bayar.idTagihanBebas"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];
					$tagihan 	= $semuaTagihan - $jBayar;
				}
				echo "<tr>
				<td align='center'>$no</td>
				<td>$djb[nmPosBayar]</td>
				<td>$djb[nmJenisBayar]</td>
				<td align='right'>" . buatRp($tagihan) . "</td>
			</tr>";
				$no++;
				$totDibayar += $jBayar;
				$totTagihan += $tagihan;
			}
			?>
			<tr>
				<td colspan="3"><b>Total Tagihan</b></td>
				<td align="right"><b><?php echo buatRp($totTagihan); ?></b></td>
			</tr>
		</tbody>
	</table>

	<br />
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