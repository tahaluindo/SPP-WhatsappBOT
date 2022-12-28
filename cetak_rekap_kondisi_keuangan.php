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

	$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas"));
	$dBayar = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$_GET[jenisBayar]'"));
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Cetak - Rekapitulasi Pembayaran Siswa</title>
		<link rel="stylesheet" href="bootstrap/css/printer.css">
	</head>

	<body>
		<?php
		$tgl1 = $_GET['tgl1'];
		$tgl2 = $_GET['tgl2'];
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
			<h4 align="center">
				REKAPITULASI KONDISI KEUANGAN 
			</h4>
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<!--<h3 class="box-title">Tanggal : <?php echo tgl_raport($tgl1); ?> s/d <?php echo tgl_raport($tgl2); ?></h3>-->
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered table-striped">
						<thead  class="thead">
							<tr>
								<th width="40px">No.</th>
								<th>Uraian (Keterangan)</th>
								<th>Sub Total</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$total = 0;
							//$sqlJU = mysqli_query($conn,"SELECT * FROM jurnal_umum WHERE DATE(tgl) BETWEEN '$tgl1' AND '$tgl2' ORDER BY tgl ASC");

							//hitung pemasukan dan pengeluaran dari jurnal umum
							$dPJU = mysqli_fetch_array(mysqli_query($conn,"SELECT  SUM(pengeluaran) AS totalKeluar FROM jurnal_umum"));
							
							$totalPengeluaran = $dPJU['totalKeluar'];

							$dPJU = mysqli_fetch_array(mysqli_query($conn,"SELECT  SUM(penerimaan) AS totalMasuk FROM jurnal_umums"));
					
							$totalPenerimaan = $dPJU['totalMasuk'];
							// Hitung Pembayaran Bulanan
							$dBul = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totalBul FROM tagihan_bulanan WHERE statusBayar='1'"));
							$totalPendapatanBulanan = $dBul['totalBul'];

							// Hitung Pembayaran Bebas
							$dBeb = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totalBeb FROM tagihan_bebas_bayar"));
							$totalPendapatanBebas = $dBeb['totalBeb'];

							?>
							<tr>
						<td align="center">1</td>
						<td>Total Pemasukan</td>
						<td align="right"><?php echo buatRp($totalPenerimaan); ?></td>
					</tr>
					<tr>
						<td align="center">2</td>
						<td>Total Pengeluaran</td>
						<td align="right"><?php echo buatRp($totalPengeluaran+$totalPendapatanBulanan + $totalPendapatanBebas); ?></td>
					</tr>
					<tr>
						<td colspan="2" align="center"><b>Sisa Saldo Keuangan</b></td>
						<td align="right"><b><?php echo buatRp($totalPenerimaan-($totalPendapatanBulanan + $totalPendapatanBebas  + $totalPengeluaran)); ?></b></td>
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