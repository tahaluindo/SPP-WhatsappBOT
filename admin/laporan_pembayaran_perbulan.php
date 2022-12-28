<?php
if (isset($_GET['tampil'])) {
	$tahun = $_GET['tahun'];
	$jenis = $_GET['jenisBayar'];
	$kelas = $_GET['kelas'];
	$dBayar = mysqli_fetch_array(mysqli_query($conn,"select * from jenis_bayar where idJenisBayar='$jenis'"));
} else {
	$tahun = $ta['idTahunAjaran'];
	$jenis = '';
	$kelas = '';
}
?>
<div class="col-xs-12">
	<div class="box box-info box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Filter Data</h3>
		</div><!-- /.box-header -->
		<div class="table-responsive">
			<form method="GET" action="cetak_laporan_pembayaran_perbulan.php" class="form-horizontal" target="_blank">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Kelas</th>
							<th>Mulai</th>
							<th>Sampai</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<select id="kelas" name="kelas" class="form-control" required>

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
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" name="tgl1" class="form-control pull-right date-picker">
								</div>
								<!-- /.input group -->
							</td>
							<td>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" name="tgl2" class="form-control pull-right date-picker">
								</div>
								<!-- /.input group -->
							</td>
							<td width="100">
								<input type="submit" value="Tampilkan & Cetak" class="btn btn-success pull-right">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>