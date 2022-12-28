<?php
$tahun = $ta['idTahunAjaran'];
$jenis = '';
$kelas = '';
?>
<div class="col-xs-12">
	<div class="box box-warning box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Kondisi Keuangan</h3>
		</div><!-- /.box-header -->
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
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
			<hr>
			<div class="form-group">
					<label for=""></label>
					<a href="./cetak_rekap_kondisi_keuangan.php" class="btn btn-danger pull-right" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak Laporan</a>
				</div>
			
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>