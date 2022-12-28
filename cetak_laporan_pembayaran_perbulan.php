<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/fungsi_indotgl.php";
include "config/library.php";

$ta = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tahun_ajaran where aktif='Y'"));
$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas "));
$sqlJenisBayar = mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idTahunAjaran='$ta[idTahunAjaran]' ORDER BY tipeBayar ASC");
$kls = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM kelas_siswa where idKelas='$_GET[kelas]'"));

$tgl1 = $_GET['tgl1'];
$tgl2 = $_GET['tgl2'];
?>
<!DOCTYPE html>
<html>

<head>
	<title>Cetak - Laporan Pembayaran Per Bulan</title>
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
	<hr>
	<h3 align="center">LAPORAN PEMBAYARAN</h3>
	<hr />
	<h3 class="box-title">KELAS : <?php echo $kls['nmKelas']; ?></h3>
	<hr />
	<?php
	while ($dj = mysqli_fetch_array($sqlJenisBayar)) {
		echo "<h3>$dj[nmJenisBayar]</h3>";
		if ($dj['tipeBayar'] == 'bulanan') {
			$sqlB = mysqli_query($conn,"SELECT
					tagihan_bulanan.idTagihanBulanan,
					tagihan_bulanan.idJenisBayar,
					tagihan_bulanan.idSiswa,
					tagihan_bulanan.idKelas,
					tagihan_bulanan.idBulan,
					tagihan_bulanan.jumlahBayar,
					DATE(tagihan_bulanan.tglBayar) as tglBayar,
					tagihan_bulanan.tglUpdate,
					tagihan_bulanan.statusBayar,
					jenis_bayar.idTahunAjaran,
					jenis_bayar.nmJenisBayar,
					tahun_ajaran.nmTahunAjaran,
					siswa.nisSiswa,
					siswa.nmSiswa,
					bulan.nmBulan AS ket,
					bulan.urutan,
					kelas_siswa.nmKelas
					FROM
					tagihan_bulanan
				INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
				INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
				INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
				INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
				INNER JOIN kelas_siswa ON tagihan_bulanan.idKelas = kelas_siswa.idKelas 
				WHERE tagihan_bulanan.idJenisBayar='$dj[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.idKelas='$_GET[kelas]' AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$tgl1' AND '$tgl2') ORDER BY tagihan_bulanan.tglBayar ASC");
			$tot = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totBayar FROM tagihan_bulanan WHERE tagihan_bulanan.idJenisBayar='$dj[idJenisBayar]' AND statusBayar='1' AND idKelas='$_GET[kelas]' AND (DATE(tglBayar) BETWEEN '$tgl1' AND '$tgl2')"));
		} else {
			$sqlB = mysqli_query($conn,"SELECT
					tagihan_bebas_bayar.idTagihanBebasBayar,
					tagihan_bebas_bayar.idTagihanBebas,
					tagihan_bebas_bayar.tglBayar,
					tagihan_bebas_bayar.jumlahBayar,
					tagihan_bebas_bayar.ketBayar AS ket,
					tagihan_bebas.idJenisBayar,
					tagihan_bebas.idSiswa,
					tagihan_bebas.idKelas,
					tagihan_bebas.totalTagihan,
					tagihan_bebas.statusBayar,
					siswa.nisSiswa,
					siswa.nmSiswa,
					kelas_siswa.nmKelas
				FROM
					tagihan_bebas_bayar
				INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
				INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
				INNER JOIN kelas_siswa ON tagihan_bebas.idKelas = kelas_siswa.idKelas
				WHERE tagihan_bebas.idJenisBayar='$dj[idJenisBayar]' AND tagihan_bebas.statusBayar<>'0' AND tagihan_bebas.idKelas='$_GET[kelas]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl1' AND '$tgl2') ORDER BY tagihan_bebas_bayar.tglBayar ASC");
			$tot = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totBayar
				FROM tagihan_bebas_bayar
				INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas 
				WHERE tagihan_bebas.idJenisBayar='$dj[idJenisBayar]' AND tagihan_bebas.statusBayar<>'0' AND tagihan_bebas.idKelas='$_GET[kelas]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl1' AND '$tgl2')"));
		}
	?>
		<table border="1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No.</th>
					<th>NIS</th>
					<th>Nama Siswa</th>
					<th>Nominal Bayar</th>
					<th>Tgl Bayar</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				while ($dtb = mysqli_fetch_array($sqlB)) {
					echo "<tr>
					<td align='center'>$no</td>
					<td align='center'>$dtb[nisSiswa]</td>
					<td>$dtb[nmSiswa]</td>
					<td align='right'>" . buatRp($dtb['jumlahBayar']) . "</td>
					<td align='center'>" . tgl_indo($dtb['tglBayar']) . "</td>
					<td align='center'>$dtb[ket]</td>
				</tr>";
					$no++;
				}
				?>
				<tr>
					<td colspan="3">Jumlah Pembayaran</td>
					<td align="right"><b><?php echo buatRp($tot['totBayar']); ?></b></td>
					<td colspan="2"></td>
				</tr>
			</tbody>
		</table>
	<?php
	}
	?>
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