<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/fungsi_indotgl.php";

$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas "));
$sqlSiswa = mysqli_query($conn,"SELECT * FROM view_detil_siswa WHERE idKelas='$_GET[kelas]' AND statusSiswa='Aktif' ORDER BY nmSiswa ASC");
$kls = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM kelas_siswa where idKelas='$_GET[kelas]'"));

?>
<!DOCTYPE html>
<html>

<head>
	<title>Cetak - Laporan Pembayaran Siswa</title>
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
	<h3 align="center">LAPORAN DATA SISWA</h3>
	<h3 class="box-title">KELAS : <?php echo $kls['nmKelas']; ?></h3>
	<table border="1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No.</th>
				<th>NIS</th>
				<th>NISN</th>
				<th>Nama Siswa</th>
				<th>Jenis Kelamin</th>
				<th>Kelas</th>
				<th>Nama Orang Tua</th>
				<th>No. Hp</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			while ($ds = mysqli_fetch_array($sqlSiswa)) {
				echo "<tr>
				<td align='center'>$no</td>
				<td align='center'>$ds[nisSiswa]</td>
				<td align='center'>$ds[nisnSiswa]</td>
				<td>$ds[nmSiswa]</td>
				<td align='center'>$ds[jkSiswa]</td>
				<td align='center'>$ds[nmKelas]</td>
				<td>$ds[nmOrtu]</td>
				<td align='center'>$ds[noHpOrtu]</td>
			</tr>";
				$no++;
			}
			?>
		</tbody>
	</table>
	<br />
	<table width="100%">
		<tr>
			<td align="center"></td>
			<td align="center" width="400px">
				<?php echo $idt['kabupaten']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?>
				<br />Kepala Tata Usaha,<br /><br /><br /><br />
				<b><u><?php echo $idt['nmKaTU']; ?></u><br /><?php echo $idt['nipKaTU']; ?></b>
			</td>
		</tr>
	</table>
</body>
<script>
	window.print()
</script>

</html>