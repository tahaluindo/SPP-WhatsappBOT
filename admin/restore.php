<section class="content-header">
	<small>
		<h1>Restore Database</h1>
	</small>
	<ol class="breadcrumb">
		<li><a href="index.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
		<li class="active">Restore Database</li>
	</ol>
</section>
<section class="content">
	<div class="col-xs-12">
		<div class="box box-info box-solid">
			<div class="box-header with-border">
				<h3 class="box-title"> </h3>
				<form enctype="multipart/form-data" method="post" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-3 control-label">File Database (*.sql)</label>
						<div class="col-sm-7">
							<input type="text" name="nip" class="form-control" maxlength="16">
							<input type="file" name="datafile" size="20" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" name="restore" class="btn btn-danger">Restore Database</button>
						</div>
					</div>
				</form>
				<P>Abaikan Pesan Error Di Bawah Proses Restore Anda Tetap Berhasil :) </p>
				<?php
				if (isset($_POST['restore'])) {
					$koneksi = mysqli_query($conn,"localhost", "root", "");
					mysqli_select_db("spp", $koneksi);

					$nama_file = $_FILES['datafile']['name'];
					$ukuran = $_FILES['datafile']['size'];

					if ($nama_file == "") {
						echo "Fatal Error";
					} else {
						//definisikan variabel file dan alamat file
						$uploaddir = './application/';
						$alamatfile = $uploaddir . $nama_file;

						if (move_uploaded_file($_FILES['datafile']['tmp_name'], $alamatfile)) {
							$filename = './application/' . $nama_file . '';
							$templine = '';
							$lines = file($filename);

							foreach ($lines as $line) {
								if (substr($line, 0, 2) == '--' || $line == '')
									continue;

								$templine .= $line;
								if (substr(trim($line), -1, 1) == ';') {
									mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
									$templine = '';
								}
							}
							echo "<center>Restore Database Telah Berhasil, Silahkan dicek !</center>";
						} else {
							echo "Restore Database Gagal, kode error = " . $_FILES['location']['error'];
						}
					}
				} else {
					unset($_POST['restore']);
				}
				?>
			</div>
		</div>
	</div>
	</div>
	</div>
</section>