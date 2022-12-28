<?php
$tahun = $ta['idTahunAjaran'];
$jenis = '';
$kelas = '';
?>
<!--
<div class="col-xs-6">
	<div class="box box-info box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Rekap Per Hari</h3>
		</div><!-- /.box-header -->
<!--	<div class="box-body">
			<form method="GET" action="cetak_rekapitulasi_harian.php" role="form" target="_blank">
				<div class="form-group">
					<label for="">Tahun Anggaran</label>
					<select id="tahun" name="tahun" class="form-control" required>
						<?php
						$sqltahun = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran ASC");
						while ($t = mysqli_fetch_array($sqltahun)) {
							$selected = ($t['idTahunAjaran'] == $tahun) ? ' selected="selected"' : "";
							echo "<option value=" . $t['idTahunAjaran'] . " " . $selected . ">" . $t['nmTahunAjaran'] . "</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Jenis Pembayaran</label>
					<select id="jenisBayar" name="jenisBayar" class="form-control" required>
						<?php
						echo "<option value='all'>- Semua Jenis Bayar -</option>";
						$sqlJB = mysqli_query($conn, "SELECT * FROM jenis_bayar WHERE idTahunAjaran='$tahun' ORDER BY idJenisBayar ASC");
						while ($jb = mysqli_fetch_array($sqlJB)) {
							$selected = ($jb['idJenisBayar'] == $jenis) ? ' selected="selected"' : "";
							echo "<option value=" . $jb['idJenisBayar'] . " " . $selected . ">" . $jb['nmJenisBayar'] . "</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Dari Tanggal</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="tgl1" value="<?php echo date('Y-m-d'); ?>" class="form-control pull-right date-picker">
					</div>
				</div>
				<div class="form-group">
					<label for="">Sampai Tanggal</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="tgl2" value="<?php echo date('Y-m-d'); ?>" class="form-control pull-right date-picker">
					</div>
				</div>
				<div class="form-group">
					<label for="">Opsi/Cara Pembayaran</label>
					<select name="caraBayar" class="form-control">
						<option value="">Semua</option>
						<option value="Tunai">Tunai</option>
						<option value="Transfer">Transfer</option>
					</select>
				</div>
				<div class="form-group">
					<label for=""></label>
					<input type="submit" value="Cetak Laporan" class="btn btn-success pull-right">
				</div>
			</form>
		</div>
	</div>
</div>-->l
<div class="col-xs-12">
	<div class="box box-warning box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Rekap Per Bulan</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="cetak_rekapitulasi_perperiode.php" role="form" target="_blank">
				<div class="form-group">
					<div class="row">
						<div class="col-md-12"><label for="">Tahun Anggaran dan Bulan</label></div>
						<div class="col-md-8">
							<select id="tahun" name="tahun" class="form-control" required>
								<?php
								$sqltahun = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran ASC");
								while ($t = mysqli_fetch_array($sqltahun)) {
									$selected = ($t['nmTahunAjaran'] == $tahun) ? ' selected="selected"' : "";
									echo "<option value=" . $t['nmTahunAjaran'] . " " . $selected . ">" . $t['nmTahunAjaran'] . "</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-4">
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
						</div>
					</div>
				</div>



				<div class="form-group">
					<label for="">Jenis Pembayaran</label>
					<select id="jenisBayar1" name="jenisBayar" class="form-control" required>
						<?php
						
						$sqlJB = mysqli_query($conn, "SELECT * FROM jenis_bayar WHERE idTahunAjaran='$tahun' ORDER BY idJenisBayar ASC");
						while ($jb = mysqli_fetch_array($sqlJB)) {
							$selected = ($jb['idJenisBayar'] == $jenis) ? ' selected="selected"' : "";
							echo "<option value=" . $jb['idJenisBayar'] . " " . $selected . ">" . $jb['nmJenisBayar'] . "</option>";
						}
						?>
					</select>
				</div>
				<!--<div class="form-group">
					<label for="">Dari Bulan</label>
					<input type="text" name="bulan1" placeholder="Pilih Bulan dan Tahun" class="form-control date-picker-rekap" readonly>
				</div>
				<div class="form-group">
					<label for="">Sampai Bulan</label>
					<input type="text" name="bulan2" placeholder="Pilih Bulan dan Tahun" class="form-control date-picker-rekap" readonly>
				</div>-->
				<?php
				$tgl_sekarang    = strtotime("Y");
				$tgl_kemarin    = date('Y', strtotime("-1 year", $tgl_sekarang));
				?>


				
				<div class="form-group">
					<label for=""></label>
					<input type="submit" value="Cetak Laporan" class="btn btn-primary pull-right">
				</div>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>