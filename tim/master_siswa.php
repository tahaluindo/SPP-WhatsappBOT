<?php
include 'config/rupiah.php';
if ($_GET[act] == '') {
	if (isset($_GET['kelas']) && $_GET['kelas'] != "") {
		if (isset($_GET['status']) && $_GET['status'] != "") {
			$tampil = mysqli_query($conn,"SELECT * FROM view_detil_siswa WHERE idKelas='$_GET[kelas]' AND statusSiswa='$_GET[status]' ORDER BY idKelas ASC");
		} else {
			$tampil = mysqli_query($conn,"SELECT * FROM view_detil_siswa WHERE idKelas='$_GET[kelas]' ORDER BY idKelas ASC");
		}
		$kelas = $_GET['kelas'];
	} else {
		$tampil = mysqli_query($conn,"SELECT * FROM view_detil_siswa ORDER BY idKelas ASC");
	}
?>
	<div class="col-xs-12">
		<div class="box box-primary">
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
					<input type="hidden" name="view" value="siswa" />
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>
									<select id="kelas" name="kelas" class="form-control">
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
									<select class="form-control" name="status">
										<option value="">- Semua Status -</option>
										<option value="Aktif">Aktif</option>
										<option value="Non Aktif">Non Aktif</option>
										<option value="Drop Out">Drop Out</option>
										<option value="Pindah">Pindah</option>
										<option value="Lulus">Lulus</option>
									</select>
								</td>
								<td width="100">
									<input type="submit" name="tampil" value="Tampilkan" class="btn btn-success pull-right">
								</td>
								<td>

									<span class="pull-right">
										<a class="btn btn-danger" href="?view=siswa&act=import">
											<i class="fa fa-file-excel-o"></i> Import Data Siswa
										</a>
										<a class='btn btn-primary' href='?view=siswa&act=tambah'>Tambahkan Data</a>
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
								<th>NIS</th>
								<th>NISN</th>
								<th>Nama Siswa</th>
								<th>Jenis Kelamin</th>
								<th>Kelas</th>
								<th>Nama Ortu</th>
								<th>No.Hp</th>
								<th>Saldo Tabungan</th>
								<th width="40">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							while ($r = mysqli_fetch_array($tampil)) {
								echo "<tr><td>$no</td>
								<td>" . $r['nisSiswa'] . "</td>
								<td>" . $r['nisnSiswa'] . "</td>
								<td>" . $r['nmSiswa'] . "</td>
								<td>" . $r['jkSiswa'] . "</td>
								<td>" . $r['nmKelas'] . "</td>
								<td>" . $r['nmOrtu'] . "</td>
								<td>" . $r['noHpOrtu'] . "</td>
								<td>Rp." . rupiah($r['saldo']) . "</td>
								<td><center>
								<a class='btn btn-success btn-xs' title='Edit Data' href='?view=siswa&act=edit&id=$r[idSiswa]'><span class='glyphicon glyphicon-edit'></span></a>
								<a class='btn btn-danger btn-xs' title='Delete Data' href='?view=siswa&hapus&id=$r[idSiswa]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini? (Menghapus siswa berarti juga akan menghapus tagihan dan pembayaran!)')\"><span class='glyphicon glyphicon-remove'></span></a>
								</center></td>";
								echo "</tr>";
								$no++;
							}
							if (isset($_GET[hapus])) {
								mysqli_query($conn,"DELETE FROM siswa where idSiswa='$_GET[id]'");
								echo "<script>document.location='?view=home';</script>";
							}

							?>
						</tbody>
					</table>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
<?php
} elseif ($_GET[act] == 'edit') {
	if (isset($_POST[update])) {

		$query = mysqli_query($conn,"UPDATE siswa SET nisnSiswa='$_POST[nisnSiswa]',nmSiswa='$_POST[nmSiswa]',nmOrtu='$_POST[nmOrtu]',username='$_POST[username]',password='$_POST[password]',alamatOrtu='$_POST[alamat]',noHpOrtu='$_POST[noHpOrtu]',noHpSis='$_POST[noHpSis]'
			WHERE idSiswa='$_POST[id]'");
		if ($query) {
			echo "<script>document.location='?view=home';</script>";
		} else {
			echo "<script>document.location='?view=home';</script>";
		}
	}
	$edit = mysqli_query($conn,"SELECT * FROM view_detil_siswa where idSiswa='$_GET[id]'");
	$record = mysqli_fetch_array($edit);
?>
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> Edit Data Anda</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $record['idSiswa']; ?>">
			
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">NIK</label>
						<div class="col-sm-6">
							<input type="text" name="nisnSiswa" class="form-control" value="<?php echo $record['nisnSiswa']; ?>" placeholder="" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Lengkap</label>
						<div class="col-sm-6">
							<input type="text" name="nmSiswa" class="form-control" value="<?php echo $record['nmSiswa']; ?>" placeholder="" required>
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
							<input type="text" name="noHpSis" class="form-control" value="<?php echo $record['noHpSis']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Atas Nama</label>
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
							<input type="text" name="password" class="form-control" value="<?php echo $record['password']; ?>" placeholder="" required>
						</div>
					</div>

					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input type="submit" name="update" value="Update" class="btn btn-success">
							<a href="?view=home" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
} elseif ($_GET[act] == 'tambah') {
	if (isset($_POST[tambah])) {
		$query = mysqli_query($conn,"INSERT INTO siswa(nisSiswa,nisnSiswa,nmSiswa,jkSiswa,agamaSiswa,idKelas,nmOrtu,alamatOrtu,noHpOrtu) 
			VALUES('$_POST[nisSiswa]','$_POST[nisnSiswa]','$_POST[nmSiswa]','$_POST[jkSiswa]','$_POST[agamaSiswa]','$_POST[idKelas]','$_POST[nmOrtu]','$_POST[alamat]','$_POST[noHp]')");
		if ($query) {
			echo "<script>document.location='?view=siswa&sukses';</script>";
		} else {
			echo "<script>document.location='?view=siswa&gagal';</script>";
		}
	}
?>
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> Tambah Data Siswa</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="POST" action="" class="form-horizontal">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">NIS</label>
						<div class="col-sm-4">
							<input type="text" name="nisSiswa" class="form-control" id="" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">NISN</label>
						<div class="col-sm-6">
							<input type="text" name="nisnSiswa" class="form-control" id="" placeholder="Kolom ini otomatis akan menjadi  nomor  rekening di menu tabungan">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Siswa</label>
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
						<label for="" class="col-sm-2 control-label">Agama</label>
						<div class="col-sm-4">
							<select class="form-control" name="agamaSiswa">
								<option value="Islam">Islam</option>
								<option value="Katolik">Katolik</option>
								<option value="Protestan">Protestan</option>
								<option value="Hindu">Hindu</option>
								<option value="Budha">Budha</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Kelas</label>
						<div class="col-sm-4">
							<select name="idKelas" class="form-control">
								<?php
								$sqk = mysqli_query($conn,"SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
								while ($k = mysqli_fetch_array($sqk)) {
									echo "<option value=" . $k['idKelas'] . ">" . $k['nmKelas'] . "</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Ortu</label>
						<div class="col-sm-4">
							<input type="text" name="nmOrtu" class="form-control" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Alamat</label>
						<div class="col-sm-6">
							<input type="text" name="alamat" class="form-control" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">No.Hp</label>
						<div class="col-sm-4">
							<input type="text" name="noHp" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input type="submit" name="tambah" value="Simpan" class="btn btn-success">
							<a href="?view=siswa" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
} elseif ($_GET[act] == 'import') {
?>
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> Import Data Siswa</h3>
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
						$nis 		= $data->val($i, 1);
						$nisn   	= $data->val($i, 2);
						$nama  	= $data->val($i, 3);
						$jk  		= $data->val($i, 4);
						$agama  	= $data->val($i, 5);
						$idkelas 	= $data->val($i, 6);
						$alamat = $data->val($i, 7);
						$noHp 	= $data->val($i, 8);
						$nmOrtu 	= $data->val($i, 9);

						// setelah data dibaca, masukkan ke tabel pegawai sql
						$hasil = mysqli_query($conn,"INSERT INTO siswa(nisSiswa,nisnSiswa,nmSiswa,jkSiswa,agamaSiswa,idKelas,alamatOrtu,noHpOrtu,nmOrtu) 
							VALUES('$nis','$nisn','$nama','$jk','$agama','$idkelas','$alamat','$noHp','$nmOrtu')");
					}

					if (!$hasil) {
						//          jika import gagal

						echo "<div class='alert alert-danger' role='alert'>
						Data Gagal Diimport....!<br>" . die(mysql_error()) . "
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
						<label for="" class="col-sm-4 control-label">Download Format Data Siswa</label>
						<div class="col-sm-8">
							<a href="./files/formatdatasiswa.xls" class="btn btn-info">formatdatasiswa.xls</a>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Pilih File Excel (.xls / Format Excel 2003)</label>
						<div class="col-sm-8">
							<input type="file" name="fileSiswa" class="form-control" id="fileSiswa" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label"></label>
						<div class="col-sm-8">
							<input type="submit" name="prosesimport" value="Proses Import" class="btn btn-success">
							<a href="?view=siswa" class="btn btn-default">Cancel</a>
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