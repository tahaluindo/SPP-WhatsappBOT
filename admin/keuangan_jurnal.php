<?php if ($_GET['act'] == '') { ?>
	<div class="col-xs-12">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"> Saldo Awal</h3>
				<a class='pull-right btn btn-warning btn-sm' href='index.php?view=jurnal&act=tambah'>Tambahkan Data</a>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
				$tampil = mysqli_query($conn, "SELECT * FROM view_detil_siswa ORDER BY idKelas ASC");
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
							<th>Tanggal</th>
							<th>Keterangan</th>
							<th>Pemasukan</th>
							<th>POS</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$tampil = mysqli_query($conn, "SELECT * FROM saldoawal ORDER BY id DESC");
						$no = 1;
						while ($r = mysqli_fetch_array($tampil)) {
							echo "<tr><td>$no</td>
                              <td>" . tgl_indo($r['tgl']) . "</td>
                              <td>$r[ket]</td>
                              <td>$r[penerimaan]</td>
                              <td>$r[pengeluaran]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=jurnal&act=edit&id=$r[id]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=jurnal&hapus&id=$r[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
							echo "</tr>";
							$no++;
						}
						if (isset($_GET['hapus'])) {
							mysqli_query($conn, "DELETE FROM saldoawal where id='$_GET[id]'");
							echo "<script>document.location='index.php?view=jurnal';</script>";
						}

						?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
<?php
} elseif ($_GET['act'] == 'edit') {
	if (isset($_POST['update'])) {

		$query = mysqli_query($conn, "UPDATE saldoawal SET tgl='$_POST[tgl]', ket='$_POST[ket]',
							penerimaan='$_POST[penerimaan]', pengeluaran='$_POST[pengeluaran]' where id='$_POST[id]'");
		if ($query) {
			echo "<script>document.location='index.php?view=jurnal&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=jurnal&gagal';</script>";
		}
	}
	$edit = mysqli_query($conn, "SELECT * FROM saldoawal where id='$_GET[id]'");
	$record = mysqli_fetch_array($edit);
?>
	<div class="col-md-12">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"> Edit Saldo Awal</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="post" action="" class="form-horizontal">
					<input type="hidden" name="id" value="<?php echo $record['id']; ?>">
					<div class="box-header with-border">
						<div class="col-md-3 pull-left">
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" name="tgl" class="form-control pull-right date-picker" value="<?php echo $record['tgl']; ?>" readonly>
							</div>
						</div>
					</div>
					<div class="box-body">
						<table class="table table-bordered table-hover" id="tab_logic">
							<thead>
								<tr>
									<th>No.</th>
									<th>Keterangan</th>
									<th>Pemasukan</th>
									<th>POS</th>
								</tr>
							</thead>
							<tbody>
								<tr id='addr0'>
									<td width="40px">
										1
									</td>
									<td>
										<input type="text" name='ket' value="<?php echo $record['ket']; ?>" class="form-control" required />
									</td>

									<td width="200px">
										<input type="text" name='penerimaan' value="<?php echo $record['penerimaan']; ?>" class="form-control" onkeypress="return isNumber(event)" required />
									</td>
									<td>
										<select id="kelas" name='pengeluaran' class="form-control">
											<option value="" selected> - Pilih POS - </option>
											<?php
											$sqk = mysqli_query($conn, "SELECT * FROM pos_bayar ORDER BY idPosBayar ASC");
											while ($k = mysqli_fetch_array($sqk)) {
												$selected = ($k['nmPosBayar'] == $kelas) ? ' selected="selected"' : "";
												echo "<option value=" . $k['nmPosBayar'] . " " . $selected . ">" . $k['nmPosBayar'] . "</option>";
											}
											?>
										</select>
									</td>
								</tr>
								<tr id='addr1'></tr>
							</tbody>
						</table>
					</div>
					<div class="box-footer">
						<div class="pull-right">
							<input type="submit" name="update" value="Update" class="btn btn-success">
							<a href="index.php?view=jurnal" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php
} elseif ($_GET['act'] == 'tambah') {
	if (isset($_POST['tambah'])) {

		$ket = $_POST['ket'];
		$terima = $_POST['penerimaan'];
		$keluar = $_POST['pengeluaran'];

		foreach ($ket as $i => $kets) {
			$data = array(
				'tgl' => $_POST['tgl'],
				'ket' => $kets,
				'penerimaan' => isset($terima[$i]) ? $terima[$i] : '',
				'pengeluaran' => isset($keluar[$i]) ? $keluar[$i] : ''
			);

			$query = mysqli_query($conn, "INSERT INTO saldoawal(tgl,ket,penerimaan,pengeluaran) VALUES('$data[tgl]','$data[ket]','$data[penerimaan]','$data[pengeluaran]')");
		}
		if ($query) {
			echo "<script>document.location='index.php?view=jurnal&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=jurnal&gagal';</script>";
		}
	}

?>

	<div class="col-md-12">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"> Tambah Data Saldo Awal </h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<form method="POST" action="" class="form-horizontal">
					<div class="box-header with-border">
						<div class="col-md-3 pull-right">
							<div class="input-group date">
								<input type="text" name="tgl" class="form-control pull-right date-picker" value="<?php echo date('Y-m-d'); ?>" readonly>
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body">
						<table class="table table-bordered table-hover" id="tab_logic">
							<thead>
								<tr>
									<th>No.</th>
									<th>Keterangan</th>
									<th>Pemasukan</th>
									<th>POS</th>
								</tr>
							</thead>
							<tbody>
								<tr id='addr0'>
									<td width="40px">
										1
									</td>
									<td>
										<input type="text" name='ket[]' placeholder='Keterangan' class="form-control" required />
									</td>
									<td width="200px">
										<input type="text" name='penerimaan[]' id="uang" placeholder='Jumlah Pengeluaran' class="form-control" onkeypress="return isNumber(event)" required />
									</td>
									<td>
										<select id="kelas" name='pengeluaran[]' class="form-control">
											<option value="" selected> - Pilih POS - </option>
											<?php
											$sqk = mysqli_query($conn, "SELECT * FROM pos_bayar ORDER BY idPosBayar ASC");
											while ($k = mysqli_fetch_array($sqk)) {
												$selected = ($k['nmPosBayar'] == $kelas) ? ' selected="selected"' : "";
												echo "<option value=" . $k['nmPosBayar'] . " " . $selected . ">" . $k['nmPosBayar'] . "</option>";
											}
											?>
										</select>
									</td>
								</tr>
								<tr id='addr1'></tr>
							</tbody>
						</table>
					</div>
					<div class="box-footer">
						<div class="pull-left">
							<a id="add_row" class="btn btn-default">Tambah Baris</a> <a id='delete_row' class="btn btn-default">Hapus Baris</a>
						</div>
						<div class="pull-right">
							<input type="submit" name="tambah" value="Simpan" class="btn btn-success">
							<a href="index.php?view=jurnal" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
}
?>