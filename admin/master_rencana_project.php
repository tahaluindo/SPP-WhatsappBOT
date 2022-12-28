<?php
// $uri = str_replace('&id=' . $_GET['id'], NULL, $_SERVER['REQUEST_URI']);
include "./config/rupiah.php";
include "../config/koneksi.php";

$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));
$link = $idt['link_one_sender'];
$links = $idt['token'];
$wa = $idt['wa'];
//url tagihan
$page_URL = (@$_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $uri_segments = explode('');
//tahun ajaran
$t = mysqli_query($conn, "SELECT idTahunAjaran as ta FROM tahun_ajaran WHERE aktif = 'Y'");
$ta = mysqli_fetch_array($t);
$thn_ajar = $ta['ta'];
$now = date('m');

//$headers = array();
//$headers[] =  $idt[token];
//$headers[] = 'Content-Type: application/x-www-form-urlencoded';

?>
<?php if ($_GET['act'] == '') {


?>
	<div class="col-xs-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Data Nama Project </h3>

			</div><!-- /.box-header -->
			<div class="box-body">

				<form method="GET" action="" class="form-horizontal">
					<input type="hidden" name="view" value="rencana_project" />
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>
									<select id="kelas" name="tahun" class="form-control">
										<option value="" selected> - Pilih Tahun - </option>
										<?php
										$sqk = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran DESC");
										while ($k = mysqli_fetch_array($sqk)) {
											$selected = ($k['idKelas'] == $kelas) ? ' selected="selected"' : "";
											echo "<option value=" . $k['idTahunAjaran'] . " " . $selected . ">" . $k['nmTahunAjaran'] . "</option>";
										}
										?>
									</select>
								</td>

								<td width="100">
									<input type="submit" name="tampil" value="Tampilkan" class="btn btn-success pull-right btn-sm">
								</td>

							</tr>
						</tbody>
					</table>
				</form>
				<div class="table-responsive">
					<?php
					if (isset($_GET['sukses'])) {
						echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil Di Proses,..
					</div>";
					} elseif (isset($_GET['sudah'])) {
						echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data tidak Di Proses, data sudah ada sebelumnya..
					</div>";
					}
					?>
					<table id="example" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>BULAN</th>
								<th>TAMBAH</th>
								<th>NAMA PROJECT </th>
								<th>NAMA MITRA </th>
								<th>TANGGAL PROJECT </th>
								<th colspan="2">AKSI</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sqk = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran where aktif='Y'"));

							$tampil = mysqli_query($conn, "SELECT *
            				FROM bulan order by urutan ASC");
							$no = 1;
							while ($r = mysqli_fetch_array($tampil)) {
								echo "<tr>
                              <td >$r[nmBulan]</td>
                              <td ><a class='btn btn-primary btn-xs ' title='Edit Data' href='?view=rencana_project&act=tambah&id=$r[idBulan]'><span class='glyphicon glyphicon-plus'></span> Tambah </a>
                            </tr>";

								if (isset($_GET['tahun'])) {
									$tampils = mysqli_query($conn, "SELECT rb_rencana_project.*, rb_rencana_project.nmProject,
                                                      rb_rencana_project.idClient,rb_rencana_project.tglKonten,rb_rencana_project.bulanKonten,
                                                      bulan.idBulan,rb_rencana_project.idTahunAjaran,mitra.nmMitra
                                                      FROM rb_rencana_project
                                                      INNER JOIN bulan ON rb_rencana_project.bulanKonten=bulan.idBulan 
                                                      INNER JOIN mitra ON rb_rencana_project.idClient=mitra.id 
                                                      INNER JOIN tahun_ajaran ON rb_rencana_project.idtahunAjaran=tahun_ajaran.idTahunAjaran
                                                      where bulan.idBulan='$r[idBulan]' and rb_rencana_project.idTahunAjaran='$_GET[tahun]' 
                                                      order by bulan.idBulan
                                                      ");
								} else {
									$tampils = mysqli_query($conn, "SELECT rb_rencana_project.*, rb_rencana_project.nmProject,
                                                              rb_rencana_project.idClient,rb_rencana_project.tglKonten,rb_rencana_project.bulanKonten,bulan.idBulan
                                                              ,mitra.nmMitra
                                                              FROM rb_rencana_project
                                                              INNER JOIN bulan ON rb_rencana_project.bulanKonten=bulan.idBulan 
                                                      		INNER JOIN mitra ON rb_rencana_project.idClient=mitra.id 
                                                              where bulan.idBulan='$r[idBulan]'  
                                                              order by bulan.idBulan
                                                              ");
								}
								while ($row = mysqli_fetch_array($tampils)) {
									$tgl = date('Y-m-d');
									$cek = mysqli_query($conn, "SELECT * FROM rb_rencana_project where  
                						nmProject='$row[nmKonten]' and tglKonten='$row[tglKonten]' and status='Sudah'");
									$total = mysqli_num_rows($cek);

									if ($total >= 1) {
										$a = 'Belum';
										$absen = "<a class='btn btn-warning btn-xs' title='' href='?view=rencana_project&act=onoff&id=$row[id]&a=$a' > Udah Proses </a>";
									} else {
										$a = 'Sudah';
										$absen = "<a class='btn btn-danger btn-xs' title='$alt' href='?view=rencana_project&act=onoff&id=$row[id]&a=$a'><span class='fa $icon'></span> Jadiin Udah</a>";
									}
									echo "<tr>
									<td  colspan='2'></td>
									<td>$row[nmProject] </td>
									<td>$row[nmMitra] </td>
									<td>" . tgl_indo($row['tglKonten']) . " </td>
									<td>$absen</td>
									<td style='width:70px !important'>
									<center>
									<a class='btn btn-success btn-xs' title='Edit Jadwal' href='?view=rencana_project&act=edit&id=$row[id]'><span class='glyphicon glyphicon-edit'></span></a>
									<a class='btn btn-danger btn-xs' title='Hapus Jadwal' href='?view=rencana_project&hapus=$row[id]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><span class='glyphicon glyphicon-remove'></span></a>
									</center>
									</td>
									</tr>";
									$no++;
								}
							}
							if (isset($_GET['hapus'])) {
								mysqli_query($conn, "DELETE FROM rb_rencana_project where id='$_GET[hapus]'");
								echo "<script>document.location='?view=rencana_project';</script>";
							}
							?>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>

	<?php
} elseif ($_GET['act'] == 'onoff') {
	$a = $_GET['a'];
	$query = mysqli_query($conn, "UPDATE rb_rencana_project SET status='$a' where id = '$_GET[id]'");
	if ($query) {
		echo "<script>document.location='?view=rencana_project';</script>";
	} else {
		echo "<script>document.location='?view=rencana_project';</script>";
	}
} elseif ($_GET['act'] == 'edit') {
	if (isset($_POST['update'])) {
		$query = mysqli_query($conn, "UPDATE rb_rencana_project SET nmProject='$_POST[nmProject]', 
							idClient='$_POST[idClient]',tglKonten='$_POST[tglKonten]',
							bulanKonten='$_POST[bulanKonten]' where id = '$_POST[id]'");
		if ($query) {
			echo "<script>document.location='?view=rencana_project&sukses';</script>";
		} else {
			echo "<script>document.location='?view=rencana_project&gagal';</script>";
		}
	}
	$edit = mysqli_query($conn, "SELECT * FROM rb_rencana_project where id='$_GET[id]'");
	$record = mysqli_fetch_array($edit);
	?>
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"> Edit Data Project</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<form method="post" action="" class="form-horizontal">
						<input type="hidden" name="id" value="<?php echo $record['id']; ?>" readonly>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Nama Project</label>
							<div class="col-sm-2">
								<input type="text" name="nmProject" value="<?php echo $record['nmProject']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2  control-label">Mitra </label>
							<div class="col-sm-2">
								<select id="kelas" name='idClient' class="form-control">
									<option value="" selected> - Pilih Mitra - </option>
									<?php
									$sqk = mysqli_query($conn, "SELECT * FROM mitra ORDER BY id ASC");
									while ($k = mysqli_fetch_array($sqk)) {
										$selected = ($k['id'] == $record['idClient']) ? ' selected="selected"' : "";
										echo '<option value="' . $k['id'] . '" ' . $selected . '>' . $k['nmMitra'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Tanggal Project</label>
							<div class="col-sm-2">
								<input type="date" name="tglKonten" value="<?php echo $record['tglKonten']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2  control-label">Bulan </label>
							<div class="col-sm-2">
								<select id="kelas" name='bulanKonten' class="form-control">
									<option value="" selected> - Pilih Bulan - </option>
									<?php
									$sqk = mysqli_query($conn, "SELECT * FROM bulan ORDER BY idBulan ASC");
									while ($k = mysqli_fetch_array($sqk)) {
										$selected = ($k['idBulan'] == $record['bulanKonten']) ? ' selected="selected"' : "";
										echo '<option value="' . $k['idBulan'] . '" ' . $selected . '>' . $k['nmBulan'] . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2  control-label">Tahun </label>
							<div class="col-sm-2">
								<select id="kelas" name="tahun" class="form-control">
									<option value="" selected> - Pilih Tahun - </option>
									<?php
									$sqk = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran DESC");
									while ($k = mysqli_fetch_array($sqk)) {
										$selected = ($k['idTahunAjaran'] == $record['idTahunAjaran']) ? ' selected="selected"' : "";
										echo "<option value=" . $k['idTahunAjaran'] . " " . $selected . ">" . $k['nmTahunAjaran'] . "</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-10">
								<input type="submit" name="update" value="Update" class="btn btn-success">
								<a href="?view=konten" class="btn btn-default">Cancel</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	<?php
} elseif ($_GET['act'] == 'tambah') {
	if (isset($_POST['tambah'])) {
		$cek = mysqli_query($conn, "SELECT * FROM rb_rencana_project where idTahunAjaran='$_POST[tahun]' and nmProject='$_POST[nmProject]' 
	  	AND idClient='$_POST[idClient]' and tglKonten='$_POST[tglKonten]' and bulanKonten='$_POST[bulanKonten]'");
		$total = mysqli_num_rows($cek);
		if ($total >= 1) {
			echo "<script>document.location='?view=rencana_project&sudah';</script>";
		} else {
			$query = mysqli_query($conn, "INSERT INTO rb_rencana_project VALUES('','$_POST[tahun]','$_POST[nmProject]','$_POST[idClient]'
				,'$_POST[tglKonten]','$_POST[bulanKonten]','Belum')");
			echo "<script>document.location='?view=rencana_project&sukses';</script>";
		}
	}


	echo "<div class='col-md-12'>
				<div class='box box-info'>
				  <div class='box-header with-border'>
					<h3 class='box-title'>Tambah Data Project </h3>
				  </div>
				<div class='box-body'>
				<form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
				  <div class='col-md-12'>
					<table class='table table-condensed table-bordered'>
					<tbody>         
					<tr><th scope='row'>Nama Project</th>  <td>
									  <input class='form-control' name='nmProject' >
										  
									  </input>
								  </td></tr>
								   <tr><th scope='row'>Mitra</th> <td><select class='form-control' name='idClient'> 
							   <option value='0' selected>- Pilih Mitra -</option>";
	$guru = mysqli_query($conn, "SELECT * FROM mitra order by id DESC");
	while ($a = mysqli_fetch_array($guru)) {
		echo "<option value='$a[id]'>$a[nmMitra]</option>";
	}
	echo "</select>
					  </td></tr>
								  <tr><th scope='row'>Tanggal Project</th>  <td>
								  <input class='form-control' type='date' name='tglKonten' >
								  </input>
							  </td></tr>
							 
					  <tr><th scope='row'>Bulan</th> <td><select class='form-control' name='bulanKonten'> 
							   <option value='0' selected>- Pilih Bulan -</option>";
	$guru = mysqli_query($conn, "SELECT * FROM bulan order by idBulan DESC");
	while ($a = mysqli_fetch_array($guru)) {
		echo "<option value='$a[idBulan]'>$a[nmBulan]</option>";
	}
	echo "</select>
					  </td></tr>
					 <tr><th scope='row'>Tahun</th> <td><select class='form-control' name='tahun'> 
							   <option value='0' selected>- Pilih Tahun Anggaran -</option>";
	$guru = mysqli_query($conn, "SELECT * FROM tahun_ajaran order by idTahunAjaran DESC");
	while ($a = mysqli_fetch_array($guru)) {
		echo "<option value='$a[idTahunAjaran]'>$a[nmTahunAjaran]</option>";
	}
	echo "</select>
					  </td></tr>
					</tbody>
					</table>
				  </div>
				</div>
				<div class='box-footer'>
					  <button type='submit' name='tambah' class='btn btn-info'>Tambahkan</button>
					  <a href='?view=konten'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
					  
					</div>
				</form>
			  </div>"; ?>


	<?php
}
	?>
	<script type="text/javascript">
		function checkTanggal(tgl1, tgl2) {
			var tanggal1 = document.getElementById("tgl1").value;
			var tanggal2 = document.getElementById("tgl2").value;
			var tglTotime1 = Date.parse(tanggal1);
			var tglTotime2 = Date.parse(tanggal2);
			if (tgl2 == '') {
				document.querySelector(tgl2).setCustomValidity("Sampai Tanggal Belum Dimasukkan");
			} else if (tglTotime1 > tglTotime2) {
				document.querySelector(tgl2).setCustomValidity("Sampai Tanggal Tidak Boleh Kurang Dari Mulai Tanggal, Silahkan Pilih Tanggal Lain");
			} else {
				document.querySelector(tgl2).setCustomValidity("");
			}
		}
	</script>