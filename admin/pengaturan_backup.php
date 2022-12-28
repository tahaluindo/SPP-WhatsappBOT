<?php

if (isset($_POST['backup'])) {

?>
	<div class="col-md-12">
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"> Pengaturan Identitas</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="npsn" value="<?php echo $record['npsn']; ?>">
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Nama Sekolah</label>
						<div class="col-sm-4">
							<input type="text" name="nmSekolah" class="form-control" value="<?php echo $record['nmSekolah']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Alamat Sekolah</label>
						<div class="col-sm-6">
							<input type="text" name="alamat" class="form-control" value="<?php echo $record['alamat']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Kabupaten/Kota</label>
						<div class="col-sm-6">
							<input type="text" name="kabupaten" class="form-control" value="<?php echo $record['kabupaten']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Propinsi</label>
						<div class="col-sm-6">
							<input type="text" name="propinsi" class="form-control" value="<?php echo $record['propinsi']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">NIY Kepsek</label>
						<div class="col-sm-2">
							<input type="text" name="nipKepsek" class="form-control" value="<?php echo $record['nipKepsek']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Nama Kepsek</label>
						<div class="col-sm-4">
							<input type="text" name="nmKepsek" class="form-control" value="<?php echo $record['nmKepsek']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">NIY Ka. TU</label>
						<div class="col-sm-2">
							<input type="text" name="nipKaTU" class="form-control" value="<?php echo $record['nipKaTU']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Nama Ka. TU</label>
						<div class="col-sm-4">
							<input type="text" name="nmKaTU" class="form-control" value="<?php echo $record['nmKaTU']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">NIY Bendahara</label>
						<div class="col-sm-2">
							<input type="text" name="nipBendahara" class="form-control" value="<?php echo $record['nipBendahara']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Nama Bendahara</label>
						<div class="col-sm-4">
							<input type="text" name="nmBendahara" class="form-control" value="<?php echo $record['nmBendahara']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Ganti Logo Kiri</label>
						<div class="col-sm-6">
							<input type="file" name="flogokiri" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Ganti Logo Kanan</label>
						<div class="col-sm-6">
							<input type="file" name="flogokanan" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label"></label>
						<div class="col-sm-6">
							<input type="submit" name="update" value="Perbaharui Data" class="btn btn-success">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php } ?>