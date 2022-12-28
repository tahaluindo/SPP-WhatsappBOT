<?php
$tahun = $ta['idTahunAjaran'];
$jenis = '';
$kelas = '';
?>
<div class="col-xs-6">
	<div class="box box-warning box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Rekap Pengeluaran</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="cetak_rekap_pengeluaran.php" role="form" target="_blank">
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
					<label for=""></label>
					<input type="submit" value="Cetak Laporan Print" class="btn btn-warning pull-right">
				</div>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>
<div class="col-xs-6">
	<div class="box box-info box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Rekap Pengeluaran</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="excel_rekap_pengeluaran.php" role="form" target="_blank">
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
					<label for=""></label>
					<input type="submit" value="Cetak Laporan Excel"   class="btn btn-info pull-right ">
				</div>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>