<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
if (isset($_SESSION[id])) {
	if ($_SESSION['level'] == 'admin') {
		$iden = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM users where username='$_SESSION[id]'"));
		$nama =  $iden['nama_lengkap'];
		$level = 'Administrator';
	}

	$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas where npsn='10700295'"));
	$ta = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
	//$kls = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM kelas_siswa where idKelas='$_GET[kelas]'"));
	$dBayar = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$_GET[jenis]'"));
	$dsw = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM view_detil_siswa WHERE idSiswa='$_GET[siswa]'"));
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Cetak - Bukti Pembayaran Siswa</title>
		<link rel="stylesheet" href="bootstrap/css/printer.css">
	</head>

	<body style="font-size:80%;">
		<?php
		$tahun = $_GET['tahun'];
		$jenis = $_GET['jenisBayar'];
		$kelas = $_GET['kelas'];

		$sqlLap = mysqli_query($conn,"SELECT * FROM view_laporan_bayar_bulanan 
						WHERE idJenisBayar='$_GET[jenis]' AND idTahunAjaran='$_GET[tahun]' AND idSiswa='$_GET[siswa]' AND statusBayar='1' ORDER BY urutan ASC");
		?>
		<div class="col-xs-12">
			<table width="100%">
				<tr>
					<td width="100px" align="left"><img src="./gambar/logo/<?php echo $idt['logo_kiri']; ?>" height="40px"></td>
					<td valign="top">
						<h3 align="center" style="margin-bottom:8px ">
							<?php echo $idt['nmSekolah']; ?>
						</h3>
						<center><?php echo $idt['alamat']; ?></center>
					</td>
					<td width="100px" align="right"><img src="./gambar/logo/<?php echo $idt['logo_kanan']; ?>" height="40px"></td>
				</tr>
			</table>
			<hr style="margin:4px" />
			<center><b>Bukti Pembayaran : <?php echo $dBayar['nmJenisBayar']; ?></b></center>
			<hr style="margin:4px" />
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<table width="100%" style="margin-top:10px;margin-bottom:10px;">
						<tr>
							<td width="80px">Nama Siswa</td>
							<td width="8"> : </td>
							<td> <?php echo $dsw['nmSiswa']; ?></td>
							<td></td>
							<td align="right">Kelas : <?php echo $dsw['nmKelas']; ?></td>
						</tr>
						<tr>
							<td>NIS/NISN</td>
							<td>: </td>
							<td> <?php echo $dsw['nisSiswa']; ?>/<?php echo $dsw['nisnSiswa']; ?></td>
							<td></td>
							<td></td>
						</tr>
					</table>
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="40">No.</th>
								<th>Bulan</th>
								<th>Tgl Bayar</th>
								<th>Opsi Bayar</th>
								<th>Tagihan/Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							while ($rt = mysqli_fetch_array($sqlLap)) {
								if ($rt['statusBayar'] == '1') {
									$stTagihan = buatRp($rt['jumlahBayar']) . "/Lunas";
								} else {
									$stTagihan = buatRp($rt['jumlahBayar']);
								}
								echo "<tr>
							<td align='center'>$no</td>
							<td>$rt[nmBulan]</td>
							<td align='center'>$rt[tglBayar]</td>
							<td align='center'>$rt[caraBayar]</td>
							<td align='right'>$stTagihan</td>
							</tr>";
								$no++;
							}
							?>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
		<br />
		<table width="100%">
			<tr>
				<td align="center"></td>
				<td align="center" width="200px">
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
<?php
} else {
	include "login.php";
}
?>