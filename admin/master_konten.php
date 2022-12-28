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

if ($_GET['act'] == '') {
?>
	<div class="col-xs-12">
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title"> Data Nama Konten </h3>

			</div><!-- /.box-header -->
			<div class="box-body">

				<form method="GET" action="" class="form-horizontal">
					<input type="hidden" name="view" value="konten" />
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
								<th>NAMA KONTEN </th>
								<th>KETERANGAN KONTEN </th>
								<th>TANGGAL KONTEN </th>
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
                              <td ><a class='btn btn-primary btn-xs ' title='Edit Data' href='?view=konten&act=tambah&id=$r[idBulan]'><span class='glyphicon glyphicon-plus'></span> Tambah </a>
                            </tr>";

								if (isset($_GET['tahun'])) {
									$tampils = mysqli_query($conn, "SELECT rb_konten.*, rb_konten.nmKonten,
                                                      rb_konten.ketKonten,rb_konten.tglKonten,rb_konten.bulanKonten,bulan.idBulan,rb_konten.idTahunAjaran
                                                      FROM rb_konten
                                                      INNER JOIN bulan ON rb_konten.bulanKonten=bulan.idBulan 
                                                      INNER JOIN tahun_ajaran ON rb_konten.idtahunAjaran=tahun_ajaran.idTahunAjaran
                                                      where bulan.idBulan='$r[idBulan]' and rb_konten.idTahunAjaran='$_GET[tahun]' 
                                                      order by bulan.idBulan
                                                      ");
								} else {
									$tampils = mysqli_query($conn, "SELECT rb_konten.*, rb_konten.nmKonten,
                                                              rb_konten.ketKonten,rb_konten.tglKonten,rb_konten.bulanKonten,bulan.idBulan
                                                              FROM rb_konten
                                                              INNER JOIN bulan ON rb_konten.bulanKonten=bulan.idBulan 

                                                              where bulan.idBulan='$r[idBulan]'  
                                                              order by bulan.idBulan
                                                              ");
								}
								while ($row = mysqli_fetch_array($tampils)) {
									$tgl = date('Y-m-d');
									$cek = mysqli_query($conn, "SELECT * FROM rb_konten where  
                						nmKonten='$row[nmKonten]' and tglKonten='$row[tglKonten]' and status='Sudah'");
									$total = mysqli_num_rows($cek);

									if ($total >= 1) {
										$a = 'Belum';
										$absen = "<a class='btn btn-warning btn-xs' title='' href='?view=konten&act=onoff&id=$row[id]&a=$a' > Sudah Upload </a>";
									} else {
										$a = 'Sudah';
										$absen = "<a class='btn btn-danger btn-xs' title='$alt' href='?view=konten&act=onoff&id=$row[id]&a=$a'><span class='fa $icon'></span> Jadiin Sudah</a>";
									}


									echo "<tr>
									<td  colspan='2'></td>
           
            <td>$row[nmKonten] </td>
            <td>$row[ketKonten] </td>
			<td>" . tgl_indo($row['tglKonten']) . " </td>
			<td>$absen</td>
            <td style='width:70px !important'><center>
			
			
            <a class='btn btn-success btn-xs' title='Edit Jadwal' href='?view=konten&act=edit&id=$row[id]'><span class='glyphicon glyphicon-edit'></span></a>
            <a class='btn btn-danger btn-xs' title='Hapus Jadwal' href='?view=konten&hapus=$row[id]' onclick=\"return confirm('Apakah anda Yakin Data ini Dihapus?')\"><span class='glyphicon glyphicon-remove'></span></a>
            </center></td>
            </tr>";
									$no++;
								}
							}
							if (isset($_GET['hapus'])) {
								mysqli_query($conn, "DELETE FROM rb_konten where id='$_GET[hapus]'");
								echo "<script>document.location='?view=konten';</script>";
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
	$query = mysqli_query($conn, "UPDATE rb_konten SET status='$a' where id = '$_GET[id]'");


	if ($query) {
		echo "<script>document.location='?view=konten';</script>";
	} else {
		echo "<script>document.location='?view=konten';</script>";
	}
} elseif ($_GET['act'] == 'edit') {
	if (isset($_POST['update'])) {

		$query = mysqli_query($conn, "UPDATE rb_konten SET nmKonten='$_POST[nmKonten]', 
     ketKonten='$_POST[ketKonten]',tglKonten='$_POST[tglKonten]',
     bulanKonten='$_POST[bulanKonten]' where id = '$_POST[id]'");
		if ($query) {
			echo "<script>document.location='?view=konten&sukses';</script>";
		} else {
			echo "<script>document.location='?view=konten&gagal';</script>";
		}
	}
	$edit = mysqli_query($conn, "SELECT * FROM rb_konten where id='$_GET[id]'");
	$record = mysqli_fetch_array($edit);
	?>
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"> Edit Data Konten</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<form method="post" action="" class="form-horizontal">
						<input type="hidden" name="id" value="<?php echo $record['id']; ?>" readonly>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Nama Konten</label>
							<div class="col-sm-2">

								<input type="text" name="nmKonten" value="<?php echo $record['nmKonten']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Keterangan Konten</label>
							<div class="col-sm-6">
								<input type="text" name="ketKonten" value="<?php echo $record['ketKonten']; ?>" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Tanggal Konten</label>
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
		$cek = mysqli_query($conn, "SELECT * FROM rb_konten where idTahunAjaran='$_POST[tahun]' and nmKonten='$_POST[nmKonten]' 
	  	AND ketKonten='$_POST[ketKonten]' and tglKonten='$_POST[tglKonten]' and bulanKonten='$_POST[bulanKonten]'");
		$total = mysqli_num_rows($cek);

		if ($total >= 1) {
			echo "<script>document.location='?view=konten&sudah';</script>";
		} else {
			$query = mysqli_query($conn, "INSERT INTO rb_konten VALUES('','$_POST[tahun]','$_POST[nmKonten]','$_POST[ketKonten]'
				,'$_POST[tglKonten]','$_POST[bulanKonten]','Belum')");
			echo "<script>document.location='?view=konten&sukses';</script>";
		}
	}
	echo "<div class='col-md-12'>
				<div class='box box-info'>
				  <div class='box-header with-border'>
					<h3 class='box-title'>Tambah Data Konten </h3>
				  </div>
				<div class='box-body'>
				<form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
				  <div class='col-md-12'>
					<table class='table table-condensed table-bordered'>
					<tbody>         
					<tr><th scope='row'>Nama Konten</th>  <td>
									  <input class='form-control' name='nmKonten' >
										  
									  </input>
								  </td></tr>
								  <tr><th scope='row'>Keterangan Konten</th>  <td>
									  <input class='form-control' name='ketKonten' >
								  </input>
								  </td></tr>
								  <tr><th scope='row'>Tanggal Konten</th>  <td>
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