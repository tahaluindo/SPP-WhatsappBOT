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
	//$dBayar=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$_GET[jenis]'"));
	//$dsw=mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM view_detil_siswa WHERE nisSiswa='$_GET[siswa]'"));
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Cetak - Bukti Pembayaran Siswa</title>
		<link rel="stylesheet" href="bootstrap/css/printer.css">
	</head>

	<body style="font-size:80%;">
		<?php
		$tagihan = $_GET['idtbb'];

		$dTagihan = mysqli_fetch_array(mysqli_query($conn,"SELECT
			tagihan_bebas_bayar.idTagihanBebasBayar,
			tagihan_bebas_bayar.idTagihanBebas,
			tagihan_bebas_bayar.tglBayar,
			tagihan_bebas_bayar.jumlahBayar,
			tagihan_bebas_bayar.ketBayar,
			tagihan_bebas_bayar.caraBayar,
			tagihan_bebas.idJenisBayar,
			tagihan_bebas.idSiswa,
			siswa.nisSiswa,
			siswa.nisnSiswa,
			siswa.nmSiswa,
			siswa.jkSiswa,
			siswa.agamaSiswa,
			siswa.idKelas,
			siswa.statusSiswa,
			kelas_siswa.nmKelas,
			jenis_bayar.idTahunAjaran,
			jenis_bayar.nmJenisBayar,
			jenis_bayar.tipeBayar,
			tahun_ajaran.nmTahunAjaran,
			tahun_ajaran.aktif
		FROM
			tagihan_bebas_bayar
		INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
		INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
		INNER JOIN kelas_siswa ON siswa.idKelas = kelas_siswa.idKelas
		INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
		INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
		WHERE tagihan_bebas_bayar.idTagihanBebasBayar='$tagihan'"));
		//$nisn=mysqli_fetch_array(mysqli_query($conn,"SELECT nisnSiswa FROM siswa WHERE nisSiswa='$dTagihan[nisSiswa]'"));
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
			<center><b>Bukti Pembayaran : <?php echo $dTagihan['nmJenisBayar']; ?></b></center>
			<hr style="margin:4px" />
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<table width="100%" style="margin-top:10px;margin-bottom:10px;">
						<tr>
							<td width="80px">Nama Siswa</td>
							<td width="8"> : </td>
							<td><?php echo $dTagihan['nmSiswa']; ?></td>
							<td></td>
							<td align="right">Kelas : <?php echo $dTagihan['nmKelas']; ?></td>
						</tr>
						<tr>
							<td>NIS/NISN</td>
							<td> : </td>
							<td><?php echo $dTagihan['nisSiswa']; ?>/<?php echo $dTagihan['nisnSiswa']; ?></td>
							<td></td>
							<td></td>
						</tr>
					</table>
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Tgl. Bayar</th>
								<th>Jumlah Bayar</th>
								<th>Opsi Bayar</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							<?php
							echo "<tr>
							<td align='center'>$dTagihan[tglBayar]</td>
							<td align='right'>" . buatRp($dTagihan['jumlahBayar']) . "</td>
							<td align='center'>$dTagihan[caraBayar]</td>
							<td align='right'>$dTagihan[ketBayar]</td>
							</tr>";
							?>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
		<br />
		<table width="100%">
			<tr>
				<td valign="top">
					<b>Terbilang :</b><br>
					<i><?php echo terbilang($dTagihan['jumlahBayar']); ?> rupiah.</i>
				</td>
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