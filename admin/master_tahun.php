<?php if ($_GET['act'] == '') { ?>
	<div class="col-xs-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Data Tahun Anggaran </h3>
				<a class='pull-right btn btn-primary btn-sm' href='index.php?view=tahun&act=tambah'>Tambahkan Data Tahun </a>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				if (isset($_GET['sukses'])) {
					echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil Di Proses,..
                          </div>";
				} elseif (isset($_GET['gagal'])) {
					echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data tidak Di Proses, terjadi kesalahan dengan data..
                          </div>";
				}
				?>
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Tahun Anggaran</th>
							<th>Aktif</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tampil = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran DESC");
						$no = 1;
						while ($r = mysqli_fetch_array($tampil)) {
							if ($r['aktif'] == 'T') {
								$a = 'Y';
								$icon = "fa-close";
								$btn = "btn-danger";
								$alt = "Aktifkan";
								$onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=tahun&act=onoff&id=$r[idTahunAjaran]&a=$a'><span class='fa $icon'></span></a>";
							} else {
								$icon = "fa-check";
								$btn = "btn-success";
								$onoff = "<a class='btn $btn btn-xs' href='#'><span class='fa $icon'></span></a>";
							}
							echo "<tr><td>$no</td>
                              <td>$r[nmTahunAjaran]</td>
                              <td>$onoff</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=tahun&act=edit&id=$r[idTahunAjaran]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=tahun&hapus&id=$r[idTahunAjaran]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
							echo "</tr>";
							$no++;
						}
						if (isset($_GET['hapus'])) {
							mysqli_query($conn, "DELETE FROM tahun_ajaran where idTahunAjaran='$_GET[id]'");
							echo "<script>document.location='index.php?view=tahun';</script>";
						}

						?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
<?php
} elseif ($_GET['act'] == 'onoff') {
	$query = mysqli_query($conn, "UPDATE tahun_ajaran SET aktif='Y' where idTahunAjaran = '$_GET[id]'");
	mysqli_query($conn, "UPDATE tahun_ajaran SET aktif='T' where idTahunAjaran != '$_GET[id]'");
	if ($query) {
		echo "<script>document.location='index.php?view=tahun';</script>";
	} else {
		echo "<script>document.location='index.php?view=tahun';</script>";
	}
} elseif ($_GET['act'] == 'edit') {
	if (isset($_POST['update'])) {

		$query = mysqli_query($conn, "UPDATE tahun_ajaran SET nmTahunAjaran='$_POST[nmTahun]' where idTahunAjaran = '$_POST[id]'");
		//, aktif='$_POST[aktif]' 
		if ($query) {
			echo "<script>document.location='index.php?view=tahun&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=tahun&gagal';</script>";
		}
	}
	$edit = mysqli_query($conn, "SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[id]'");
	$record = mysqli_fetch_array($edit);
?>
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Edit Data Tahun Anggaran </h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $record['idTahunAjaran']; ?>">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Tahun Anggaran </label>
						<div class="col-sm-6">
							<input type="text" name="nmTahun" maxlength="9" class="form-control" value="<?php echo $record['nmTahunAjaran']; ?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input type="submit" name="update" value="Update" class="btn btn-success">
							<a href="index.php?view=tahun" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
} elseif ($_GET['act'] == 'tambah') {
	if (isset($_POST['tambah'])) {
		$query = mysqli_query($conn, "INSERT INTO tahun_ajaran(nmTahunAjaran) VALUES('$_POST[nmTahun]')");
		if ($query) {
			echo "<script>document.location='index.php?view=tahun&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=tahun&gagal';</script>";
		}
	}
?>
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Tambah Data Tahun Anggaran </h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="POST" action="" class="form-horizontal">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Tahun Anggaran</label>
						<div class="col-sm-6">
							<input type="text" name="nmTahun" maxlength="9" class="form-control" id="" placeholder="0000/9999" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input type="submit" name="tambah" value="Simpan" class="btn btn-success">
							<a href="index.php?view=tahun" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
}
?>