<?php if ($_GET['act'] == '') { ?>
	<div class="col-xs-12">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"> Pengeluaran Kas</h3>
				<tr>
					<td><a class='pull-right btn btn-success btn-sm' href='index.php?view=jurnalumum&act=tambahlain'>Tambah Pengeluaran </a>
						<a class='pull-right btn btn-primary btn-sm' href='index.php?view=jurnalumum&act=tambah'>Tambah Pengeluaran Project</a>
					</td>
				</tr>
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
				} elseif (isset($_GET['sukseshapus'])) {
					echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Berhasil!</strong> - Data Berhasil dihapus.....
                          </div>";
				} elseif (isset($_GET['gagalhapus'])) {
					echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data ini tidak memiliki akun bank, sehingga tidak bisa dihapus!!
                          </div>";
				}
				?>
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Jenis Pengeluaran</th>
								<th>Pengeluaran</th>
								<th>Keterangan</th>
								<th>Akun Kas</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if ($_SESSION['notif'] == 'gagal_nominal_transaksi') {
								echo '<script>toastr["error"]("Nominal Pengeluaran melebihi Rencana Anggaran.","Gagal!")</script>';
							}
							unset($_SESSION['notif']);
							$tampil = mysqli_query($conn, "SELECT
												jurnal_umum.*,
												jenis_pengeluaran.nmPengeluaran,
												bank.nmBank,
												bank.atasNama
											FROM
												jurnal_umum
											 LEFT JOIN jenis_pengeluaran ON jurnal_umum.idPengeluaran = jenis_pengeluaran.idPengeluaran
											 LEFT JOIN bank ON jurnal_umum.caraBayar = bank.id
												  ORDER BY jurnal_umum.tgl DESC");
							$no = 1;
							while ($r = mysqli_fetch_array($tampil)) {
								echo "<tr><td>$no</td>
                              <td>" . tgl_indo($r['tgl']) . "</td>
                              <td>$r[nmPengeluaran]</td>
                              <td>" . buatRp($r['pengeluaran']) . "</td>
							  <td>$r[ket]</td>
							  <td>$r[nmBank] - $r[atasNama]</td>
                              <td>
							  <center>";
								// <a class='btn btn-success btn-xs' title='Edit Data' href='?view=jurnalumum&act=edit&id=$r[id]' disabled><span class='glyphicon glyphicon-edit'></span></a>

								echo " <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=jurnalumum&hapus&id=$r[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center>
								</td>";
								echo "</tr>";
								$no++;
							}
							if (isset($_GET['hapus'])) {
								//Membaca Data Jurnal Yang akan dihapus
								$jurnal = mysqli_query($conn, "SELECT * FROM jurnal_umum WHERE id='$_GET[id]'");
								$jur = mysqli_fetch_array($jurnal);
								$saldo_jurnal = $jur['pengeluaran'];
								$caraBayar = $jur['caraBayar'];
								//Membaca Saldo Bank
								$query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
								$saldo = mysqli_fetch_array($query_saldo);
								$saldoo =  $saldo['saldo'] + $saldo_jurnal;
								$oke = mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
								WHERE id = '$caraBayar'  ");
								if ($jur['caraBayar'] == 'Bank') {
									echo "<script>document.location='index.php?view=jurnalumum&gagalhapus';</script>";
								} else {

									mysqli_query($conn, "DELETE FROM jurnal_umum where id='$_GET[id]'");
									$query = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Hapus','Pengeluaran Kas','$waktu_sekarang')");
									echo "<script>document.location='index.php?view=jurnalumum&sukseshapus';</script>";
								}
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

		if ($_POST['pengeluaran'] < $_POST['pengeluaran_awal']) {
			$saldo_jurnal = $_POST['pengeluaran_awal'];
		} else if ($_POST['pengeluaran'] > $_POST['pengeluaran_awal']) {
			$saldo_jurnal = $_POST['pengeluaran'];
		}

		$caraBayar =  $_POST['idBank'];

		$query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
		$saldo = mysqli_fetch_array($query_saldo);
		$saldoo =  $saldo['saldo'] - $saldo_jurnal;
		$oke = mysqli_query($conn, "UPDATE  bank SET saldo = '$saldoo'
		WHERE id = '$caraBayar'  ");

		$query = mysqli_query($conn, "UPDATE jurnal_umum SET tgl='$_POST[tgl]', ket='$_POST[ket]',
							idPengeluaran='$_POST[idPengeluaran]', idBulan='$_POST[idBulan]',pengeluaran='$_POST[pengeluaran]' ,akun='$_POST[idBank]' where id='$_POST[id]'");

		$query = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Edit','Pengeluaran Kas','$waktu_sekarang')");
		if ($query) {
			echo "<script>document.location='index.php?view=jurnalumum&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=jurnalumum&gagal';</script>";
		}
	}
	$edit = mysqli_query($conn, "SELECT * FROM jurnal_umum where id='$_GET[id]'");
	$record = mysqli_fetch_array($edit);
	?>
		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title"> Edit Pengeluaran Kas</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<form method="post" action="" class="form-horizontal">
						<input type="hidden" name="id" value="<?php echo $record['id']; ?>">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Tanggal</label>
							<div class="col-sm-4">
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" name="tgl" class="form-control pull-right date-picker" value="<?php echo $record['tgl']; ?>" readonly>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Jenis Pengeluaran</label>
							<div class="col-sm-4">
								<select name='idPengeluaran' class="form-control">
									<option value="" selected> - Pilih Jenis Pengeluaran - </option>
									<?php
									$sqk = mysqli_query($conn, "SELECT * FROM jenis_pengeluaran ORDER BY idPengeluaran ASC");
									while ($k = mysqli_fetch_array($sqk)) {
										$selected = ($k['idPengeluaran'] == $record['idPengeluaran']) ? ' selected="selected"' : "";
										echo '<option value="' . $k['idPengeluaran'] . '" ' . $selected . '>' . $k['nmPengeluaran'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Bulan</label>
							<div class="col-sm-4">
								<select name="idBulan" class="form-control">
									<?php
									$sqks = mysqli_query($conn, "SELECT * FROM bulan ");
									while ($ks = mysqli_fetch_array($sqks)) {
										$selected = ($ks['idBulan'] == $record['idBulan']) ? ' selected="selected"' : "";
										echo '<option value="' . $ks['idBulan'] . ' " ' . $selected . '>' . $ks['nmBulan'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Akun Kas</label>
							<div class="col-sm-4">
								<select name="idBank" class="form-control">
									<option value='Tunai'>Tunai</option>
									<?php
									$sqks = mysqli_query($conn, "SELECT * FROM bank ");
									while ($ks = mysqli_fetch_array($sqks)) {
										$selected = ($ks['id'] == $record['akun']) ? ' selected="selected"' : "";
										echo '<option value="' . $ks['id'] . ' " ' . $selected . '>' . $ks['nmBank'] . ' - ' . $ks['atasNama'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Jumlah</label>
							<div class="col-sm-4">
								<input type="hidden" name='pengeluaran_awal' value="<?php echo $record['pengeluaran']; ?>" class="form-control" onkeypress="return isNumber(event)" required />
								<input type="text" name='pengeluaran' value="<?php echo $record['pengeluaran']; ?>" class="form-control" onkeypress="return isNumber(event)" required />
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Keterangan</label>
							<div class="col-sm-4">
								<input type="text" name='ket' value="<?php echo $record['ket']; ?>" class="form-control" required />
							</div>
						</div>
						<div class="box-footer">
							<div class="pull-right">
								<input type="submit" name="update" value="Update" class="btn btn-success">
								<a href="index.php?view=jurnalumum" class="btn btn-default">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	<?php
} elseif ($_GET['act'] == 'tambah') {
	if (isset($_POST['tambah'])) {
		$idPengeluaran = $_POST['idPengeluaran'];
		$idProject = $_POST['idProject'];
		$pengeluaran = $_POST['pengeluaran'];
		$ket = $_POST['ket'];
		$idBulan = $_POST['idBulan'];
		$caraBayar = $_POST['idBank'];
		$tgl = $_POST['tgl'];
		$bulan = date('m');
		$tahun = date('Y');
		$cek = mysqli_query($conn, "SELECT * FROM jurnal_umum where idProject='" . $idProject . "' ");
		$total = mysqli_num_rows($cek);
		if ($total >= 1) {
			$query_saldo = mysqli_query($conn, "SELECT SUM(pengeluaran) as keluar FROM jurnal_umum WHERE idProject='$idProject' ");
			$saldo = mysqli_fetch_array($query_saldo);
			$saldoo = $saldo['keluar'] + $pengeluaran[$i];
			mysqli_query($conn, "UPDATE realisasi SET realisasi = '$saldoo'
                                    WHERE idPengeluaran = '$idProject[$i]'  ");
		} else {
			$query_saldo = mysqli_query($conn, "SELECT SUM(pengeluaran) as keluar FROM jurnal_umum WHERE idProject='$idProject'");
			$saldo = mysqli_fetch_array($query_saldo);
			$saldoo = $saldo['keluar'];
			mysqli_query($conn, "UPDATE realisasi SET realisasi = '$saldoo'
                                    WHERE idPengeluaran = '$idProject[$i]'   ");
		}
		$query = mysqli_query($conn, "INSERT INTO jurnal_umum(tgl,ket,idPengeluaran,idBulan,pengeluaran,idProject,caraBayar) VALUES('$tgl','$ket','$idPengeluaran','$idBulan','$pengeluaran','$idProject','$caraBayar')");
		$query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
		$saldo = mysqli_fetch_array($query_saldo);
		$saldoo =  $saldo['saldo'] - $pengeluaran;
		mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
                                    WHERE id = '$caraBayar'  ");


		$query = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Tambah','Pengeluaran Kas','$waktu_sekarang')");
		if ($query) {
			echo "<script>document.location='index.php?view=jurnalumum&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=jurnalumum&gagal';</script>";
		}
	}
	?>
		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title"> Tambah Data Pengeluaran Kas </h3>
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
						<div class="table-responsive">
							<table class="table table-bordered table-hover" id="tab_logic">
								<thead>
									<tr>
										<th>No.</th>
										<th>Jenis Pengeluaran</th>
										<th>Project</th>
										<th>Bulan</th>
										<th>Cara Bayar</th>
										<th>Jumlah</th>
										<th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<tr id='addr0'>
										<td width="40px">
											1
										</td>
										<td>
											<select id="kelas" name='idPengeluaran' class="form-control">
												<option value="" selected> - Pilih Jenis Pengeluaran - </option>
												<?php
												$sqk = mysqli_query($conn, "SELECT * FROM jenis_pengeluaran ORDER BY idPengeluaran ASC");
												while ($k = mysqli_fetch_array($sqk)) {
													echo "<option value=" . $k['idPengeluaran'] . ">" . $k['nmPengeluaran'] . "</option>";
												}
												?>
											</select>
										</td>
										<td>
											<select id="kelas" name='idProject' class="form-control">
												<option value="" selected> - Pilih Project - </option>
												<?php
												$sqk = mysqli_query($conn, "SELECT * FROM project ORDER BY idProject ASC");
												while ($k = mysqli_fetch_array($sqk)) {
													echo "<option value=" . $k['idProject'] . ">" . $k['nmProject'] . "</option>";
												}
												?>
											</select>
										</td>
										<td>
											<select name="idBulan" class="form-control">
												<?php
												$sqks = mysqli_query($conn, "SELECT * FROM bulan ");
												while ($ks = mysqli_fetch_array($sqks)) {
													echo "<option value=" . $ks['idBulan'] . ">" . $ks['nmBulan'] . "</option>";
												}
												?>
											</select>
										</td>
										<td>
											<select name="idBank" class="form-control" required>
												<?php
												$sqks = mysqli_query($conn, "SELECT * FROM bank ");
												while ($ks = mysqli_fetch_array($sqks)) {
													$selected = ($ks['id'] == $record['akun']) ? ' selected="selected"' : "";
													echo '<option value="' . $ks['id'] . ' " ' . $selected . '>' . $ks['nmBank'] . ' - ' . $ks['atasNama'] . '</option>';
												}
												?>
											</select>
										</td>
										<td width="200px">
											<input type="text" name='pengeluaran' id="uang" placeholder='Jumlah Pengeluaran' class="form-control" onkeypress="return isNumber(event)" required />
										</td>
										<td>
											<input type="text" name='ket' placeholder='Keterangan' class="form-control" required />
										</td>
									</tr>
									<tr id='addr1'></tr>
								</tbody>
							</table>
						</div>
						<div class="box-footer">
							<!--<div class="pull-left">
							<a id="add_row" class="btn btn-default">Tambah Baris</a> <a id='delete_row' class="btn btn-default">Hapus Baris</a>
						</div>-->
							<div class="pull-right">
								<input type="submit" name="tambah" value="Simpan" class="btn btn-success">
								<a href="index.php?view=jurnalumum" class="btn btn-default">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php
} elseif ($_GET['act'] == 'tambahlain') {
	if (isset($_POST['tambahlain'])) {
		$idPengeluaran = $_POST['idPengeluaran'];
		$pengeluaran = $_POST['pengeluaran'];
		$ket = $_POST['ket'];
		$tgl = $_POST['tgl'];
		$idBulan = $_POST['idBulan'];
		$caraBayar = $_POST['idBank'];
		$bulan = date('m');
		$tahun = date('Y');
		$query = mysqli_query($conn, "INSERT INTO jurnal_umum(tgl,ket,idPengeluaran,idBulan,pengeluaran,caraBayar) VALUES('$tgl','$ket','$idPengeluaran','$idBulan','$pengeluaran','$caraBayar')");
		$query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
		$saldo = mysqli_fetch_array($query_saldo);
		$saldoo =  $saldo['saldo'] - $pengeluaran;
		mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
                                    WHERE id = '$caraBayar'  ");

		$query = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Tambah','Pengeluaran Kas','$waktu_sekarang')");
		if ($query) {
			echo "<script>document.location='index.php?view=jurnalumum&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=jurnalumum&gagal';</script>";
		}
	}
	?>
		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title"> Tambah Data Pengeluaran Kas </h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<form method="POST" action="" class="form-horizontal">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Tanggal</label>
							<div class="col-sm-4">
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" name="tgl" class="form-control pull-right date-picker" value="<?php echo date('Y-m-d'); ?>" readonly>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Jenis Pengeluaran</label>
							<div class="col-sm-4">
								<select name='idPengeluaran' class="form-control" required>
									<option value="" selected> - Pilih Jenis Pengeluaran - </option>
									<?php
									$sqk = mysqli_query($conn, "SELECT * FROM jenis_pengeluaran ORDER BY idPengeluaran ASC");
									while ($k = mysqli_fetch_array($sqk)) {
										$selected = ($k['idPengeluaran'] == $record['idPengeluaran']) ? ' selected="selected"' : "";
										echo '<option value="' . $k['idPengeluaran'] . '" ' . $selected . '>' . $k['nmPengeluaran'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Bulan</label>
							<div class="col-sm-4">
								<select name="idBulan" class="form-control" required>
									<?php
									$sqks = mysqli_query($conn, "SELECT * FROM bulan ");
									while ($ks = mysqli_fetch_array($sqks)) {
										$selected = ($ks['idBulan'] == $record['idBulan']) ? ' selected="selected"' : "";
										echo '<option value="' . $ks['idBulan'] . ' " ' . $selected . '>' . $ks['nmBulan'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Akun Kas</label>
							<div class="col-sm-4">
								<select name="idBank" class="form-control" required>

									<?php
									$sqks = mysqli_query($conn, "SELECT * FROM bank ");
									while ($ks = mysqli_fetch_array($sqks)) {
										$selected = ($ks['id'] == $record['akun']) ? ' selected="selected"' : "";
										echo '<option value="' . $ks['id'] . ' " ' . $selected . '>' . $ks['nmBank'] . ' - ' . $ks['atasNama'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Jumlah</label>
							<div class="col-sm-4">
								<input type="text" name='pengeluaran' class="form-control" onkeypress="return isNumber(event)" required />
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Keterangan</label>
							<div class="col-sm-4">
								<input type="text" name='ket' class="form-control" required />
							</div>
						</div>
						<div class="box-footer">
							<div class="pull-right">
								<input type="submit" name="tambahlain" value="Simpan" class="btn btn-success">
								<a href="index.php?view=jurnalumum" class="btn btn-default">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php
}
	?>
	<!-- <script type="text/javascript">
		$(document).ready(function() {
					var i = 1;
					$("#add_row").click(function() {
							$('#addr'+i).html("<td>" + (i+1) + "</td> 
							<td><select name = 'idPengeluaran[]'
								class = 'form-control' >
								<option value = ''selected > -Pilih Jenis Pengeluaran - </option>
								<?php $sqk = mysqli_query($conn, 'SELECT * FROM jenis_pengeluaran ORDER BY idPengeluaran ASC');
								while ($k = mysqli_fetch_array($sqk)) {
									echo '<option value=' . $k['idPengeluaran'] . '' . $selected . '>' . $k['nmPengeluaran'] . '</option>';
								} ?> </select></td><td><input type = 'text'
								name = 'pengeluaran[]'
								placeholder = 'Jumlah Pengeluaran'
								class = 'form-control'
								onkeypress = 'return isNumber(event)'
								required/> </td><td><input type='text' name='ket[]' placeholder='Keterangan' class='form-control' required/> </td>");
								$('#tab_logic').append('<tr id="addr'+(i+1) + '"></tr>'); i++;
							});

						$("#delete_row").click(function() {
							if (i > 1) {
								$("#addr" + (i - 1)).html('');
								i--;
							}
						});
					});
	</script> -->