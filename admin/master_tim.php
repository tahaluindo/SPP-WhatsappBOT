<?php
include 'config/rupiah.php';
if ($_GET['act'] == '') {
	if (isset($_GET['kelas']) && $_GET['kelas'] != "") {
		if (isset($_GET['status']) && $_GET['status'] != "") {
			$tampil = mysqli_query($conn, "SELECT * FROM view_detil_siswa WHERE idKelas='$_GET[kelas]' AND statusSiswa='$_GET[status]' ORDER BY idKelas ASC");
		} else {
			$tampil = mysqli_query($conn, "SELECT * FROM view_detil_siswa WHERE idKelas='$_GET[kelas]' ORDER BY idKelas ASC");
		}
		$kelas = $_GET['kelas'];
	} else {
		$tampil = mysqli_query($conn, "SELECT * FROM view_detil_siswa ORDER BY idKelas ASC");
	}
	$ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
	$idTahun = $ta['idTahunAjaran'];
	$tahun = $ta['nmTahunAjaran'];
	$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas where npsn='10700295'"));
	$pos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pos_bayar where idPosBayar='$_GET[pos]'"));

	$idsiswa = $_GET['siswa'];
	$dtsiswa = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM view_detil_siswa where idSiswa='$_GET[siswa]'"));

	$namasiswa = $dtsiswa['nmSiswa'];
	$namakelas = $dtsiswa['nmKelas'];
?>
	<div class="col-xs-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Data TIM </h3>
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
				<form method="GET" action="" class="form-horizontal">
					<input type="hidden" name="view" value="tim" />
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>
									<select id="kelas" name="kelas" class="form-control">
										<option value="" selected> - Pilih Jabatan - </option>
										<?php
										$sqk = mysqli_query($conn, "SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
										while ($k = mysqli_fetch_array($sqk)) {
											$selected = ($k['idKelas'] == $kelas) ? ' selected="selected"' : "";
											echo "<option value=" . $k['idKelas'] . " " . $selected . ">" . $k['nmKelas'] . "</option>";
										}
										?>
									</select>
								</td>
								<td>
									<select class="form-control" name="status">
										<option value="">- Semua Status -</option>
										<option value="Aktif">Aktif</option>
										<option value="Non Aktif">Non Aktif</option>

									</select>
								</td>
								<td width="100">
									<input type="submit" name="tampil" value="Tampilkan" class="btn btn-success pull-right btn-sm">
								</td>
								<td>
									<span class="pull-right">
										<a class="btn btn-danger btn-sm" href="?view=tim&act=import">
											<i class="fa fa-file-excel-o"></i> Import Data TIM
										</a>
										<a class='btn btn-primary btn-sm' href='?view=tim&act=tambah'>Tambahkan Data</a>
									</span>
								</td>
							</tr>
						</tbody>
					</table>
				</form>


				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th>No</th>
								<th>NIK</th>
								<th>Nama Lengkap</th>
								<th>Jenis Kelamin</th>
								<th>Jabatan</th>
								<th>Atas Nama Rekening</th>
								<th>No Rekening</th>
								<th>Nama Bank</th>
								<th>Aksi</th>

							</tr>
						</thead>

						<tbody>
							<?php
							$no = 1;
							while ($r = mysqli_fetch_array($tampil)) {
								echo "<tr><td>$no</td>
							
								<td>" . $r['nisnSiswa'] . "</td>
								<td>" . $r['nmSiswa'] . "</td>
								<td>" . $r['jkSiswa'] . "</td>
								<td>" . $r['nmKelas'] . "</td>
								<td>" . $r['nmOrtu'] . "</td>
								<td>" . $r['noHpOrtu'] . "</td>
								<td>" . $r['noHpSis'] . "</td>																
								
								<td><center>
								<a class='btn btn-success btn-xs' title='Edit Data' href='?view=tim&act=edit&id=$r[idSiswa]'><span class='glyphicon glyphicon-edit'></span></a>
								<a class='btn btn-danger btn-xs' title='Delete Data' href='?view=tim&hapus&id=$r[idSiswa]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini? (Menghapus siswa berarti juga akan menghapus tagihan dan pembayaran!)')\"><span class='glyphicon glyphicon-remove'></span></a>
								
								
								</center></td>
								";
								echo "</tr>";
								$no++;
							}
							if (isset($_GET['hapus'])) {
								mysqli_query($conn, "DELETE FROM siswa where idSiswa='$_GET[id]'");
								echo "<script>document.location='?view=tim';</script>";
							}

							?>
						</tbody>
					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
<?php
} elseif ($_GET['act'] == 'edit') {
	if (isset($_POST['update'])) {
		$passs = md5($_POST['password']);
		if (trim($_POST['password']) == '') {
			$query = mysqli_query($conn, "UPDATE siswa SET nisnSiswa='$_POST[nisnSiswa]',nmSiswa='$_POST[nmSiswa]',jkSiswa='$_POST[jkSiswa]',idKelas='$_POST[idKelas]',statusSiswa='$_POST[statusSiswa]',nmOrtu='$_POST[nmOrtu]',username='$_POST[username]',alamatOrtu='$_POST[alamat]', noHpOrtu='$_POST[noHpOrtu]', noHpSis='$_POST[noHpsis]', noHp='$_POST[noHp]' WHERE idSiswa='$_POST[id]'");
		} else {
			$query = mysqli_query($conn, "UPDATE siswa SET nisnSiswa='$_POST[nisnSiswa]',nmSiswa='$_POST[nmSiswa]',jkSiswa='$_POST[jkSiswa]',idKelas='$_POST[idKelas]',statusSiswa='$_POST[statusSiswa]',nmOrtu='$_POST[nmOrtu]',username='$_POST[username]',password='$passs',alamatOrtu='$_POST[alamat]', noHpOrtu='$_POST[noHpOrtu]', noHpSis='$_POST[noHpsis]', noHp='$_POST[noHp]' WHERE idSiswa='$_POST[id]'");
		}
		if ($query) {
			echo "<script>document.location='?view=tim&sukses';</script>";
		} else {
			echo "<script>document.location='?view=tim&gagal';</script>";
		}
	}
	$edit = mysqli_query($conn, "SELECT * FROM view_detil_siswa where idSiswa='$_GET[id]'");
	$record = mysqli_fetch_array($edit);

	var_dump($record['noHpSis']);
?>
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Edit Data Siswa</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $record['idSiswa']; ?>">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">NIK</label>
						<div class="col-sm-6">
							<input type="text" name="nisnSiswa" class="form-control" value="<?php echo $record['nisnSiswa']; ?>" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Lengkap</label>
						<div class="col-sm-6">
							<input type="text" name="nmSiswa" class="form-control" value="<?php echo $record['nmSiswa']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Jenis Kelamin</label>
						<div class="col-sm-4">
							<select class="form-control" name="jkSiswa">
								<option value="<?php echo $record['jkSiswa']; ?>"><?php echo $record['jkSiswa']; ?></option>
								<option value="L">L</option>
								<option value="P">P</option>
							</select>
						</div>
					</div>


					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Jabatan</label>
						<div class="col-sm-4">
							<select name="idKelas" class="form-control">
								<?php
								$sqk = mysqli_query($conn, "SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
								while ($k = mysqli_fetch_array($sqk)) {
									$selected = ($k['idKelas'] == $record['idKelas']) ? ' selected="selected"' : "";

									echo '<option value="' . $k['idKelas'] . '" ' . $selected . '>' . $k['nmKelas'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nomor WhatsApp</label>
						<div class="col-sm-6">
							<input type="text" name="noHp" class="form-control" value="<?php echo $record['noHp']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Alamat</label>
						<div class="col-sm-6">
							<input type="text" name="alamat" class="form-control" value="<?php echo $record['alamatOrtu']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">No Rekening</label>
						<div class="col-sm-4">
							<input type="text" name="noHpOrtu" class="form-control" value="<?php echo $record['noHpOrtu']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Bank</label>
						<div class="col-sm-4">
							<input type="text" name="noHpsis" class="form-control" value="<?php echo $record['noHpSis']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Atas Nama Rekening</label>
						<div class="col-sm-4">
							<input type="text" name="nmOrtu" class="form-control" value="<?php echo $record['nmOrtu']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-4">
							<input type="text" name="username" class="form-control" value="<?php echo $record['username']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-4">
							<input type="password" name="password" class="form-control" value="<?php echo $record['password']; ?>" placeholder="" required>
						</div>
					</div>

					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select class="form-control" name="statusSiswa">
								<option value="<?php echo $record['statusSiswa']; ?>"><?php echo $record['statusSiswa']; ?></option>
								<option value="Aktif">Aktif</option>
								<option value="Non Aktif">Non Aktif</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input type="submit" name="update" value="Update" class="btn btn-success">
							<a href="?view=tim" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
} elseif ($_GET['act'] == 'tambah') {
	if (isset($_POST['tambah'])) {
		$passs = md5($_POST['password']);
		$query = mysqli_query($conn, "INSERT INTO siswa(nisnSiswa,nmSiswa,jkSiswa,idKelas,statusSiswa,alamatOrtu,noHpOrtu,noHpSis,nmOrtu,username,password,noHp) 
			VALUES('$_POST[nisnSiswa]','$_POST[nmSiswa]','$_POST[jkSiswa]','$_POST[idKelas]','$_POST[statusSiswa]','$_POST[alamat]','$_POST[noHpOrtu]','$_POST[noHpsis]','$_POST[nmOrtu]','$_POST[username]','$passs','$_POST[noHp]')");

		if ($query) {
			echo "<script>document.location='?view=tim&sukses';</script>";
		} else {
			echo "<script>document.location='?view=tim&gagal';</script>";
		}
	}
?>
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Tambah Data TIM</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="POST" action="" class="form-horizontal">

					<div class="form-group">
						<label for="" class="col-sm-2 control-label">NIK</label>
						<div class="col-sm-6">
							<input type="text" name="nisnSiswa" class="form-control" id="" placeholder="Masukkan NIK">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Lengkap</label>
						<div class="col-sm-6">
							<input type="text" name="nmSiswa" class="form-control" id="" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Jenis Kelamin</label>
						<div class="col-sm-4">
							<select class="form-control" name="jkSiswa">
								<option value="L">L</option>
								<option value="P">P</option>
							</select>
						</div>
					</div>


					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Jabatan</label>
						<div class="col-sm-4">
							<select name="idKelas" class="form-control">
								<?php
								$sqk = mysqli_query($conn, "SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
								while ($k = mysqli_fetch_array($sqk)) {
									echo "<option value=" . $k['idKelas'] . ">" . $k['nmKelas'] . "</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Alamat</label>
						<div class="col-sm-6">
							<input type="text" name="alamat" class="form-control" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">No WhatsApp</label>
						<div class="col-sm-4">
							<input type="text" name="noHp" class="form-control" placeholder="">
						</div>
					</div>


					<div class="form-group">
						<label for="" class="col-sm-2 control-label">No Rekening</label>
						<div class="col-sm-4">
							<input type="text" name="noHpOrtu" class="form-control" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Atas Nama Rekening </label>
						<div class="col-sm-4">
							<input type="text" name="nmOrtu" class="form-control" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Bank</label>
						<div class="col-sm-4">
							<input type="text" name="noHpsis" class="form-control" value="<?php echo $record['noHpSis']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-4">
							<input type="text" name="username" class="form-control" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-4">
							<input type="text" name="password" class="form-control" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-4">
							<select class="form-control" name="statusSiswa">
								<option value="Aktif">Aktif</option>
								<option value="Non Aktif">Non Aktif</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input type="submit" name="tambah" value="Simpan" class="btn btn-success">
							<a href="?view=tim" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
} elseif ($_GET['act'] == 'import') {
?>
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Import Data TIM</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				//jika tombol import ditekan
				if (isset($_POST['prosesimport'])) {

					$target = "temp/" . basename($_FILES['fileSiswa']['name']);
					move_uploaded_file($_FILES['fileSiswa']['tmp_name'], $target);

					$data = new Spreadsheet_Excel_Reader("temp/" . $_FILES['fileSiswa']['name'], false);

					//  menghitung jumlah baris file xls
					$baris = $data->rowcount($sheet_index = 0);

					//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
					for ($i = 2; $i <= $baris; $i++) {
						// membaca data (kolom ke-1 sd terakhir)
						$nik 		= $data->val($i, 1);
						$nama   	= $data->val($i, 2);
						$jabatan  	= $data->val($i, 3);
						$jk  		= $data->val($i, 4);
						$an  	= $data->val($i, 5);
						$bank 	= $data->val($i, 6);
						$norek = $data->val($i, 7);
						$noHp 	= $data->val($i, 8);
						$alamat 	= $data->val($i, 9);
						$username	= $data->val($i, 10);
						$password	= $data->val($i, 11);
						// setelah data dibaca, masukkan ke tabel pegawai sql
						$hasil = mysqli_query($conn, "INSERT INTO siswa(nisnSiswa,nmSiswa,jkSiswa,idKelas,alamatOrtu,noHpOrtu,noHpSis,nmOrtu,username,password,noHp) 
							VALUES('$nik','$nama','$jk','$jabatan','$alamat','$norek','$bank','$an','$username','$password',$noHp)");
					}

					if (!$hasil) {
						//          jika import gagal
						echo "<div class='alert alert-danger' role='alert'>
						Data Gagal Diimport....!<br>
						</div>";
					} else {
						//          jika impor berhasil
						echo "<div class='alert alert-success' role='alert'>
						Data Berhasil Diimport....!
						</div>";
					}
					//    hapus file xls yang udah dibaca
					unlink("temp/" . $_FILES['fileSiswa']['name']);
				}
				?>
				<form method="POST" action="" class="form-horizontal" onSubmit="return validateForm()" enctype="multipart/form-data">
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Download Format Data TIM</label>
						<div class="col-sm-8">
							<a href="./files/formatdatatim.xls" class="btn btn-info">formatdatatim.xls</a>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Pilih File Excel (.xls / Format Excel 2003)</label>
						<div class="col-sm-8">
							<input type="file" name="fileSiswa" class="form-control" id="fileSiswa" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label"></label>
						<div class="col-sm-8">
							<input type="submit" name="prosesimport" value="Proses Import" class="btn btn-success">
							<a href="?view=tim" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		//    validasi form (hanya file .xls yang diijinkan)
		function validateForm() {
			function hasExtension(inputID, exts) {
				var fileName = document.getElementById(inputID).value;
				return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
			}

			if (!hasExtension('fileSiswa', ['.xls'])) {
				alert("Hanya file XLS (Excel 2003) yang diizinkan.");
				return false;
			}
		}
	</script>
<?php
}
?>