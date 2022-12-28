<?php if ($_GET['act'] == '') { ?>
	<div class="col-xs-12">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"> Pemasukan Kas</h3>
				<a class='pull-right btn btn-primary btn-sm' href='index.php?view=jurnalumums&act=tambah'>Tambahkan Data</a>
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
				} elseif (isset($_GET['gagals'])) {
					echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - PIN salah!!
                          </div>";
				}


				?>
				<div class="table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal</th>
								<th>Jenis Pemasukan</th>
								<th>Pemasukan</th>
								<th>Keterangan</th>
								<th>Cara Bayar</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$tampil = mysqli_query($conn, "SELECT
												jurnal_umums.*,
												jenis_penerimaan.nmPenerimaan,
												bank.nmBank,
												bank.atasNama
											FROM
												jurnal_umums
											LEFT JOIN jenis_penerimaan ON jurnal_umums.idPenerimaan = jenis_penerimaan.idPenerimaan
											LEFT JOIN bank ON jurnal_umums.caraBayar = bank.id
												  ORDER BY jurnal_umums.tgl  DESC");
							$no = 1;
							while ($r = mysqli_fetch_array($tampil)) {
								echo "<tr><td>$no</td>
                              <td>" . tgl_indo($r['tgl']) . "</td>
                              <td>$r[nmPenerimaan]</td>
                              <td>" . buatRp($r['penerimaan']) . "</td>
							  <td>$r[ket]</td>
							  <td>$r[nmBank] - $r[atasNama]</td>
                              <td><center>";
								// <a class='btn btn-success btn-xs' title='Edit Data' href='?view=jurnalumums&act=edit&id=$r[id]'><span class='glyphicon glyphicon-edit'></span></a>
								echo " <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=jurnalumums&hapus&id=$r[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
								echo "</tr>";
								$no++;
							}
							if (isset($_GET['hapus'])) {
								//Membaca Data Jurnal Yang akan dihapus
								$jurnal = mysqli_query($conn, "SELECT * FROM jurnal_umums WHERE id='$_GET[id]'");
								$jur = mysqli_fetch_array($jurnal);
								$saldo_jurnal = $jur['penerimaan'];
								$caraBayar = $jur['caraBayar'];
								//Membaca Saldo Bank
								$query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
								$saldo = mysqli_fetch_array($query_saldo);
								$saldoo =  $saldo['saldo'] - $saldo_jurnal;
								$oke = mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
                                    WHERE id = '$caraBayar'  ");
								//menghapus data	
								mysqli_query($conn, "DELETE FROM jurnal_umums where id='$_GET[id]'");
								mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Hapus','Pemasukan Kas','$waktu_sekarang')");
								echo "<script>document.location='index.php?view=jurnalumums&sukseshapus';</script>";
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

		$query = mysqli_query($conn, "UPDATE jurnal_umums SET tgl='$_POST[tgl]', ket='$_POST[ket]',
							idPenerimaan='$_POST[idPenerimaan]', caraBayar='$_POST[caraBayar]',penerimaan='$_POST[penerimaan]' where id='$_POST[id]'");

		$query = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Edit','Pemasukan Kas','$waktu_sekarang')");

		if ($query) {
			echo "<script>document.location='index.php?view=jurnalumums&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=jurnalumums&gagal';</script>";
		}
	}
	$edit = mysqli_query($conn, "SELECT * FROM jurnal_umums where id='$_GET[id]'");
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
						<div class="table-responsive">
							<table class="table table-bordered table-hover" id="tab_logic">
								<thead>
									<tr>
										<th>No.</th>
										<th>Jenis Penerimaan</th>
										<th>Cara Bayar</th>
										<th>Penerimaan</th>
										<th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<tr id='addr0'>
										<td width="40px">
											1
										</td>
										<td>
											<select name='idPenerimaan' class="form-control">
												<option value="" selected> - Pilih Jenis Pengeluaran - </option>
												<?php
												$sqk = mysqli_query($conn, "SELECT * FROM jenis_penerimaan ORDER BY idPenerimaan ASC");
												while ($k = mysqli_fetch_array($sqk)) {
													$selected = ($k['idPenerimaan'] == $record['idPenerimaan']) ? ' selected="selected"' : "";
													echo '<option value="' . $k['idPenerimaan'] . '" ' . $selected . '>' . $k['nmPenerimaan'] . '</option>';
												}
												?>
											</select>
										</td>
										<td>
											<select style='width: 90px;' name='caraBayar' class='form-control select-sm'>
												<option value='<?php echo $record['caraBayar']; ?>'><?php echo $record['caraBayar']; ?></option>
												<option value='Tunai'>Tunai</option>
												<option value='Bank'>Bank Transfer</option>
											</select>
										</td>
										<td width="200px">
											<input type="text" name='penerimaan' value="<?php echo $record['penerimaan']; ?>" class="form-control" onkeypress="return isNumber(event)" required />
										</td>
										<td>
											<input type="text" name='ket' value="<?php echo $record['ket']; ?>" class="form-control" required />
										</td>
										<!-- <td width="200px">
											<input type="text" name='a' id="uang" placeholder='PIN' class="form-control" onkeypress="return isNumber(event)" required />
										</td> -->
									</tr>
									<tr id='addr1'></tr>
								</tbody>
							</table>
						</div>
						<div class="box-footer">
							<div class="pull-right">
								<input type="submit" name="update" value="Update" class="btn btn-success">
								<a href="index.php?view=jurnalumums" class="btn btn-default">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php
} elseif ($_GET['act'] == 'tambah') {
	if (isset($_POST['tambah'])) {
		$idPenerimaan = $_POST['idPenerimaan'];
		$penerimaan = $_POST['penerimaan'];
		$ket = $_POST['ket'];
		$tgl = $_POST['tgl'];
		$caraBayar = $_POST['idBank'];
		//input kedatabase jurnal umum
		$query = mysqli_query($conn, "INSERT INTO jurnal_umums(tgl,ket,idPenerimaan,penerimaan,caraBayar) VALUES('$tgl','$ket','$idPenerimaan','$penerimaan','$caraBayar')");
		//update saldo bank
		$query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
		$saldo = mysqli_fetch_array($query_saldo);
		$saldoo =  $saldo['saldo'] + $penerimaan;
		mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
                                    WHERE id = '$caraBayar' ");
		//memasukkan data ke log transaksi
		$query = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Tambah','Pemasukan Kas','$waktu_sekarang')");
		if ($query) {
			echo "<script>document.location='index.php?view=jurnalumums&sukses';</script>";
		} else {
			echo "<script>document.location='index.php?view=jurnalumums&gagal';</script>";
		}
	}

	?>

		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title"> Tambah Data Pemasukan Kas </h3>
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
										<th>Jenis Penerimaan</th>
										<th>Cara Bayar</th>
										<th>Penerimaan</th>
										<th>Keterangan</th>
									</tr>
								</thead>
								<tbody>
									<tr id='addr0'>
										<td width="40px">
											1
										</td>
										<td>
											<select id="kelas" name='idPenerimaan' class="form-control">
												<option value="" selected> - Pilih Jenis Penerimaan - </option>
												<?php
												$sqk = mysqli_query($conn, "SELECT * FROM jenis_penerimaan ORDER BY idPenerimaan ASC");
												while ($k = mysqli_fetch_array($sqk)) {
													echo "<option value=" . $k['idPenerimaan'] . ">" . $k['nmPenerimaan'] . "</option>";
												}
												?>
											</select>
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
											<input type="text" name='penerimaan' id="uang" placeholder='Jumlah Penerimaan' class="form-control" onkeypress="return isNumber(event)" required />
										</td>
										<td>
											<input type="text" name='ket' placeholder='Keterangan' class="form-control" required />
										</td>
										<!-- <td width="200px">
											<input type="text" name='a' id="uang" placeholder='PIN' class="form-control" onkeypress="return isNumber(event)" required />
										</td> -->
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
								<a href="index.php?view=jurnalumums" class="btn btn-default">Cancel</a>
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
							$('#addr' + i).html("<td>" + (i + 1) + "</td> <
								td > < select name = 'idPenerimaan[]'
								class = 'form-control' >
								<
								option value = ''
								selected > -Pilih Jenis Pengeluaran - < /option>
								<?php $sqk = mysqli_query($conn, 'SELECT * FROM jenis_penerimaan ORDER BY idPenerimaan ASC');
								while ($k = mysqli_fetch_array($sqk)) {
									echo '<option value=' . $k['idPenerimaan'] . '' . $selected . '>' . $k['nmPenerimaan'] . '</option>';
								} ?> < /select></td > < td > < input type = 'text'
								name = 'pengeluaran[]'
								placeholder = 'Jumlah Pengeluaran'
								class = 'form-control'
								onkeypress = 'return isNumber(event)'
								required / > < /td><td><input type='text' name='ket[]' placeholder='Keterangan' class='form-control' required / > < /td>");
								$('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>'); i++;
							});

						$("#delete_row").click(function() {
							if (i > 1) {
								$("#addr" + (i - 1)).html('');
								i--;
							}
						});
					});
	</script> -->