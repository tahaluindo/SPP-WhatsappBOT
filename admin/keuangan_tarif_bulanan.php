<?php if ($_GET['act'] == '') {
	$sqlEdit = mysqli_query($conn,"SELECT
									jenis_bayar.*,
									pos_bayar.nmPosBayar,
									tahun_ajaran.nmTahunAjaran
								FROM
									jenis_bayar
								INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
								INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
								WHERE jenis_bayar.idJenisBayar='$_GET[jenis]'");
	$record = mysqli_fetch_array($sqlEdit);
?>
	<div class="col-xs-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">Tarif - <?php echo $record['nmJenisBayar']; ?></h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal">
					<input type="hidden" name="idJenisBayar" value="<?php echo $record['idJenisBayar']; ?>">
					<input type="hidden" name="tipeBayar" class="form-control" value="<?php echo $record['tipeBayar']; ?>">
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Tahun</label>
						<div class="col-sm-4">
							<input type="text" name="nmTahunAjaran" class="form-control" value="<?php echo $record['nmTahunAjaran']; ?>" readonly>
						</div>
						<label for="" class="col-sm-2 control-label">Jabatan</label>
						<div class="col-sm-2">
							<select name="idKelas" class="form-control">
								<?php
								$sqk = mysqli_query($conn,"SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
								while ($k = mysqli_fetch_array($sqk)) {
									echo "<option value=" . $k['idKelas'] . ">" . $k['nmKelas'] . "</option>";
								}
								?>
							</select>
						</div>
						<div class="col-sm-2">
							<input type="submit" name="cari" value="Cari / Tampilkan" class="btn btn-success">
						</div>
					</div>
				</form>
				<hr>
				<label for="" class="col-sm-2">Aksi</label>
				<div class="col-sm-10">
					<a class="btn btn-success" href="?view=tarif&jenis=<?php echo $record['idJenisBayar']; ?>&tipe=bulanan&act=tambah"><span class='glyphicon glyphicon-plus'></span> Tambah Data</a>
					<a class="btn btn-warning" href="?view=tarif&jenis=<?php echo $record['idJenisBayar']; ?>&tipe=bulanan"><span class='glyphicon glyphicon-refresh'></span> Refresh</a>
					<a class="btn btn-default" href="?view=jenisbayar"><span class='glyphicon glyphicon-repeat'></span> Kembali</a>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
		<?php
		if (isset($_POST['cari'])) {
			$sqlCariBulanan = mysqli_query($conn,"SELECT
												tagihan_bulanan.idTagihanBulanan,
												tagihan_bulanan.idJenisBayar,
												tagihan_bulanan.idSiswa,
												tagihan_bulanan.idKelas,
												tagihan_bulanan.idBulan,
												tagihan_bulanan.jumlahBayar,
												tagihan_bulanan.tglBayar,
												tagihan_bulanan.tglUpdate,
												tagihan_bulanan.statusBayar,
												
												siswa.nisnSiswa,
												siswa.nmSiswa,
												kelas_siswa.nmKelas
											FROM
												tagihan_bulanan
											INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
											INNER JOIN kelas_siswa ON tagihan_bulanan.idKelas = kelas_siswa.idKelas
											WHERE tagihan_bulanan.idJenisBayar='$_POST[idJenisBayar]'
												AND tagihan_bulanan.idKelas='$_POST[idKelas]' GROUP BY siswa.idSiswa");
		?>
			<div class="box box-primary">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>No.</th>
								
								<th>Nama Lengkap</th>
								<th>Jabatan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							while ($rt = mysqli_fetch_array($sqlCariBulanan)) {
								echo "<tr class='header1 expand'>
										<td><span class='btn btn-danger btn-xs sign'></span></td>
										<td>$no</td>

										<td>$rt[nmSiswa]</td>
										<td>$rt[nmKelas]</td>
										<td style='text-align:center'>
											<a class='btn btn-success btn-xs' href='?view=tarif&jenis=$rt[idJenisBayar]&tipe=bulanan&act=edit&siswa=$rt[idSiswa]'><span class='glyphicon glyphicon-edit'></span></a>
											<a class='btn btn-danger btn-xs' href='?view=tarif&jenis=$rt[idJenisBayar]&tipe=bulanan&act=hapus&siswa=$rt[idSiswa]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
										</td>
									</tr>
									<tr>										
										<td colspan='6'>
											<div class='panel panel-info'>
												<div class='panel-body'>
													<table class='table table-bordered table-striped'>
													  <thead>
														<tr>
															<th>Bulan</th>
															<th>Besar Tagihan</th>
															<th>Status Bayar</th>
														</tr>
													  </thead>
													  <tbody>";
								$sqlDTSiswa = mysqli_query($conn,"SELECT tagihan_bulanan.*,
																		bulan.nmBulan,bulan.urutan
																	FROM
																		tagihan_bulanan
																	INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
																	WHERE tagihan_bulanan.idJenisBayar='$rt[idJenisBayar]' AND tagihan_bulanan.idSiswa='$rt[idSiswa]' ORDER BY bulan.urutan ASC");
								while ($recdetil = mysqli_fetch_array($sqlDTSiswa)) {
									if ($recdetil['statusBayar'] == '1') {
										$statusBayar = "<label class='label label-success'>Lunas</label>";
									} else {
										$statusBayar = "<label class='label label-danger'>Belum Bayar</label>";
									}
									echo "<tr>
															  <td>$recdetil[nmBulan]</td>
															  <td>" . buatRp($recdetil['jumlahBayar']) . "</td>
															  <td>$statusBayar</td>
															</tr>";
								}
								echo "</tbody>
													</table>
												</div>
											</div>
										</td>
									</tr>";
								$no++;
							}
							?>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		<?php
		}
		?>
	</div>
<?php
} elseif ($_GET['act'] == 'edit') {
	if (isset($_POST['update'])) {
		$nn = 12; // membaca jumlah data
		// looping
		for ($i = 1; $i <= $nn; $i++) {
			$idts = $_POST['idt' . $i];
			$jmlBayar = $_POST['n' . $i];

			$query = mysqli_query($conn,"UPDATE tagihan_bulanan SET jumlahBayar='$jmlBayar'
										WHERE idTagihanBulanan='$idts'");
		}
		if ($query) {
			echo "<script>document.location='index.php?view=jenisbayar&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=jenisbayar&gagal';</script>";
		}
	}

	$sqlEdit = mysqli_query($conn,"SELECT tagihan_bulanan.idTagihanBulanan,
							tagihan_bulanan.idJenisBayar,
							tagihan_bulanan.idSiswa,
							tagihan_bulanan.idKelas,
							tagihan_bulanan.idBulan,
							tagihan_bulanan.jumlahBayar,
							tagihan_bulanan.tglBayar,
							tagihan_bulanan.tglUpdate,
							tagihan_bulanan.statusBayar,
							jenis_bayar.idPosBayar,
							jenis_bayar.idTahunAjaran,
							jenis_bayar.nmJenisBayar,
							jenis_bayar.tipeBayar,
							pos_bayar.nmPosBayar,
							tahun_ajaran.nmTahunAjaran,
							tahun_ajaran.aktif,
							
							siswa.nisnSiswa,
							siswa.nmSiswa,
							siswa.jkSiswa,
						
							siswa.statusSiswa,
							kelas_siswa.nmKelas,
							bulan.nmBulan,
							bulan.urutan
						FROM
							jenis_bayar
						INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
						INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
						INNER JOIN tagihan_bulanan ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
						INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
						INNER JOIN kelas_siswa ON tagihan_bulanan.idKelas = kelas_siswa.idKelas
						INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
						WHERE jenis_bayar.idJenisBayar='$_GET[jenis]' AND tagihan_bulanan.idSiswa='$_GET[siswa]' ORDER BY bulan.urutan ASC");
	$record = mysqli_fetch_array($sqlEdit);
?>
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> Edit Tarif Bulanan Siswa</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal">
					<div class="col-sm-5">
						<div class="box box-solid box-danger">
							<div class="box-header">
								<h3 class="box-title">Informasi Tagihan</h3>
							</div>
							<div class="box-body">
								<input type="hidden" name="idJenisBayar" value="<?php echo $record['idJenisBayar']; ?>">
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
									<div class="col-sm-8">
										<input type="text" name="nmJenisBayar" class="form-control" value="<?php echo $record['nmJenisBayar']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Tahun</label>
									<div class="col-sm-4">
										<input type="text" name="nmTahunAjaran" class="form-control" value="<?php echo $record['nmTahunAjaran']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
									<div class="col-sm-4">
										<input type="text" name="tipeBayar" class="form-control" value="<?php echo $record['tipeBayar']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Kelas</label>
									<div class="col-sm-4">
										<input type="text" name="tipeBayar" class="form-control" value="<?php echo $record['nmKelas']; ?>" readonly>
									</div>
								</div>
								
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Nama Siswa</label>
									<div class="col-sm-8">
										<input type="text" name="tipeBayar" class="form-control" value="<?php echo $record['nmSiswa']; ?>" readonly>
									</div>
								</div>
							</div>
						</div>
						<div class="box box-solid box-warning">
							<div class="box-header">
								<h3 class="box-title">Tarif Setiap Bulan Sama</h3>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Tarif (Rp.)</label>
									<div class="col-sm-4">
										<input type="text" id="allTarif" name="allTarif" class="form-control harusAngka">
									</div>
									<div class="col-sm-4">
										<i>Masukkan Nilai dan Tekan Enter</i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="box box-solid box-success">
							<div class="box-header">
								<h3 class="box-title">Tarif Setiap Bulan Tidak Sama</h3>
							</div>
							<div class="box-body">
								<table class="table table-striped">
									<?php
									$sqlEdit1 = mysqli_query($conn,"SELECT tagihan_bulanan.idTagihanBulanan,
												tagihan_bulanan.idJenisBayar,
												tagihan_bulanan.idSiswa,
												tagihan_bulanan.idKelas,
												tagihan_bulanan.idBulan,
												tagihan_bulanan.jumlahBayar,
												tagihan_bulanan.tglBayar,
												tagihan_bulanan.tglUpdate,
												tagihan_bulanan.statusBayar,
												jenis_bayar.idPosBayar,
												jenis_bayar.idTahunAjaran,
												jenis_bayar.nmJenisBayar,
												jenis_bayar.tipeBayar,
												pos_bayar.nmPosBayar,
												tahun_ajaran.nmTahunAjaran,
												tahun_ajaran.aktif,
												
												siswa.nisnSiswa,
												siswa.nmSiswa,
												siswa.jkSiswa,
											
												siswa.statusSiswa,
												kelas_siswa.nmKelas,
												bulan.nmBulan, bulan.urutan
											FROM
												jenis_bayar
											INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
											INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
											INNER JOIN tagihan_bulanan ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
											INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
											INNER JOIN kelas_siswa ON tagihan_bulanan.idKelas = kelas_siswa.idKelas
											INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
											WHERE jenis_bayar.idJenisBayar='$_GET[jenis]' AND tagihan_bulanan.idSiswa='$_GET[siswa]' ORDER BY bulan.urutan ASC");
									while ($rec = mysqli_fetch_array($sqlEdit1)) {
									?>
										<tr>
											<input type="hidden" name="idt<?php echo $rec['idBulan']; ?>" value="<?php echo $rec['idTagihanBulanan']; ?>">
											<td><?php echo $rec['nmBulan']; ?></td>
											<td>
												<div class="col-sm-4">
													<input type="text" id="n<?php echo $rec['idBulan']; ?>" name="n<?php echo $rec['idBulan']; ?>" class="form-control harusAngka" value="<?php echo $rec['jumlahBayar']; ?>" />
												</div>
											</td>
										</tr>
									<?php
									}
									?>
								</table>
							</div>
							<div class="box-footer">
								<input type="submit" name="update" value="Update Tarif" class="btn btn-primary">
								<a href="index.php?view=jenisbayar" class="btn btn-default">Cancel</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
} elseif ($_GET['act'] == 'tambah') {
	if (isset($_POST['simpan'])) {
		$idJenisBayar = $_POST['idJenisBayar'];
		$idKelas = $_POST['idKelas'];
		//$sqlSiswa=mysqli_query($conn,"SELECT * FROM siswa WHERE idKelas='$_POST[idKelas]'");
		$sqlSiswa = mysqli_query($conn,"SELECT * FROM siswa WHERE idSiswa NOT IN (SELECT idSiswa FROM tagihan_bulanan WHERE idJenisBayar='$idJenisBayar') AND idKelas='$_POST[idKelas]' AND statusSiswa='Aktif'");
		$jmlSiswa = mysqli_num_rows($sqlSiswa);

		//nilai tarif
		$dt1 = $_POST['n1'];
		$dt2 = $_POST['n2'];
		$dt3 = $_POST['n3'];
		$dt4 = $_POST['n4'];
		$dt5 = $_POST['n5'];
		$dt6 = $_POST['n6'];
		$dt7 = $_POST['n7'];
		$dt8 = $_POST['n8'];
		$dt9 = $_POST['n9'];
		$dt10 = $_POST['n10'];
		$dt11 = $_POST['n11'];
		$dt12 = $_POST['n12'];

		while ($ds = mysqli_fetch_array($sqlSiswa)) {
			$idSiswa = $ds['idSiswa'];
			$jmlbulan = 12;
			for ($j = 1; $j <= $jmlbulan; $j++) {
				switch ($j) {
					case 1:
						$dt = $dt1;
						break;
					case 2:
						$dt = $dt2;
						break;
					case 3:
						$dt = $dt3;
						break;
					case 4:
						$dt = $dt4;
						break;
					case 5:
						$dt = $dt5;
						break;
					case 6:
						$dt = $dt6;
						break;
					case 7:
						$dt = $dt7;
						break;
					case 8:
						$dt = $dt8;
						break;
					case 9:
						$dt = $dt9;
						break;
					case 10:
						$dt = $dt10;
						break;
					case 11:
						$dt = $dt11;
						break;
					case 12:
						$dt = $dt12;
						break;
					default:
						$dt = "";
				}
				$query = mysqli_query($conn,"INSERT INTO tagihan_bulanan(idJenisBayar,idSiswa,idKelas,idBulan,jumlahBayar)
									VALUES('$idJenisBayar',
										'$idSiswa',
										'$idKelas',
										'$j',
										'$dt')");
			}
		}

		if ($query) {
			echo "<script>document.location='index.php?view=tarif&jenis=$idJenisBayar&tipe=bulanan&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=tarif&jenis=$idJenisBayar&tipe=bulanan&gagal';</script>";
		}
	}

	$sqlEdit = mysqli_query($conn,"SELECT
							jenis_bayar.*,
							pos_bayar.nmPosBayar,
							tahun_ajaran.nmTahunAjaran
						FROM
							jenis_bayar
						INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
						INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
						WHERE jenis_bayar.idJenisBayar='$_GET[jenis]'");
	$record = mysqli_fetch_array($sqlEdit);
?>
	<div class="col-md-12">
		<div class="box box-solid box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"> Menambah Tarif / Tagihan Bulanan Siswa Per Kelas</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal">
					<div class="col-sm-5">
						<div class="box box-solid box-danger">
							<div class="box-header">
								<h3 class="box-title">Pilih Kelas</h3>
							</div>
							<div class="box-body">
								<input type="hidden" name="idJenisBayar" value="<?php echo $record['idJenisBayar']; ?>">
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
									<div class="col-sm-8">
										<input type="text" name="nmJenisBayar" class="form-control" value="<?php echo $record['nmJenisBayar']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Tahun</label>
									<div class="col-sm-8">
										<input type="text" name="nmTahunAjaran" class="form-control" value="<?php echo $record['nmTahunAjaran']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
									<div class="col-sm-8">
										<input type="text" name="tipeBayar" class="form-control" value="<?php echo $record['tipeBayar']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Kelas</label>
									<div class="col-sm-8">
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
							</div>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="box box-solid box-warning">
							<div class="box-header">
								<h3 class="box-title">Tarif Setiap Bulan Sama</h3>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Tarif Bulanan (Rp.)</label>
									<div class="col-sm-4">
										<input type="text" id="allTarif" name="allTarif" class="form-control harusAngka">
									</div>
									<div class="col-sm-4">
										<i>Masukkan Nilai dan Tekan Enter</i>
									</div>
								</div>
							</div>
						</div>
						<div class="box box-solid box-success">
							<div class="box-header">
								<h3 class="box-title">Tarif Setiap Bulan Tidak Sama</h3>
							</div>
							<div class="table-responsive">
								<table class="table-responsive">
									<tr>
										<td>Juli</td>
										<td><input type="text" id="n7" name="n7" class="form-control harusAngka"></td>
										<td>Januari</td>
										<td><input type="text" id="n1" name="n1" class="form-control harusAngka"></td>
									</tr>
									<tr>
										<td>Agustus</td>
										<td><input type="text" id="n8" name="n8" class="form-control harusAngka"></td>
										<td>Februari</td>
										<td><input type="text" id="n2" name="n2" class="form-control harusAngka"></td>
									</tr>
									<tr>
										<td>September</td>
										<td><input type="text" id="n9" name="n9" class="form-control harusAngka"></td>
										<td>Maret</td>
										<td><input type="text" id="n3" name="n3" class="form-control harusAngka"></td>
									</tr>
									<tr>
										<td>Oktober</td>
										<td><input type="text" id="n10" name="n10" class="form-control harusAngka"></td>
										<td>April</td>
										<td><input type="text" id="n4" name="n4" class="form-control harusAngka"></td>
									</tr>
									<tr>
										<td>November</td>
										<td><input type="text" id="n11" name="n11" class="form-control harusAngka"></td>
										<td>Mei</td>
										<td><input type="text" id="n5" name="n5" class="form-control harusAngka"></td>
									</tr>
									<tr>
										<td>Desember</td>
										<td><input type="text" id="n12" name="n12" class="form-control harusAngka"></td>
										<td>Juni</td>
										<td><input type="text" id="n6" name="n6" class="form-control harusAngka"></td>
									</tr>
								</table>
							</div>
							<div class="box-footer">
								<input type="submit" name="simpan" value="Simpan Tarif" class="btn btn-success">
								<a href="index.php?view=jenisbayar" class="btn btn-default">Cancel</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
} elseif ($_GET['act'] == 'hapus') {
	$hapus = mysqli_query($conn,"DELETE FROM tagihan_bulanan WHERE idJenisBayar='$_GET[jenis]' AND idSiswa='$_GET[siswa]'");
	if ($hapus) {
		//echo "<script>document.location='index.php?view=jenisbayar&sukseshapus';</script>";
		echo "<script>document.location='index.php?view=tarif&jenis=$_GET[jenis]&tipe=bulanan';</script>";
	}
}
?>