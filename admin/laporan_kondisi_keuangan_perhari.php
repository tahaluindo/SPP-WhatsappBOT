<?php
date_default_timezone_set('Asia/Jakarta');
$tahun = $ta['idTahunAjaran'];
$jenis = '';
$kelas = '';
include 'config/rupiah.php';
$tgl = date('Y-m-d');
$sqlJenisBayar = mysqli_query($conn,"SELECT * FROM jenis_bayar  ORDER BY tipeBayar DESC");
?>
<div class="col-xs-12">
	<div class="box box-info box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Pemasukan Perhari</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="" class="form-horizontal">
				<input type="hidden" name="view" value="lappembayaranhari" />
				<table class="table table-striped">
					<thead>
						<tr>

							<th>Pilih Tanggal</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<?php
									if ($_GET['tgl1'] != '') {
										echo '<input type="text" name="tgl1" class="form-control pull-right date-picker"  value="' . $_GET['tgl1'] . '">';
									} else {
										echo '<input type="text" name="tgl1" class="form-control pull-right date-picker" >';
									}
									?>
								</div>
								<!-- /.input group -->
							</td>
							<td width="100">
								<input type="submit" name="proses" value="Proses" class="btn btn-success pull-right">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div><!-- /.box-body -->
		<?php
		if (isset($_GET['proses'])) {

			$MulaiTgl = $_GET['tgl1'];

		?>
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Nama Siswa</th>
							<th>Tipe Pembayaran</th>
							<th>Jenis Pembayaran</th>
							<th>Tgl Bayar</th>
							<th>Jumlah/Status</th>
						</tr>
					</thead>
					<tbody>
						<tr class="header1 expand">
							<td><span class='btn btn-danger btn-xs sign'></span></td>
							<td colspan="6">Rincian Pemasukan</td>
						</tr>
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
								<td align='center'></td>
							
							<td align='center'>$dtb[nmSiswa]</td>
							<td align='center'>Bebas</td>
								<td align='left'>" . ucwords(strtolower($dj['nmJenisBayar'])) . "</td>
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
									$date = date_create($rt['tglBayar']);
									echo "<tr>
							<td align='center'></td>
								
							<td align='center'>$rt[nmSiswa]</td>
							<td align='center'>Bulanan</td>
								<td>" . ucwords(strtolower($dj['nmJenisBayar'])) . "/$rt[nmBulan]</td>
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
							<td></td>
							<td align='center'><?php echo $row['nmSiswa']; ?></td>
							<td align='center'>Tabungan</td>
							<td><?php echo $statusBayar; ?></td>
							<td align='center'><?php echo $row['tanggal']; ?></td>
							<td><?php echo buatRp($onClick); ?>/<?php echo $row['id_transaksi']; ?></td>


						<?php } ?>

						<tr>
							<td colspan="5" align='center'><b>Jumlah Pemasukan Hari Ini</b></td>
							<td><b><?php echo buatRp($tot); ?></b></td>
						</tr>
						<a href="./cetak_rekap_pemasukan_harian.php?&tgl=<?php echo $MulaiTgl; ?>" class="btn btn-danger pull-right" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak Laporan</a>


					<?php
				}
					?>

					</tbody>

				</table>



			</div><!-- /.box-body -->
	</div><!-- /.box -->
</div><!-- /.box -->