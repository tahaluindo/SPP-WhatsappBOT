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
	$dBayar = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM jenis_bayar WHERE idJenisBayar='$_GET[jenisBayar]'"));
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Cetak - Slip Pembayaran Gaji</title>
		<link rel="stylesheet" href="bootstrap/css/printer.css">
	</head>

	<body>
		<?php
		$tahun = $_GET['tahun'];
		$jenis = $_GET['jenisBayar'];
		$bulan = $_GET['bulan'];

		$b = mysqli_fetch_array(mysqli_query($conn, "select nmBulan from bulan where idBulan='$bulan'"));
		if ($_GET['bulan'] != "all") {
			$buland = $b['nmBulan'];
		} else {
			$buland =  "Semua Bulan";
		}
		$thn = mysqli_fetch_array(mysqli_query($conn, "select nmTahunAjaran from tahun_ajaran where nmTahunAjaran='$tahun'"));
		?>
		<div class="col-xs-12">
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
			<h3 align="center">
				REKAPITULASI SLIP PEMBAYARAN GAJI TIM <?php echo strtoupper($dBayar['nmJenisBayar']); ?><br>

			</h3>
			<hr />
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Bulan : <?php echo $buland; ?> - Tahun Anggaran : <?php echo $thn['nmTahunAjaran']; ?></h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered table-striped">
						<thead class="thead">
							<tr>
								<th width="40px">No.</th>
								<th>Jabatan</th>
								<th>Jumlah</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$sqlKelas = mysqli_query($conn, "SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
							while ($dk = mysqli_fetch_array($sqlKelas)) {
								if ($_GET['bulan'] != "all") {
									$dJenis = mysqli_fetch_array(mysqli_query($conn, "SELECT tipeBayar FROM jenis_bayar WHERE idJenisBayar='$jenis'"));
									if ($dJenis['tipeBayar'] == 'bulanan') {
										$dBul = mysqli_fetch_array(mysqli_query($conn, "SELECT idKelas, SUM(jumlahBayar) AS jumlah 
														FROM tagihan_bulanan 
														WHERE idJenisBayar='$jenis' AND idKelas='$dk[idKelas]' AND statusBayar = '1' AND month(tglBayar)='$bulan' AND year(tglBayar)='$tahun' "));
										$total = $dBul['jumlah'];
									} else {
										$dBeb = mysqli_fetch_array(mysqli_query($conn, "SELECT tagihan_bebas.idKelas, Sum(tagihan_bebas_bayar.jumlahBayar) AS jumlah
														FROM tagihan_bebas_bayar
														INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas 
														WHERE tagihan_bebas.idJenisBayar='$jenis' AND tagihan_bebas.idKelas='$dk[idKelas]' AND year(tglBayar)='$tahun' AND month(tglBayar)='$bulan' "));

										$total = $dBeb['jumlah'];
									}
								} else {
									$dJenis = mysqli_fetch_array(mysqli_query($conn, "SELECT tipeBayar FROM jenis_bayar WHERE idJenisBayar='$jenis'"));
									if ($dJenis['tipeBayar'] == 'bulanan') {
										$dBul = mysqli_fetch_array(mysqli_query($conn, "SELECT idKelas, SUM(jumlahBayar) AS jumlah 
														FROM tagihan_bulanan 
														WHERE idJenisBayar='$jenis' AND idKelas='$dk[idKelas]' AND statusBayar = '1' AND year(tglBayar)='$tahun'"));
										$total = $dBul['jumlah'];
									} else {
										$dBeb = mysqli_fetch_array(mysqli_query($conn, "SELECT tagihan_bebas.idKelas, Sum(tagihan_bebas_bayar.jumlahBayar) AS jumlah
														FROM tagihan_bebas_bayar
														INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas 
														WHERE tagihan_bebas.idJenisBayar='$jenis' AND tagihan_bebas.idKelas='$dk[idKelas]' AND year(tglBayar)='$tahun' "));
										$total = $dBeb['jumlah'];
									}
								}



								echo "<tr>
								<td align='center'>$no</td>
								<td>$dk[nmKelas]</td>
								<td align='right'>" . buatRp($total) . "</td>
							</tr>";
								$no++;
								$gTotal += $total;
							}
							echo "<tr>
							<td colspan='2'><b>Grand Total : </b></td>
							<td align='right'><b>" . buatRp($gTotal) . "</b></td>
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
				<td align="center"></td>
				<td align="center" width="400px">
					<?php echo $idt['kabupaten']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?>
					<br />Finance,<br /><br /><br /><br />
					<b><u><?php echo $idt['nmBendahara']; ?></u></b>
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