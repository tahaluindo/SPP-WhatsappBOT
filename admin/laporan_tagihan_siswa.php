<?php
if (isset($_GET['tampil'])) {
	$tahun = $_GET['tahun'];
	$kelas = $_GET['kelas'];
} else {
	$tahun = $ta['idTahunAjaran'];
	$kelas = '';
}
?>
<div class="col-xs-12">
	<div class="box box-primary box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Tagihan Siswa</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="" class="form-horizontal">
				<input type="hidden" name="view" value="laptagihansiswa">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Kelas</th>
							<th>Tahun Ajaran</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<select id="kelas" name="kelas" class="form-control" required>
									<option value="" selected> - Pilih Kelas - </option>
									<?php
									$sqk = mysqli_query($conn,"SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
									while ($k = mysqli_fetch_array($sqk)) {
										$selected = ($k['idKelas'] == $kelas) ? ' selected="selected"' : "";
										echo "<option value=" . $k['idKelas'] . " " . $selected . ">" . $k['nmKelas'] . "</option>";
									}
									?>
								</select>
							</td>
							<td>
								<select id="tahun" name="tahun" class="form-control" required>
									<?php
									$sqltahun = mysqli_query($conn,"SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran ASC");
									while ($t = mysqli_fetch_array($sqltahun)) {
										$selected = ($t['idTahunAjaran'] == $tahun) ? ' selected="selected"' : "";
										echo "<option value=" . $t['idTahunAjaran'] . " " . $selected . ">" . $t['nmTahunAjaran'] . "</option>";
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
		$sqlSiswa = mysqli_query($conn,"SELECT *
								FROM
									view_detil_siswa
								WHERE idKelas='$_GET[kelas]' AND statusSiswa='Aktif' ORDER BY nmSiswa ASC");
	?>
		<div class="box box-primary">
			<div class="table-responsive">
				<table id="example1" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>NIS</th>
							<th>NISN</th>
							<th>Nama Siswa</th>
							<th>Kelas</th>
							<th>Cetak</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						while ($ds = mysqli_fetch_array($sqlSiswa)) {
							echo "<tr>
							<td>$no</td>
							<td>$ds[nisSiswa]</td>
							<td>$ds[nisnSiswa]</td>
							<td>$ds[nmSiswa]</td>
							<td>$ds[nmKelas]</td>
							<td class='text-center'>
								<a href='./cetak_tagihan_persiswa.php?siswa=$ds[idSiswa]&tahun=$_GET[tahun]' class='btn btn-danger btn-sm' target='_blank'><span class='glyphicon glyphicon-print'></span> Cetak Tagihan</a>
							</td>
						</tr>";
							$no++;
						}
						?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
			<div class="box-footer">
				<a class="btn btn-danger" target="_blank" href="./cetak_tagihan_siswa_semua.php?kelas=<?php echo $_GET['kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>"><span class="glyphicon glyphicon-print"></span> Cetak Semua Tagihan</a>
				<a class="btn btn-success" target="_blank" href="./excel_tagihan_siswa_semua.php?kelas=<?php echo $_GET['kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>"><span class="glyphicon glyphicon-file"></span> Export ke Excel</a>
			</div>
		</div><!-- /.box -->
	<?php
	}
	?>
</div>