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
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">Tarif - <?php echo $record['nmJenisBayar']; ?></h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal">
					<input type="hidden" name="idJenisBayar" value="<?php echo $record['idJenisBayar']; ?>">
					<input type="hidden" name="tipeBayar" class="form-control" value="<?php echo $record['tipeBayar']; ?>">
					<input type="hidden" name="idTahunAjaran" class="form-control" value="<?php echo $record['idTahunAjaran']; ?>">
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
					<a class="btn btn-success" href="?view=tarif&jenis=<?php echo $record['idJenisBayar']; ?>&tahun=<?php echo $record['idTahunAjaran']; ?>&tipe=bebas&act=tambah"><span class='glyphicon glyphicon-plus'></span> Tambah Data</a>
					<a class="btn btn-warning" href="?view=tarif&jenis=<?php echo $record['idJenisBayar']; ?>&tipe=bebas"><span class='glyphicon glyphicon-refresh'></span> Refresh</a>
					<a class="btn btn-default" href="?view=jenisbayar"><span class='glyphicon glyphicon-repeat'></span> Kembali</a>
				</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
		<?php
		if (isset($_POST['cari'])) {
			$sqlCariBulanan = mysqli_query($conn,"SELECT
												tagihan_bebas.*,
											
												siswa.nisnSiswa,
												siswa.nmSiswa,
												kelas_siswa.nmKelas
											FROM
												tagihan_bebas
											INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
											INNER JOIN kelas_siswa ON tagihan_bebas.idKelas = kelas_siswa.idKelas
											WHERE tagihan_bebas.idJenisBayar='$_POST[idJenisBayar]'
												AND tagihan_bebas.idKelas='$_POST[idKelas]' GROUP BY siswa.idSiswa");
		?>
			<div class="box box-warning">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>No.</th>
								<th>NIK</th>
								<th>Nama Lengkap</th>
								<th>Jabatan</th>
								<th>Total Tagihan</th>
								<!--<th>Dibayar</th>
									<th>Status</th>-->
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							while ($rt = mysqli_fetch_array($sqlCariBulanan)) {
								if ($rt['statusBayar'] == 0) {
									$statusBayar = "<label class='label label-danger'>Belum Bayar</label>";
								} elseif ($rt['statusBayar'] == 1) {
									$statusBayar = "<label class='label label-warning'>Belum Lunas</label>";
								} else {
									$statusBayar = "<label class='label label-success'>Lunas</label>";
								}
								echo "<tr>
										<td>$no</td>
										<td>$rt[nisnSiswa]</td>
										<td>$rt[nmSiswa]</td>
										<td>$rt[nmKelas]</td>
										<td>" . buatRp($rt['totalTagihan']) . "</td>
										<!--<td>$rt[totalBayar]</td>
										<td>$statusBayar</td>-->
										<td style='text-align:center'>
											<a class='btn btn-success btn-xs' href='?view=tarif&jenis=$rt[idJenisBayar]&tipe=bebas&act=edit&siswa=$rt[idSiswa]'><span class='glyphicon glyphicon-edit'></span></a>
											<a class='btn btn-danger btn-xs' href='?view=tarif&jenis=$rt[idJenisBayar]&tipe=bebas&idtb=$rt[idTagihanBebas]&act=hapus' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
										</td>
									</tr>";
								$no++;
							}
							?>
						</tbody>
					</table>
				</div><!-- /.box-body -->
				<div class="box-footer">
					<a class="pull-right btn btn-danger" href="?view=tarif&jenis=<?php echo $_POST['idJenisBayar']; ?>&tipe=bebas&kelas=<?php echo $_POST['idKelas']; ?>&act=hapussekelas" onclick="return confirm('Apa anda yakin untuk hapus Data ini?')"><span class="glyphicon glyphicon-remove"></span> Kosongkan Tagihan Kelas Ini</a>
				</div>
			</div><!-- /.box -->
		<?php
		}
		?>
	</div>
<?php
} elseif ($_GET['act'] == 'edit') {
	if (isset($_POST['update'])) {
		$query = mysqli_query($conn,"UPDATE tagihan_bebas SET totalTagihan='$_POST[nTagihan]'
										WHERE idTagihanBebas='$_POST[idTagihanBebas]'");
		if ($query) {
			echo "<script>document.location='index.php?view=tarif&jenis=$_POST[idJenisBayar]&tipe=bebas&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=tarif&jenis=$_POST[idJenisBayar]&tipe=bebas&gagal';</script>";
		}
	}

	$sqlEdit = mysqli_query($conn,"SELECT tagihan_bebas.*,
							jenis_bayar.idPosBayar,
							jenis_bayar.idTahunAjaran,
							jenis_bayar.nmJenisBayar,
							jenis_bayar.tipeBayar,
							pos_bayar.nmPosBayar,
							tahun_ajaran.nmTahunAjaran,
							tahun_ajaran.aktif,
							
							siswa.nisnSiswa,
							siswa.nmSiswa,
						
							siswa.statusSiswa,
							kelas_siswa.nmKelas
						FROM
							jenis_bayar
						INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
						INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
						INNER JOIN tagihan_bebas ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
						INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
						INNER JOIN kelas_siswa ON tagihan_bebas.idKelas = kelas_siswa.idKelas
						WHERE jenis_bayar.idJenisBayar='$_GET[jenis]' AND tagihan_bebas.idSiswa='$_GET[siswa]'");
	$record = mysqli_fetch_array($sqlEdit);
?>
	<div class="col-md-6">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Edit Tagihan TIM</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal">
					<div class="col-sm-12">
						<div class="box box-solid box-danger">
							<div class="box-header">
								<h3 class="box-title">Informasi Tagihan</h3>
							</div>
							<div class="box-body">
								<input type="hidden" name="idJenisBayar" value="<?php echo $record['idJenisBayar']; ?>">
								<input type="hidden" name="idTagihanBebas" value="<?php echo $record['idTagihanBebas']; ?>">
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
									<label for="" class="col-sm-4 control-label">Bulan</label>
									<div class="col-sm-4">
										<input type="text" name="tipeBayar" class="form-control" value="<?php echo $record['idBulan']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Jabatan</label>
									<div class="col-sm-4">
										<input type="text" name="tipeBayar" class="form-control" value="<?php echo $record['nmKelas']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">NIK</label>
									<div class="col-sm-4">
										<input type="text" name="tipeBayar" class="form-control" value="<?php echo $record['nisnSiswa']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Nama Lengkap</label>
									<div class="col-sm-8">
										<input type="text" name="tipeBayar" class="form-control" value="<?php echo $record['nmSiswa']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Total Tagihan</label>
									<div class="col-sm-8">
										<input type="text" name="nTagihan" class="form-control" value="<?php echo $record['totalTagihan']; ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label"></label>
									<div class="col-sm-8">
										<input type="submit" name="update" value="Update Tagihan" class="btn btn-warning">
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
} elseif ($_GET['act'] == 'tambah') {
	if (isset($_POST['simpantagihanbebas'])) {
		//$nData = $_POST['jmldata']; // membaca jumlah data

		$siswa = $_POST['pilih'];
		$nData = count($siswa);

		$kelas = $_POST['idKelas'];
		$bulan = $_POST['idBulan'];
		$tagihan = $_POST['nTagihan'];

		$idJenisBayar = $_POST['idJenisBayar'];
		// looping
		for ($i = 0; $i < $nData; $i++) {
			$idSiswa = $siswa[$i];
			$idKelas = $kelas[$i];
			$idBulan = $bulan[$i];
			$nTagihan = $tagihan[$i];

			$query = mysqli_query($conn,"INSERT INTO tagihan_bebas(idJenisBayar,idSiswa,idKelas,idBulan,totalTagihan)
									VALUES('$idJenisBayar',
											'$idSiswa',
											'$idKelas',
											'$idBulan',
											'$nTagihan')");
		}

		if ($query) {
			echo "<script>document.location='index.php?view=tarif&jenis=$idJenisBayar&tipe=bebas&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=tarif&jenis=$idJenisBayar&tipe=bebas&gagal';</script>";
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
		<div class="box box-solid box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Tagihan Siswa Per Kelas</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div class="col-sm-5">
					<div class="box box-solid box-danger">
						<div class="box-header">
							<h3 class="box-title">Pilih Kelas</h3>
						</div>
						<div class="box-body">
							<form method="GET" action="" class="form-horizontal">
								<input type="hidden" name="view" value="tarif">
								<input type="hidden" name="jenis" value="<?php echo $record['idJenisBayar']; ?>">
								<input type="hidden" name="tahun" value="<?php echo $record['idTahunAjaran']; ?>">
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
									<div class="col-sm-8">
										<input type="text" name="tipe" class="form-control" value="<?php echo $record['tipeBayar']; ?>" readonly>
									</div>
								</div>
								<input type="hidden" name="act" value="tambah">
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
									<div class="col-sm-8">
										<input type="text" name="" class="form-control" value="<?php echo $record['nmJenisBayar']; ?>" readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Tahun</label>
									<div class="col-sm-8">
										<input type="text" name="" class="form-control" value="<?php echo $record['nmTahunAjaran']; ?>" readonly>
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
								<div class="form-group">
				
								<label for="" class="col-sm-4 control-label ">Bulan</label>
									<div class="col-sm-4">
										<select name="idBulan" class="form-control" >
											<?php
											$sqks = mysqli_query($conn,"SELECT * FROM bulan ");
											while ($ks = mysqli_fetch_array($sqks)) {
												echo "<option value=" . $ks['idBulan'] . ">" . $ks['nmBulan'] . "</option>";
											}
											?>
										</select>
									</div>
							</div>
								<div class="form-group">
									<label for="" class="col-sm-4 control-label"></label>
									<div class="col-sm-8">
										<input type="submit" name="tampil" class="btn btn-warning btn-sm" value="Tampilkan">
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="box box-solid box-warning">
						<div class="box-header">
							<h3 class="box-title">Tarif Sama</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Tarif (Rp.)</label>
								<div class="col-sm-4">
									<input type="text" id="allTarifBebas" name="allTarif" class="form-control harusAngka">
								</div>
								<div class="col-sm-4">
									<i>Masukkan Nilai dan Tekan Enter</i>
								</div>
							</div>
							
							
						</div>
					</div>
				</div>
				<div class="col-sm-7">
					<?php
					if (isset($_GET['tampil'])) {
						
						$sqlSiswaTagihan = mysqli_query($conn,"SELECT siswa.*, kelas_siswa.nmKelas
									FROM
										siswa
									INNER JOIN kelas_siswa ON siswa.idKelas = kelas_siswa.idKelas 
									WHERE siswa.idSiswa NOT IN (SELECT idSiswa FROM tagihan_bebas WHERE idJenisBayar='$_GET[jenis]' AND idKelas='$_GET[idKelas]') AND siswa.idKelas='$_GET[idKelas]' AND siswa.statusSiswa='Aktif'");
						//$n = mysql_num_rows($sqlSiswaTagihan); // membaca jumlah data
					?>
						<div class="box box-solid box-success">
							<div class="box-header">
								<h3 class="box-title">Tentukan Nominal</h3>
							</div>
							<form method="POST" action="" class="form-horizontal">
								<input type="hidden" name="idJenisBayar" value="<?php echo $_GET['jenis']; ?>">
								<div class="table-responsive">
									<table class="table table-striped">
										<tr>
											<th>No.</th>
											<th><input type="checkbox" id="parent"></th>
											<th>NIS</th>
											<th>Nama Siswa</th>
											<th>Kelas</th>
											<th>Besar Tagihan</th>
										</tr>
										<?php
										$no = 1;
										while ($ft = mysqli_fetch_array($sqlSiswaTagihan)) {
										?>
											<tr>
												<td><?php echo $no; ?></td>
												<td><input type="checkbox" name="pilih[]" value="<?php echo $ft['idSiswa']; ?>" class="child"></td>
												<td><?php echo $ft['nisSiswa']; ?></td>
												<td><?php echo $ft['nmSiswa']; ?></td>
												<td><?php echo $ft['nmKelas']; ?><br><br>Bulan</td>
												<td>
													<input type="hidden" name="idKelas[]" value="<?php echo $ft['idKelas']; ?>">
													<input type="text" id="nTagihan" name="nTagihan[]" class="form-control harusAngka nTagihan" required>
													<select name="idBulan[]" class="form-control" >
											<?php
											$sqks = mysqli_query($conn,"SELECT * FROM bulan ");
											while ($ks = mysqli_fetch_array($sqks)) {
												$selected = ($ks['idBulan'] == $_GET['idBulan']) ? ' selected="selected"' : "";
												
												echo "<option value=" . $_GET['idBulan'] . " " . $selected . ">" . $ks['nmBulan'] . "</option>";
											}
											?>
										</select>
												</td>
												
											</tr>
										<?php $no++;
										} ?>
									</table>
								</div>
								<div class="box-footer">
									<!--<input type="hidden" name="jmldata" value="<?php echo $n; ?>">-->
									<input type="submit" name="simpantagihanbebas" value="Simpan Tagihan" class="btn btn-success">
									<a href="index.php?view=jenisbayar" class="btn btn-default">Cancel</a>
								</div>
							</form>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php
} elseif ($_GET['act'] == 'hapus') {
	$idjenis = $_GET['jenis'];
	$hapus = mysqli_query($conn,"DELETE FROM tagihan_bebas WHERE idTagihanBebas='$_GET[idtb]'");
	if ($hapus) {
		echo "<script>document.location='index.php?view=tarif&jenis=$idjenis&tipe=bebas&sukseshapus';</script>";
	} else {
		echo "<script>document.location='index.php?view=tarif&jenis=$idjenis&tipe=bebas&gagalhapus';</script>";
	}
} elseif ($_GET['act'] == 'hapussekelas') {
	$idjenis = $_GET['jenis'];
	$hapus = mysqli_query($conn,"DELETE FROM tagihan_bebas WHERE idJenisBayar='$idjenis' AND idKelas='$_GET[kelas]' AND statusBayar='0'");
	if ($hapus) {
		echo "<script>document.location='index.php?view=tarif&jenis=$idjenis&tipe=bebas&sukseshapus';</script>";
	} else {
		echo "<script>document.location='index.php?view=tarif&jenis=$idjenis&tipe=bebas&gagalhapus';</script>";
	}
}
?>