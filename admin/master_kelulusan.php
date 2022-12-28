<?php
if (isset($_GET['tampil'])) {
	$kelas = $_GET['idKelas'];
} else {
	$kelas = '';
}
?>
<div class="col-md-6">
	<div class="box box-solid box-primary">
		<div class="box-header with-border">
			<h3 class="box-title"> Pilih Kelas </h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="" class="form-horizontal">
				<input type="hidden" name="view" value="kelulusan">
				<div class="form-group">
					<label for="" class="col-sm-4 control-label">Kelas Awal</label>
					<div class="col-sm-4">
						<select name="idKelas" class="form-control">
							<?php
							$sqk = mysqli_query($conn,"SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
							while ($k = mysqli_fetch_array($sqk)) {
								$selected = ($k['idKelas'] == $kelas) ? ' selected="selected"' : "";
								echo "<option value=" . $k['idKelas'] . " " . $selected . ">" . $k['nmKelas'] . "</option>";
							}
							?>
						</select>
					</div>
					<div class="col-sm-4">
						<input type="submit" name="tampil" class="btn btn-warning" value="Tampilkan">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="box box-solid box-warning">
		<div class="box-body">
			<p>Warning!... !<br>Halaman ini digunakan untuk merubah status siswa menjadi lulus.
				Pastikan siswa yang di proses adalah siswa kelas XII</p>
		</div>
	</div>
</div>
<?php
if (isset($_GET['tampil'])) {
	$sqlSiswa = mysqli_query($conn,"SELECT siswa.*, kelas_siswa.nmKelas
					FROM
						siswa
					INNER JOIN kelas_siswa ON siswa.idKelas = kelas_siswa.idKelas 
					WHERE siswa.idKelas='$_GET[idKelas]' AND siswa.statusSiswa='Aktif'");
?>
	<div class="col-sm-12">
		<div class="box box-solid box-success">
			<div class="box-header">
				<h3 class="box-title">Pilih Siswa Yang Akan Diluluskan</h3>
			</div>
			<form method="POST" action="" class="form-horizontal">
				<div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>No.</th>
							<th>NIS</th>
							<th>Nama Siswa</th>
							<th>Kelas</th>
							<th><input type="checkbox" id="parent"> Pilih Semua</th>
						</tr>
						<?php
						$no = 1;
						while ($ft = mysqli_fetch_array($sqlSiswa)) {
						?>
							<tr>
								<td><?php echo $no; ?></td>
								<td><?php echo $ft['nisSiswa']; ?></td>
								<td><?php echo $ft['nmSiswa']; ?></td>
								<td><?php echo $ft['nmKelas']; ?></td>
								<td><input type="checkbox" name="pilih[]" value="<?php echo $ft['idSiswa']; ?>" class="child"></td>
							</tr>
						<?php $no++;
						} ?>
					</table>
				</div>
				<div class="box-footer">
					<div class="col-sm-4">
						<input type="submit" name="proses" class="btn btn-danger" value="Proses Lulus">
					</div>
				</div>
			</form>
		</div>
	</div>

<?php
	if (isset($_POST['proses'])) {
		$siswa = $_POST['pilih'];
		$jumlah_dipilih = count($siswa);

		for ($x = 0; $x < $jumlah_dipilih; $x++) {

			$query = mysqli_query($conn,"UPDATE siswa SET statusSiswa='Lulus' WHERE idSiswa='$siswa[$x]'");

			if ($query) {
				echo "<script>document.location='index.php?view=kelulusan&sukses';</script>";
			} else {
				echo "<script>document.location='index.php?view=kelulusan&gagal';</script>";
			}
		}
	}
}
?>