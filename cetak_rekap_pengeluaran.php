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
		<style>
			h2 {
				color: #fff;
				background-color: #01193E;
			}
			h1 {
				color: #fff;
				background-color: #6495ED;
			}
			p {
				color: #000;
			}
		</style>
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
			<h3 align="center">
				REKAPITULASI PENERIMAAN DAN PENGELUARAN
			</h3>
			<hr />
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Tanggal : <?php echo tgl_raport($tgl1); ?> s/d <?php echo tgl_raport($tgl2); ?></h3>
				</div><!-- /.box-header -->
				<div class="box-body">
				<table class="table table-bordered table-striped">
						<thead  class="thead">
							<tr>
								<th width="40px">No.</th>
								<th>Tanggal</th>
								<th>Uraian (Keterangan)</th>
								<th>Penerimaan</th>
							</tr>
						</thead>
						<tbody>
					
							<?php
						$no=1;
							$total = 0;
							$sqlJU = mysqli_query($conn,"SELECT * FROM jurnal_umums WHERE DATE(tgl) BETWEEN '$tgl1' AND '$tgl2' ORDER BY tgl ASC");
							while ($d = mysqli_fetch_array($sqlJU)) {
								echo "<tr>
							<td align='center'>$no</td>
							<td align='left'>" . tgl_raport($d['tgl']) . "</td>
							<td>$d[ket]</td>
							<td align='right'>" . buatRp($d['penerimaan']) . "</td>
						</tr>";
								$no++;
								$total += $d['penerimaan'];
							}
							
							?>
							<?php
							$dPJU = mysqli_fetch_array(mysqli_query($conn,"SELECT  SUM(penerimaan) AS totalMasuk FROM jurnal_umums where DATE(tgl) BETWEEN '$tgl1' AND '$tgl2'"));
							$totalPenerimaan = $dPJU['totalMasuk'];
							$tots = $totalPenerimaan ;
							?>
							<tr>
								<td colspan="3" align="center"><b>Total Penerimaan</b></td>
								<td align="right"><b><?php echo buatRp($tots); ?></b></td>
							</tr>
						</tbody>
					</table>
					<br>
					<table class="table table-bordered table-striped">
						<thead  class="thead">
							<tr>
								<th width="40px">No.</th>
								<th>Tanggal</th>
								<th>Uraian (Keterangan)</th>
								<th>Pengeluaran</th>
							</tr>
						</thead>
						<tbody>
							<?php
						$no = 1;
						$total = 0;
						$dBebS = mysqli_query($conn, "SELECT SUM(jumlahBayar) AS pengeluaran,tglBayar as tgl,ketBayar as ket FROM tagihan_bebas_bayar where DATE(tglBayar) BETWEEN '$tgl1' AND '$tgl2' ORDER BY tglBayar ASC");
					
						while ($dss = mysqli_fetch_array($dBebS)) {
							echo "<tr>
							
							
						<td align='center'>$no</td>
						<td align='left'>" . tgl_raport($dss['tgl']) . "</td>
						<td>$dss[ket]</td>
						<td align='right'>" . buatRp($dss['pengeluaran']) . "</td>
						</tr>";
							$no++;
							$total += $dss['pengeluaran'];
						}
						?>
						<?php
						
						$total = 0;
						$dTahS = mysqli_query($conn, "SELECT SUM(jumlahBayar) AS pengeluaran,tglBayar as tgl,nmJenisBayar as ket FROM view_laporan_bayar_bulanan where statusBayar='1' AND DATE(tglBayar) BETWEEN '$tgl1' AND '$tgl2' ORDER BY tglBayar ASC");
						
						while ($ds = mysqli_fetch_array($dTahS)) {
							echo "<tr>
						<td align='center'>$no</td>
						<td align='left'>" . tgl_raport($ds['tgl']) . "</td>
						<td>$ds[ket]</td>
						<td align='right'>" . buatRp($ds['pengeluaran']) . "</td>
						</tr>";
							$no++;
							$total += $ds['pengeluaran'];
						}
						?>
							<?php
						
							$total = 0;
							$sqlJU = mysqli_query($conn,"SELECT * FROM jurnal_umum WHERE pengeluaran!=0 AND DATE(tgl) BETWEEN '$tgl1' AND '$tgl2' ORDER BY tgl ASC");
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
							
							?>
							<?php
							$dPJU = mysqli_fetch_array(mysqli_query($conn,"SELECT  SUM(pengeluaran) AS totalKeluar FROM jurnal_umum where DATE(tgl) BETWEEN '$tgl1' AND '$tgl2'"));
					
							$totalPengeluaran = $dPJU['totalKeluar'];
							
		
							// Hitung Pembayaran Bulanan
							$dBul = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totalBul FROM tagihan_bulanan WHERE statusBayar='1' and DATE(tglBayar) BETWEEN '$tgl1' AND '$tgl2'"));
							$totalPendapatanBulanan = $dBul['totalBul'];
		
							// Hitung Pembayaran Bebas
							$dBeb = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totalBeb FROM tagihan_bebas_bayar where DATE(tglBayar) BETWEEN '$tgl1' AND '$tgl2'"));
							$totalPendapatanBebas = $dBeb['totalBeb'];

							$totsd = $totalPengeluaran+$totalPendapatanBulanan+$totalPendapatanBebas ;
							?>
							<tr>
								<td colspan="3" align="center"><b>Total Pengeluaran</b></td>
								<td align="right"><b><?php echo buatRp($totsd); ?></b></td>
							</tr>
						</tbody>
					</table>
					<br>
					<table class="table table-bordered table-striped">
					<thead  class="thead">
					<tr>
								<th colspan="3" align="center"><b>Total Penerimaan dan pengeluaran </b></th>
								<th align="right"><b><?php echo buatRp($tots-$totsd); ?></b></th>
							</tr>
						</thead>
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