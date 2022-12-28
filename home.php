<?php
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/excel_reader.php";
include "config/fungsi_seo.php";
include "config/fungsi_thumb.php";
if (isset($_GET['tampil'])) {
	$tahun = $_GET['tahun'];
	$kelas = $_GET['kelas'];
} else {
	$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas "));

	$kelas = '';
}
?>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Aplikasi Pembayaran Sekolah</title>

	<link rel="shortcut icon" href="favicon.ico">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.5 -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/style.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="./assets/font-awesome-4.6.3/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="./assets/ionicons/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
	<link rel="stylesheet" href="plugins/datetimepicker/bootstrap-datetimepicker.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
	<!-- Bootstrap Select -->
	<link rel="stylesheet" href="assets/bootstrap-select/css/bootstrap-select.min.css" />
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<style type="text/css">
		.files {
			position: absolute;
			z-index: 2;
			top: 0;
			left: 0;
			filter: alpha(opacity=0);
			-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
			opacity: 0;
			background-color: transparent;
			color: transparent;
		}
	</style>
	<script type="text/javascript" src="plugins/jQuery/jquery-1.12.3.min.js"></script>
	<script language="javascript" type="text/javascript">
		var maxAmount = 160;

		function textCounter(textField, showCountField) {
			if (textField.value.length > maxAmount) {
				textField.value = textField.value.substring(0, maxAmount);
			} else {
				showCountField.value = maxAmount - textField.value.length;
			}
		}
	</script>
	<script type="text/javascript" src="getDataCombo.js"></script>

</head>
<font face="Comic Sans MS">

</html>
<center>
	<div class="col-xs-12">


		<h3> Pilih Kelas Anda !!! </h3>
</center>
<div class="col-xs-12">
	<div class="box box-primary box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Tagihan Siswa</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="" class="form-horizontal">
				<input type="hidden" name="view" value="laptagihansiswa">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Kelas</th>

							<th>Tahun Ajaran</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>

							<td>
								<select id="kelas" name="kelas" class="form-control" required>
									<option value="" selected> - Pilih Kelas - </option>
									<?php
									$sqk = mysqli_query($conn,"SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
									while ($k = mysqli_fetch_array($sqk)) {
										$selected = ($k['idKelas'] == $kelas) ? ' selected="selected"' : "";
										echo "<option value=" . $k['idKelas'] . " " . $selected . ">" . $k['nmKelas'] . "</option>";
									}
									?>
								</select>
							</td>

							<td>
								<select id="tahun" name="tahun" class="form-control" required>
									<?php
									$sqltahun = mysqli_query($conn,"SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran ASC");
									while ($t = mysqli_fetch_array($sqltahun)) {
										$selected = ($t['idTahunAjaran'] == $tahun) ? ' selected="selected"' : "";
										echo "<option value=" . $t['idTahunAjaran'] . " " . $selected . ">" . $t['nmTahunAjaran'] . "</option>";
									}
									?>
								</select>
							</td>
							<td width="100">
								<input type="submit" name="tampil" value="Tampilkan" class="btn btn-success pull-right">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /.box -->

	<?php
	if (isset($_GET['tampil'])) {
		$sqlSiswa = mysqli_query($conn,"SELECT *
								FROM
									view_detil_siswa
								WHERE idKelas='$_GET[kelas]' AND statusSiswa='Aktif' ORDER BY nmSiswa ASC");
	?>
		<center>
			<h3> Pilih Nama Anda, dan Klik Cetak Tagihan !!!</h3>
		</center>
		<div class="box box-primary">
			<div class="box-body">
				<table id="example1" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>NIS</th>
							<th>NISN</th>
							<th>Nama Siswa</th>
							<th>Kelas</th>
							<th>Cetak</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						while ($ds = mysqli_fetch_array($sqlSiswa)) {
							echo "<tr>
							<td>$no</td>
							<td>$ds[nisSiswa]</td>
							<td>$ds[nisnSiswa]</td>
							<td>$ds[nmSiswa]</td>
							<td>$ds[nmKelas]</td>
							<td class=''>
								<a href='./cetak_tagihan_persiswa.php?siswa=$ds[idSiswa]&tahun=$_GET[tahun]' class='btn btn-danger btn-sm' target='_blank'><span class='glyphicon glyphicon-print'></span> Cetak Tagihan</a>
							</td>
						</tr>";
							$no++;
						}
						?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
			<div class="box-footer">
				<a class="btn btn-danger" target="_blank" href="./cetak_tagihan_siswa_semua.php?kelas=<?php echo $_GET['kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>"><span class="glyphicon glyphicon-print"></span> Cetak Semua Tagihan</a>
				<a class="btn btn-success" target="_blank" href="./excel_tagihan_siswa_semua.php?kelas=<?php echo $_GET['kelas']; ?>&tahun=<?php echo $_GET['tahun']; ?>"><span class="glyphicon glyphicon-file"></span> Export ke Excel</a>
			</div>
		</div><!-- /.box -->
	<?php
	}
	?>
</div>
<br><br><br><br>




<center>
	<form action="index.php" method="post">
		<input type="submit" name="tampil" value="Kembali Ke Beranda" class="btn btn-success pull-center">
</center>