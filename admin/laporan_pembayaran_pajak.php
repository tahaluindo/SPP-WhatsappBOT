<?php
if (isset($_GET['tampil'])) {
	$tahun = $_GET['tahun'];
	$jenis = $_GET['jenisBayar'];
	$bulan = $_GET['bulan'];
}
?>
<div class="col-xs-12">
	<div class="box box-info box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Filter Data</h3>
		</div><!-- /.box-header -->
		<div class="table-responsive">
			<form method="GET" action="" class="form-horizontal">
				<input type="hidden" name="view" value="pajak" />
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Tahun Anggaran</th>
							<th>Jenis Penerimaan</th>
							<th>Bulan</th>

							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<select id="tahun" name="tahun" class="form-control" required>
									<?php
									$sqltahun = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran ASC");
									while ($t = mysqli_fetch_array($sqltahun)) {
										$selected = ($t['nmTahunAjaran'] == $tahun) ? ' selected="selected"' : "";
										echo "<option value=" . $t['nmTahunAjaran'] . " " . $selected . ">" . $t['nmTahunAjaran'] . "</option>";
									}
									?>
								</select>
							</td>
							<td>
								<select name="jenisBayar" class="form-control" required>

									<?php
									$sqlJB = mysqli_query($conn, "SELECT * FROM jenis_penerimaan ");
									while ($jb = mysqli_fetch_array($sqlJB)) {
										$selected = ($jb['idPenerimaan'] == $jenis) ? ' selected="selected"' : "";
										echo "<option value=" . $jb['idPenerimaan'] . " " . $selected . ">" . $jb['nmPenerimaan'] . "</option>";
									}
									?>
								</select>
							</td>
							<td>
								<select name="bulan" class="form-control" required>
									<option value="">- Pilih Bulan -</option>
									<option value="all">Semua Bulan</option>
									<?php
									$sqlJB = mysqli_query($conn, "SELECT * FROM bulan order by idBulan");
									while ($jb = mysqli_fetch_array($sqlJB)) {
										$selected = ($jb['idBulan'] == $jenis) ? ' selected="selected"' : "";
										echo "<option value=" . $jb['idBulan'] . " " . $selected . ">" . $jb['nmBulan'] . "</option>";
									}
									?>
								</select>
							</td>
							<td width="100">
								<input type="submit" name="tampil" value="Tampilkan" class="btn btn-success pull-right">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
	<?php
	if (isset($_GET['tampil'])) {
		if($_GET['bulan']=='all'){
			$sqlTagihanBebas = mysqli_query($conn, "SELECT
									jurnal_umums.*,
									jenis_penerimaan.idPenerimaan,
									jenis_penerimaan.nmPenerimaan,
									jurnal_umums.penerimaan,
									jurnal_umums.ket
							
								FROM
								jurnal_umums
								INNER JOIN jenis_penerimaan ON jurnal_umums.idPenerimaan = jenis_penerimaan.idPenerimaan
									WHERE jurnal_umums.idPenerimaan='$jenis' and year(jurnal_umums.tgl)='$tahun' ORDER BY jurnal_umums.idPenerimaan ASC");
	
		}else{
		$sqlTagihanBebas = mysqli_query($conn, "SELECT
									jurnal_umums.*,
									jenis_penerimaan.idPenerimaan,
									jenis_penerimaan.nmPenerimaan,
									jurnal_umums.penerimaan,
									jurnal_umums.ket
							
								FROM
								jurnal_umums
								INNER JOIN jenis_penerimaan ON jurnal_umums.idPenerimaan = jenis_penerimaan.idPenerimaan
									WHERE jurnal_umums.idPenerimaan='$jenis' and year(jurnal_umums.tgl)='$tahun' and month(jurnal_umums.tgl)='$bulan' ORDER BY jurnal_umums.idPenerimaan ASC");
	}
	?>
		<div class="box box-info box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Pajak Penerimaan <?php echo $dBayar['nmPenerimaan']; ?></h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No.</th>

							<th>Nama Jenis Penerimaan</th>
							<th>Total Bayar</th>
							<th>Pajak 0.5%</th>

						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						while ($rtb = mysqli_fetch_array($sqlTagihanBebas)) {

							$ppn = $rtb['penerimaan'] * 0.5 / 100;
							echo "<tr>
								<td>$no</td>
								<td>$rtb[ket]</td>
								<td>" . buatRp($rtb['penerimaan']) . "</td>
								
								<td>" . buatRp($ppn) . "</td>
							
							</tr>";
							$no++;
							$totDibayar += $rtb['penerimaan'];
							$pajak += $ppn;
						}
						?>
						<tr>
							<td colspan="2">Jumlah Pembayaran</td>
							<td><b><?php echo buatRp($totDibayar); ?></b></td>
							<td><b><?php echo buatRp($pajak); ?></b></td>
						</tr>
					</tbody>
				</table>
			</div><!-- /.box-body -->
			<div class="box-footer">
				<a class="btn btn-success" target="_blank" href="./excel_laporan_pembayaran_pajak.php?tahun=<?php echo $_GET['tahun']; ?>&jenisBayar=<?php echo $_GET['jenisBayar']; ?>&bulan=<?php echo $_GET['bulan']; ?>"><span class="fa fa-file-excel-o"></span> Export ke Excel</a>
				<a class="pull-right btn btn-danger" target="_blank" href="./cetak_laporan_pembayaran_pajak.php?tahun=<?php echo $_GET['tahun']; ?>&jenisBayar=<?php echo $_GET['jenisBayar']; ?>&bulan=<?php echo $_GET['bulan']; ?>"><span class="glyphicon glyphicon-print"></span> Cetak Laporan </a>

			</div>
		</div><!-- /.box -->
	<?php
	}

	?>
</div>