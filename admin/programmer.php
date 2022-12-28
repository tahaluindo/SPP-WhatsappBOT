<?php
include 'config/rupiah.php';
if ($_GET['act'] == '') {
	$tampil = mysqli_query($conn, "SELECT * FROM programmer ORDER BY idProgrammer ASC");
	$ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
	$idTahun = $ta['idTahunAjaran'];
	$tahun = $ta['nmTahunAjaran'];
	$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas where npsn='10700295'"));
	$pos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pos_bayar where idPosBayar='$_GET[pos]'"));
?>
	<div class="col-xs-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Data Programmer </h3>
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
					<input type="hidden" name="view" value="programmer" />
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>
									<span class="pull-right">
										<a class='btn btn-primary btn-sm' href='?view=programmer&act=tambah'>Tambahkan Data</a>
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
								<th>Nama Lengkap</th>
								<th>Jenis Kelamin</th>
								<!--<th>Alamat</th>-->
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
								<td>" . $r['nmProgrammer'] . "</td>
								<td>" . $r['jkProgrammer'] . "</td>
								<!--<td>" . $r['alamatProgrammer'] . "</td>-->
							
								<td>" . $r['atasnamaRekening'] . "</td>
								<td>" . $r['noRekening'] . "</td>
								<td>" . $r['nmBank'] . "</td>
								<td><center>
								<a class='btn btn-info btn-xs' title='Wa' href='https://wa.me/$r[noProgrammer]' target='_blank'><span class='fa fa-whatsapp'></span> Chat</a>
								<a href='#lihat" . $r['idProgrammer'] . "' data-toggle='modal' class='btn btn-xs btn-warning'><i class='fa fa-eye' data-toggle='tooltip' title='' data-original-title='Lihat Data Diri'></i> Lihat Data Diri </a>
								<a class='btn btn-success btn-xs' title='Edit Data' href='?view=programmer&act=edit&id=$r[idProgrammer]'><span class='glyphicon glyphicon-edit'></span></a>
								<a class='btn btn-danger btn-xs' title='Delete Data' href='?view=programmer&hapus&id=$r[idProgrammer]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini? (Menghapus programmer berarti juga akan menghapus tagihan dan pembayaran!)')\"><span class='glyphicon glyphicon-remove'></span></a>
								
								
								</center></td>
								";
								echo "</tr>";
								echo '<div class="modal modal-default fade" id="lihat' . $r['idProgrammer'] . '">
								<div class="modal-dialog">
								  <div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span></button>
										<h3 class="modal-title">Data Diri ' . $r['nmProgrammer'] . '</h3>
									  </div>
									  <div class="modal-body">
									  <embed src="programmer/' . $r['file'] . '" type="application/pdf" width="560" height="400">
									  </div>
									  <div class="modal-footer">
										<form action="?view=' . $_GET['view'] . '" method="post" accept-charset="utf-8">
										  <input type="hidden" name="id" value="' . $r['idProgrammer'] . '"> 
										  <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Tutup</button>
					
										</form>
									  </div>
									</div>
								  </div>
								</div>';
								$no++;
							}
							if (isset($_GET['hapus'])) {
								mysqli_query($conn, "DELETE FROM programmer where idprogrammer='$_GET[id]'");
								echo "<script>document.location='?view=programmer';</script>";
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
		//pengecekan tipe harus pdf
		$tipe_file = $_FILES['nama_file']['type'];
		$tmp_file = $_FILES['nama_file']['tmp_name'];
		if ($tipe_file == "application/pdf") {
			$nama_file = trim($_FILES['nama_file']['name']);
			$path = "programmer/" . $nama_file; //mendapatkan mime type
			if (move_uploaded_file($tmp_file, $path)) {
				$query = mysqli_query($conn, "UPDATE programmer SET nmProgrammer='$_POST[nmProgrammer]',jkProgrammer='$_POST[jkProgrammer]',
									alamatProgrammer='$_POST[alamatProgrammer]',noProgrammer='$_POST[noProgrammer]',
									atasnamaRekening='$_POST[atasnamaRekening]',noRekening='$_POST[noRekening]', nmBank='$_POST[nmBank]',file='$nama_file' WHERE idProgrammer='$_POST[id]'");
			}
		} else {
			$query = mysqli_query($conn, "UPDATE programmer SET nmProgrammer='$_POST[nmProgrammer]',jkProgrammer='$_POST[jkProgrammer]',
			alamatProgrammer='$_POST[alamatProgrammer]',noProgrammer='$_POST[noProgrammer]',
			atasnamaRekening='$_POST[atasnamaRekening]',noRekening='$_POST[noRekening]', nmBank='$_POST[nmBank]' WHERE idProgrammer='$_POST[id]'");
		}
		if ($query) {
			echo "<script>document.location='?view=programmer&sukses';</script>";
		} else {
			echo "<script>document.location='?view=programmer&gagal';</script>";
		}
	}
	$edit = mysqli_query($conn, "SELECT * FROM programmer where idProgrammer='$_GET[id]'");
	$record = mysqli_fetch_array($edit);

?>
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Edit Data programmer</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $record['idProgrammer']; ?>">

					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Programmer</label>
						<div class="col-sm-6">
							<input type="text" name="nmProgrammer" class="form-control" value="<?php echo $record['nmProgrammer']; ?>" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Alamat</label>
						<div class="col-sm-6">
							<input type="text" name="alamatProgrammer" class="form-control" value="<?php echo $record['alamatProgrammer']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Jenis Kelamin</label>
						<div class="col-sm-4">
							<select class="form-control" name="jkProgrammer">
								<option value="<?php echo $record['jkProgrammer']; ?>"><?php echo $record['jkProgrammer']; ?></option>
								<option value="L">L</option>
								<option value="P">P</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nomor WhatsApp</label>
						<div class="col-sm-6">
							<input type="text" name="noProgrammer" class="form-control" value="<?php echo $record['noProgrammer']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Rekening Atas nama</label>
						<div class="col-sm-6">
							<input type="text" name="atasnamaRekening" class="form-control" value="<?php echo $record['atasnamaRekening']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">No Rekening</label>
						<div class="col-sm-4">
							<input type="text" name="noRekening" class="form-control" value="<?php echo $record['noRekening']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Bank</label>
						<div class="col-sm-4">
							<input type="text" name="nmBank" class="form-control" value="<?php echo $record['nmBank']; ?>" placeholder="" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="" class=" control-label">File Surat Keluar</label>
							<embed src="programmer/<?php echo $record['file']; ?>" type="application/pdf" width="960" height="400">
							<input type="file" name="nama_file" accept=".pdf">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input type="submit" name="update" value="Update" class="btn btn-success">
							<a href="?view=programmer" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
} elseif ($_GET['act'] == 'tambah') {
	if (isset($_POST['tambah'])) {
		//pengecekan tipe harus pdf
		$tipe_file = $_FILES['nama_file']['type'];
		$tmp_file = $_FILES['nama_file']['tmp_name'];

		if ($tipe_file == "application/pdf") {

			$nama_file = trim($_FILES['nama_file']['name']);
			$path = "programmer/" . $nama_file; //mendapatkan mime type
			if (move_uploaded_file($tmp_file, $path)) {
				$query = mysqli_query($conn, "INSERT INTO programmer(nmProgrammer,jkProgrammer,alamatProgrammer,noProgrammer,atasnamaRekening,noRekening,nmBank,file) 
			VALUES('$_POST[nmProgrammer]','$_POST[jkProgrammer]','$_POST[alamatProgrammer]','$_POST[noProgrammer]','$_POST[atasnamaRekening]','$_POST[noRekening]','$_POST[nmBank]','$nama_file')");
			}
		} else {
			$query = mysqli_query($conn, "INSERT INTO programmer(nmProgrammer,jkProgrammer,alamatProgrammer,noProgrammer,atasnamaRekening,noRekening,nmBank) 
			VALUES('$_POST[nmProgrammer]','$_POST[jkProgrammer]','$_POST[alamatProgrammer]','$_POST[noProgrammer]','$_POST[atasnamaRekening]','$_POST[noRekening]','$_POST[nmBank]')");
		}


		if ($query) {
			echo "<script>document.location='?view=programmer&sukses';</script>";
		} else {
			echo "<script>document.location='?view=programmer&gagal';</script>";
		}
	}
?>
	<div class="col-md-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Tambah Data Programmer</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Programmer</label>
						<div class="col-sm-6">
							<input type="text" name="nmProgrammer" class="form-control" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Alamat</label>
						<div class="col-sm-6">
							<input type="text" name="alamatProgrammer" class="form-control" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Jenis Kelamin</label>
						<div class="col-sm-4">
							<select class="form-control" name="jkProgrammer">
								<option value="L">L</option>
								<option value="P">P</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nomor WhatsApp</label>
						<div class="col-sm-6">
							<input type="text" name="noProgrammer" class="form-control" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Rekening Atas nama</label>
						<div class="col-sm-6">
							<input type="text" name="atasnamaRekening" class="form-control" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">No Rekening</label>
						<div class="col-sm-4">
							<input type="text" name="noRekening" class="form-control" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Nama Bank</label>
						<div class="col-sm-4">
							<input type="text" name="nmBank" class="form-control" placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">File KTP </label>
						<input type="file" name="nama_file">
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<input type="submit" name="tambah" value="Simpan" class="btn btn-success">
							<a href="?view=programmer" class="btn btn-default">Cancel</a>
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

					$target = "temp/" . basename($_FILES['fileprogrammer']['name']);
					move_uploaded_file($_FILES['fileprogrammer']['tmp_name'], $target);

					$data = new Spreadsheet_Excel_Reader("temp/" . $_FILES['fileprogrammer']['name'], false);

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
						$hasil = mysqli_query($conn, "INSERT INTO programmer(nisnprogrammer,nmprogrammer,jkprogrammer,idProject,alamatOrtu,noHpOrtu,noHpSis,nmOrtu,username,password,noHp) 
							VALUES('$nik','$nama','$jk','$jabatan','$alamat','$norek','$bank','$an','$username','$password',$noHp)");
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
					unlink("temp/" . $_FILES['fileprogrammer']['name']);
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
							<input type="file" name="fileprogrammer" class="form-control" id="fileprogrammer" placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-4 control-label"></label>
						<div class="col-sm-8">
							<input type="submit" name="prosesimport" value="Proses Import" class="btn btn-success">
							<a href="?view=programmer" class="btn btn-default">Cancel</a>
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

			if (!hasExtension('fileprogrammer', ['.xls'])) {
				alert("Hanya file XLS (Excel 2003) yang diizinkan.");
				return false;
			}
		}
	</script>
<?php
}
?>