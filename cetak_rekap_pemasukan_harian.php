<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_seo.php";
include 'config/rupiah.php';
if (isset($_SESSION[id])) {
	if ($_SESSION['level'] == 'admin') {
		$iden = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM users where username='$_SESSION[id]'"));
		$nama =  $iden['nama_lengkap'];
		$level = 'Administrator';
		$foto = 'dist/img/user.png';
	}
	$MulaiTgl = $_GET[tgl];
	$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas"));
	$sqlJenisBayar = mysqli_query($conn,"SELECT * FROM jenis_bayar  ORDER BY tipeBayar DESC");
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Cetak - Rekapitulasi Pemasukan Perhari</title>
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
				REKAPITULASI PEMASUKAN PERHARI (<?php echo tgl_raport($MulaiTgl); ?> )
			</h4>
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<!--<h3 class="box-title">Tanggal : <?php echo tgl_raport($tgl1); ?> s/d <?php echo tgl_raport($tgl2); ?></h3>-->
				</div><!-- /.box-header -->
				<div class="box-body">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Nama Siswa</th>
								<th>Tipe Pembayaran</th>
								<th>Jenis Pembayaran</th>
								<th>Tgl Bayar</th>

								<th>Jumlah/Status</th>
							</tr>
						</thead>

						<tbody>

							<?php
							$no = 1;
							//tagihan Lainnya
							while ($dj = mysqli_fetch_array($sqlJenisBayar)) {
								if ($dj['tipeBayar'] == 'bebas') {
									$sqlB = mysqli_query($conn,"SELECT
							tagihan_bebas_bayar.idTagihanBebasBayar,
							tagihan_bebas_bayar.idTagihanBebas,
							tagihan_bebas_bayar.tglBayar,
							tagihan_bebas_bayar.jumlahBayar,
							tagihan_bebas_bayar.ketBayar,
							tagihan_bebas_bayar.caraBayar,
							tagihan_bebas.idJenisBayar,
							tagihan_bebas.idSiswa,
							tagihan_bebas.idKelas,
							tagihan_bebas.totalTagihan,
							tagihan_bebas.statusBayar,
							siswa.nisSiswa,
					siswa.nmSiswa
							FROM
								tagihan_bebas_bayar
							INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
							INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
							WHERE tagihan_bebas.idJenisBayar='$dj[idJenisBayar]' AND tagihan_bebas.statusBayar<>'0' AND(DATE(tagihan_bebas_bayar.tglBayar) ='$MulaiTgl' )");

									while ($dtb = mysqli_fetch_array($sqlB)) {
										if ($dtb['statusBayar'] > 0) {
											$stTagihanLainya = buatRp($dtb['jumlahBayar']) . "/" . $dtb['ketBayar'];
										} else {
											$stTagihanLainya = buatRp($dtb['jumlahBayar']);
										}
										echo "<tr >
								
							
							<td align='center'>$dtb[nmSiswa]</td>
							<td align='center'>Bebas</td>
								<td align='left'>" . ucwords(strtolower($dj[nmJenisBayar])) . "</td>
								<td align='center'>$dtb[tglBayar]</td>
								
								<td >$stTagihanLainya</td>
							</tr>";
									}
								} else if ($dj['tipeBayar'] == 'bulanan') {

									//tagihan bulanan
									$sqlLap = mysqli_query($conn,"SELECT * FROM view_laporan_bayar_bulanan 
						INNER JOIN siswa ON view_laporan_bayar_bulanan.idSiswa = siswa.idSiswa
							WHERE idJenisBayar='$dj[idJenisBayar]'  AND statusBayar='1' AND (DATE(tglBayar) ='$MulaiTgl' ) ORDER BY urutan ASC");
									while ($rt = mysqli_fetch_array($sqlLap)) { //while per page

										if ($rt['statusBayar'] == '1') {
											$stTagihan = buatRp($rt['jumlahBayar']) . "/Lunas";
										} else {
											$stTagihan = buatRp($rt['jumlahBayar']);
										}
										$date = date_create($rt[tglBayar]);
										echo "<tr>
							
								
							<td align='center'>$rt[nmSiswa]</td>
							<td align='center'>Bulanan</td>
								<td>" . ucwords(strtolower($dj[nmJenisBayar])) . "/$rt[nmBulan]</td>
								<td align='center'>" . date_format($date, 'Y-m-d') . "</td>
								
								<td >$stTagihan</td>
								</tr>";
									} //end while per page
								}
							}

							//total tagihan lainnya
							$totLainya = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totBayar
					FROM tagihan_bebas_bayar
					INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
					INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa 
					WHERE tagihan_bebas.statusBayar<>'0' AND (DATE(tagihan_bebas_bayar.tglBayar) ='$MulaiTgl' )"));
							//total tagihan bulanan
							$totBulanan = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totBayar FROM tagihan_bulanan WHERE statusBayar='1'  AND (DATE(tglBayar) ='$MulaiTgl')"));

							// Hitung Pembayaran Tabungan
							$query_hari = mysqli_query($conn,"SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE (DATE(tanggal) ='$MulaiTgl') ");
							$saldo_h = mysqli_fetch_array($query_hari);
							$saldo_hari = $saldo_h['jumlah_debit'] - $saldo_h['jumlah_kredit'];

							$tot = $totLainya['totBayar'] + $totBulanan['totBayar'] + $saldo_hari;
							?>







							<?php
							$no = 0;
							$query = mysqli_query($conn,"SELECT * FROM transaksi JOIN siswa ON transaksi.nisnSiswa=siswa.nisnSiswa WHERE transaksi.kredit='0' AND (DATE(tanggal) ='$MulaiTgl') order by id_transaksi asc ");





							while ($row = mysqli_fetch_array($query)) {
								if ($row['kredit'] == 0) {


									$statusBayar = "Setor";
									$onClick = "$row[debit]";
								} else {


									$statusBayar = "Tarik";
									$onClick = "$row[kredit]";
								}
								$no++;
							?>

								<td align='center'><?php echo $row['nmSiswa']; ?></td>
								<td align='center'>Tabungan</td>
								<td><?php echo $statusBayar; ?></td>
								<td align='center'><?php echo $row['tanggal']; ?></td>
								<td><?php echo buatRp($onClick); ?>/<?php echo $row['id_transaksi']; ?></td>


							<?php } ?>

							<tr>
								<td colspan="4" align='center'><b>Jumlah Pemasukan Hari Ini</b></td>
								<td><b><?php echo buatRp($tot); ?></b></td>
							</tr>




						</tbody>
						<br />
						<table width="100%">
							<br />
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
<?php
} else {
	include "login.php";
}
?>