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
			<h3 class="box-title"> Pilih Bank Awal</h3>
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
			} elseif (isset($_GET['gagalsaldo'])) {
				echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Bank ini tidak memiliki saldo untuk dimutasi!!
                          </div>";
			} elseif (isset($_GET['gagalsaldomelebihi'])) {
				echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
					  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					  <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Jumlah mutasi melebihi saldo bank ini!!
					  </div>";
			}
			?>
			<form method="GET" action="" class="form-horizontal">
				<input type="hidden" name="view" value="mutasikas">
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Bank Awal</label>
					<div class="col-sm-6">
						<select name="id" class="form-control">
							<?php
							$sqk = mysqli_query($conn, "SELECT * FROM bank ORDER BY id ASC");
							while ($k = mysqli_fetch_array($sqk)) {
								echo "<option value=" . $k['id'] . " " . $selected . ">" . $k['nmBank']   . " - " . $k['atasNama'] . "</option>";
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
	<div class="box box-solid alert alert-warning alert-dismissible fade in">
		<div class="box-body">
			<p>Warning!... !<br>Halaman ini digunakan untuk memindahkan saldo kas</p>
		</div>
	</div>
</div>
<?php
if (isset($_GET['tampil'])) {

	$sqlSiswaTagihan = mysqli_query($conn, "SELECT *
						FROM
							bank
						WHERE id='$_GET[id]'");

	$n = mysqli_num_rows($sqlSiswaTagihan); // membaca jumlah data
?>
	<div class="col-sm-12">
		<div class="box box-solid box-success">
			<div class="box-header">
				<h3 class="box-title">Pilih Bank Yang Akan di Proses</h3>
			</div>
			<form method="POST" action="" class="form-horizontal">
				<div class="table-responsive">
					<table class="table table-striped">
						<tr>
							<th>No.</th>
							<th>Nama Bank</th>
							<th>Atas Nama</th>
							<th>Nomor Rekening</th>
							<th>Saldo</th>
							<th>Jumlah Mutasi</th>
						</tr>
						<?php
						$no = 1;
						while ($ft = mysqli_fetch_array($sqlSiswaTagihan)) {
						?>
							<tr>
								<td><?php echo $no; ?></td>
								<td><?php echo $ft['nmBank']; ?></td>
								<td><?php echo $ft['atasNama']; ?></td>
								<td><?php echo $ft['noRek']; ?></td>
								<td><input type="text" class="form-control" name="" value="<?php echo buatRp($ft['saldo']); ?>" readonly></td>
								<input type="hidden" class="form-control" name="saldo_awal" value="<?php echo $ft['saldo']; ?>">
								<input type="hidden" class="form-control" name="id" value="<?php echo $ft['id']; ?>">
								<td><input type="number" class="form-control" name="saldo_update" value="<?php echo $ft['saldo']; ?>"></td>
							</tr>
						<?php $no++;
						} ?>
					</table>
				</div>
				<div class="box-footer">
					<label for="" class="col-sm-2 control-label">Pindah Saldo</label>
					<div class="col-sm-4">
						<select name="id_mutasi" class="form-control">
							<?php
							$sqk = mysqli_query($conn, "SELECT * FROM bank ORDER BY id ASC");
							while ($k = mysqli_fetch_array($sqk)) {
								echo "<option value=" . $k['id'] . ">" . $k['nmBank'] . " - " . $k['atasNama'] . "</option>";
							}
							?>
						</select>
					</div>
					<div class="col-sm-4">
						<input type="submit" name="proses" class="btn btn-danger" value="Proses Pindah Saldo">
					</div>
				</div>
			</form>
		</div>
	</div>

<?php
	if (isset($_POST['proses'])) {
		$id = $_POST['id'];
		$saldo_update = $_POST['saldo_update'];
		$saldo_awal = $_POST['saldo_awal'];
		$hasil = $saldo_awal - $saldo_update;
		if ($saldo_update == '0') {
			echo "<script>document.location='index.php?view=mutasikas&gagalsaldo';</script>";
		} else if ($saldo_update >  $saldo_awal) {
			echo "<script>document.location='index.php?view=mutasikas&gagalsaldomelebihi';</script>";
		} else {
			$query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$_POST[id_mutasi]'");
			$saldo = mysqli_fetch_array($query_saldo);
			$saldoo = $saldo['saldo'] + $saldo_update;

			$query = mysqli_query($conn, "UPDATE bank SET saldo='$saldoo' WHERE id='$_POST[id_mutasi]'");
			$query = mysqli_query($conn, "UPDATE bank SET saldo='$hasil' WHERE id='$_POST[id]'");
			if ($query) {
				echo "<script>document.location='index.php?view=mutasikas&sukses';</script>";
			} else {
				echo "<script>document.location='index.php?view=mutasikas&gagal';</script>";
			}
		}
	}
}

?>