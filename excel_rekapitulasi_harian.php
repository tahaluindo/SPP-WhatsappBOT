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

	$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas where npsn='10700295'"));
	$dBayar = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$_GET[jenisBayar]'"));

	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=laporan_bulanan_kelas_" . str_replace(" ", "_", $kls['nmKelas']) . "_" . date('dmyHis') . ".xls");
?>

	<?php
	$tahun = $_GET['tahun'];
	$jenis = $_GET['jenisBayar'];
	//$tgl=$_GET['tgl'];
	$tgl1 = $_GET['tgl1'];
	$tgl2 = $_GET['tgl2'];
	?>
	<div class="col-xs-12">
		<table width="100%">
			<tr>
				<!--<td width="100px" align="left"><img src="./gambar/logo/<?php //echo $idt['logo_kiri']; 
																			?>" height="60px"></td>-->
				<td valign="top">
					<h3 align="center" style="margin-bottom:8px ">
						<?php echo $idt['nmSekolah']; ?>
					</h3>
					<center><?php echo $idt['alamat']; ?></center>
				</td>
				<!--<td width="100px" align="right"><img src="./gambar/logo/<?php //echo $idt['logo_kanan']; 
																			?>" height="60px"></td>-->
			</tr>
		</table>
		<hr>
		<h3 align="center">
			REKAPITULASI PEMBAYARAN <?php echo strtoupper($dBayar['nmJenisBayar']); ?>
			<br>
			<?php
			if ($_GET['caraBayar'] != "") {
				echo "Pembayaran " . $_GET['caraBayar'];
			} else {
				echo "";
			}
			?>
		</h3>
		<hr />
		<div class="box box-info box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Tanggal : <?php echo tgl_raport($tgl1); ?> s/d <?php echo tgl_raport($tgl2); ?></h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<table border="1">
					<thead>
						<tr>
							<th width="40px">No.</th>
							<th>Kelas</th>
							<th>Jumlah</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						$sqlKelas = mysqli_query($conn,"SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
						while ($dk = mysqli_fetch_array($sqlKelas)) {
							if ($_GET['caraBayar'] != "") {

								if ($jenis == "all") {

									$dBul = mysqli_fetch_array(mysqli_query($conn,"SELECT tagihan_bulanan.idKelas, 
													Sum(tagihan_bulanan.jumlahBayar) AS jumlah,
													jenis_bayar.idTahunAjaran
												FROM tagihan_bulanan
												INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
												WHERE jenis_bayar.idTahunAjaran='$tahun' 
												AND idKelas='$dk[idKelas]' AND statusBayar = '1' 
												AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$tgl1' AND '$tgl2') AND tagihan_bulanan.caraBayar='$_GET[caraBayar]'"));

									$dBeb = mysqli_fetch_array(mysqli_query($conn,"SELECT tagihan_bebas.idKelas, Sum(tagihan_bebas_bayar.jumlahBayar) AS jumlah,
															tagihan_bebas.idJenisBayar, jenis_bayar.idTahunAjaran
														FROM tagihan_bebas_bayar
														INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
														INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar 
														WHERE jenis_bayar.idTahunAjaran='$tahun' AND tagihan_bebas.idKelas='$dk[idKelas]' 
														AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl1' AND '$tgl2') AND tagihan_bebas_bayar.caraBayar='$_GET[caraBayar]'"));

									$total = $dBul['jumlah'] + $dBeb['jumlah'];
								} else {

									$dJenis = mysqli_fetch_array(mysqli_query($conn,"SELECT tipeBayar FROM jenis_bayar WHERE idJenisBayar='$jenis'"));
									if ($dJenis['tipeBayar'] == 'bulanan') {
										$dBul = mysqli_fetch_array(mysqli_query($conn,"SELECT idKelas, SUM(jumlahBayar) AS jumlah 
														FROM tagihan_bulanan 
														WHERE idJenisBayar='$jenis' AND idKelas='$dk[idKelas]' AND statusBayar = '1' AND (DATE(tglBayar) BETWEEN '$tgl1' AND '$tgl2') AND caraBayar='$_GET[caraBayar]'"));
										$total = $dBul['jumlah'];
									} else {
										$dBeb = mysqli_fetch_array(mysqli_query($conn,"SELECT tagihan_bebas.idKelas, Sum(tagihan_bebas_bayar.jumlahBayar) AS jumlah
														FROM tagihan_bebas_bayar
														INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas 
														WHERE tagihan_bebas.idJenisBayar='$jenis' AND tagihan_bebas.idKelas='$dk[idKelas]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl1' AND '$tgl2') AND tagihan_bebas_bayar.caraBayar='$_GET[caraBayar]'"));

										$total = $dBeb['jumlah'];
									}
								}
							} else {
								if ($jenis == "all") {

									$dBul = mysqli_fetch_array(mysqli_query($conn,"SELECT tagihan_bulanan.idKelas, 
													Sum(tagihan_bulanan.jumlahBayar) AS jumlah,
													jenis_bayar.idTahunAjaran
												FROM tagihan_bulanan
												INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
												WHERE jenis_bayar.idTahunAjaran='$tahun' 
												AND idKelas='$dk[idKelas]' AND statusBayar = '1' 
												AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$tgl1' AND '$tgl2')"));

									$dBeb = mysqli_fetch_array(mysqli_query($conn,"SELECT tagihan_bebas.idKelas, Sum(tagihan_bebas_bayar.jumlahBayar) AS jumlah,
															tagihan_bebas.idJenisBayar, jenis_bayar.idTahunAjaran
														FROM tagihan_bebas_bayar
														INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
														INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar 
														WHERE jenis_bayar.idTahunAjaran='$tahun' AND tagihan_bebas.idKelas='$dk[idKelas]' 
														AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl1' AND '$tgl2')"));

									$total = $dBul['jumlah'] + $dBeb['jumlah'];
								} else {

									$dJenis = mysqli_fetch_array(mysqli_query($conn,"SELECT tipeBayar FROM jenis_bayar WHERE idJenisBayar='$jenis'"));
									if ($dJenis['tipeBayar'] == 'bulanan') {
										$dBul = mysqli_fetch_array(mysqli_query($conn,"SELECT idKelas, SUM(jumlahBayar) AS jumlah 
														FROM tagihan_bulanan 
														WHERE idJenisBayar='$jenis' AND idKelas='$dk[idKelas]' AND statusBayar = '1' AND (DATE(tglBayar) BETWEEN '$tgl1' AND '$tgl2')"));
										$total = $dBul['jumlah'];
									} else {
										$dBeb = mysqli_fetch_array(mysqli_query($conn,"SELECT tagihan_bebas.idKelas, Sum(tagihan_bebas_bayar.jumlahBayar) AS jumlah
														FROM tagihan_bebas_bayar
														INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas 
														WHERE tagihan_bebas.idJenisBayar='$jenis' AND tagihan_bebas.idKelas='$dk[idKelas]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl1' AND '$tgl2')"));

										$total = $dBeb['jumlah'];
									}
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
				<br />Bendahara,<br /><br /><br /><br />
				<b><u><?php echo $idt['nmBendahara']; ?></u><br /><?php echo $idt['nipBendahara']; ?></b>
			</td>
		</tr>
	</table>
	<!--</body>
<script>
	window.print()
</script>
</html>-->
<?php
} else {
	include "login.php";
}
?>