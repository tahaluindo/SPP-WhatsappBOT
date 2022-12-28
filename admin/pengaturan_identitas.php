<?php

if (isset($_POST['update'])) {

	$lokasi_file_kiri = $_FILES['flogokiri']['tmp_name'];
	$nama_file_kiri   = $_FILES['flogokiri']['name'];

	$lokasi_file_kanan = $_FILES['flogokanan']['tmp_name'];
	$nama_file_kanan  = $_FILES['flogokanan']['name'];

	// Apabila ada gambar yang diupload
	if (!empty($lokasi_file_kiri)) {

		UploadLogoKiri($nama_file_kiri);
		if (!empty($lokasi_file_kanan)) {

			UploadLogoKanan($nama_file_kanan);
			$query = mysqli_query($conn,"UPDATE identitas SET nmSekolah='$_POST[nmSekolah]',
												alamat='$_POST[alamat]',
												kabupaten='$_POST[kabupaten]',
												propinsi='$_POST[propinsi]',
												nmKepsek='$_POST[nmKepsek]',
												nipKaTU='$_POST[nipKaTU]',
												nmKaTU='$_POST[nmKaTU]',
												nipBendahara='$_POST[nipBendahara]',
												nmBendahara='$_POST[nmBendahara]',
												link='$_POST[link]',
												link_one_sender='$_POST[link_one_sender]',
												token='$_POST[token]',
												wa='$_POST[wa]',
												footer='$_POST[footer]',
                                                ket='$_POST[ket]',
                                                ket_lunas='$_POST[ket_lunas]',
												logo_kiri='$nama_file_kiri',
												logo_kanan='$nama_file_kanan',
                                                tema='$_POST[tema]'
									WHERE npsn = '$_POST[npsn]'");
		} else {
			$query = mysqli_query($conn,"UPDATE identitas SET nmSekolah='$_POST[nmSekolah]',
												alamat='$_POST[alamat]',
												kabupaten='$_POST[kabupaten]',
												propinsi='$_POST[propinsi]',
												nmKepsek='$_POST[nmKepsek]',
												nipKaTU='$_POST[nipKaTU]',
												nmKaTU='$_POST[nmKaTU]',
												nipBendahara='$_POST[nipBendahara]',
												link='$_POST[link]',
												link_one_sender='$_POST[link_one_sender]',
												token='$_POST[token]',
												wa='$_POST[wa]',
												footer='$_POST[footer]',
                                                ket='$_POST[ket]',
                                                ket_lunas='$_POST[ket_lunas]',
												nmBendahara='$_POST[nmBendahara]',
												logo_kiri='$nama_file_kiri',
                                                 tema='$_POST[tema]'
									WHERE npsn = '$_POST[npsn]'");
		}
	} else {
		if (!empty($lokasi_file_kanan)) {

			UploadLogoKanan($nama_file_kanan);
			$query = mysqli_query($conn,"UPDATE identitas SET nmSekolah='$_POST[nmSekolah]',
												alamat='$_POST[alamat]',
												kabupaten='$_POST[kabupaten]',
												propinsi='$_POST[propinsi]',
												nmKepsek='$_POST[nmKepsek]',
												nipKaTU='$_POST[nipKaTU]',
												nmKaTU='$_POST[nmKaTU]',
												nipBendahara='$_POST[nipBendahara]',
												link='$_POST[link]',
												link_one_sender='$_POST[link_one_sender]',
												token='$_POST[token]',
												wa='$_POST[wa]',
												footer='$_POST[footer]',
                                                ket='$_POST[ket]',
                                                ket_lunas='$_POST[ket_lunas]',
												nmBendahara='$_POST[nmBendahara]',
												logo_kanan='$nama_file_kanan',
                                                 tema='$_POST[tema]'
									WHERE npsn = '$_POST[npsn]'");
		} else {
			$query = mysqli_query($conn,"UPDATE identitas SET nmSekolah='$_POST[nmSekolah]',
												alamat='$_POST[alamat]',
												kabupaten='$_POST[kabupaten]',
												propinsi='$_POST[propinsi]',
												nmKepsek='$_POST[nmKepsek]',
												nipKaTU='$_POST[nipKaTU]',
												nmKaTU='$_POST[nmKaTU]',
												nipBendahara='$_POST[nipBendahara]',
												link='$_POST[link]',
												link_one_sender='$_POST[link_one_sender]',
												token='$_POST[token]',
												wa='$_POST[wa]',
												footer='$_POST[footer]',
                                                ket='$_POST[ket]',
                                                ket_lunas='$_POST[ket_lunas]',
												nmBendahara='$_POST[nmBendahara]',
                                                 tema='$_POST[tema]'
									WHERE npsn = '$_POST[npsn]'");
		}
	}

	if ($query) {
		echo "<div class='col-md-12'><div class='alert alert-success alert-dismissible fade in' role='alert'> 
		  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		  <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil Disimpan..
		  </div></div>";
	} else {
		echo "<div class='col-md-12'><div class='alert alert-danger alert-dismissible fade in' role='alert'> 
		  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		  <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data gagal disimpan...
		  </div></div>";
	}
}
$edit = mysqli_query($conn,"SELECT * FROM identitas where npsn='10700295'");
$record = mysqli_fetch_array($edit);

$sqlPolygon = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_absensi_setting WHERE type='polygonSetting'"));
$listPolygon = base64_encode(json_encode(isset($sqlPolygon) ? json_decode($sqlPolygon['value']) : []));

if (isset($_POST['type']) && $_POST['type'] == 'polygonSetting') {
	foreach($_POST['lat'] as $i => $v){
		$dataPolygon[] = [
			'lat' => $v,
			'lng' => $_POST['lng'][$i]
		];
	}
	mysqli_query($conn, "INSERT INTO rb_absensi_setting(type, value) VALUES('" .$_POST['type']. "', '" .json_encode($dataPolygon). "')");
	echo '<script>window.location="";</script>';
}

if(isset($_GET['act']) && $_GET['act'] == 'ulangpolygon'){
	mysqli_query($conn, "DELETE FROM rb_absensi_setting WHERE type='polygonSetting'");
	echo '<script>window.location="?view=pengaturan";</script>';
}

$sqlWaktu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM rb_absensi_setting WHERE type='waktuSetting'"));
$listWaktu = (isset($sqlWaktu) ? explode(',', $sqlWaktu['value']) : []);

if(isset($_POST['type']) && $_POST['type'] == 'waktuSetting'){
	mysqli_query($conn, "DELETE FROM rb_absensi_setting WHERE type='waktuSetting'");
	mysqli_query($conn, "INSERT INTO rb_absensi_setting(type, value) VALUES('" .$_POST['type']. "', '" .$_POST['jam_masuk'] . ',' . $_POST['jam_pulang']. "')");
	echo '<script>window.location="";</script>';
}
?>

<div class="col-md-8">
	<div class="box box-warning box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"> Pengaturan Perusahaan</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
				<input type="hidden" name="npsn" value="<?php echo $record['npsn']; ?>">

				<div class="col-md-6">
				<label for="" class=" control-label">Nama Perusahaan</label>
				<input type="text" name="nmSekolah" class="form-control" value="<?php echo $record['nmSekolah']; ?>" required>
				</div>
				
				<div class="col-md-6">
					<label for="" class=" control-label">Alamat Perusahaan</label>
						<input type="text" name="alamat" class="form-control" value="<?php echo $record['alamat']; ?>" required>
				</div>
				<div class="col-sm-6">
					<label for="" class=" control-label">Kabupaten/Kota</label>
						<input type="text" name="kabupaten" class="form-control" value="<?php echo $record['kabupaten']; ?>" required>
				</div>
				<div class="col-sm-6">
					<label for="" class=" control-label">Provinsi</label>
					<input type="text" name="propinsi" class="form-control" value="<?php echo $record['propinsi']; ?>" required>
				</div>

				<div class="col-sm-4">
					<label for="" class=" control-label">Nama CEO</label>
					<input type="text" name="nmKepsek" class="form-control" value="<?php echo $record['nmKepsek']; ?>" required>
				</div>

				<div class="col-sm-4">
					<label for="" class=" control-label">Nama CTO</label>
					<input type="text" name="nmKaTU" class="form-control" value="<?php echo $record['nmKaTU']; ?>" required>
				</div>

				<div class="col-sm-4">
					<label for="" class=" control-label">Nama Finance</label>
					<input type="text" name="nmBendahara" class="form-control" value="<?php echo $record['nmBendahara']; ?>" required>
				</div>
				<div class="col-sm-6">
					<label for="" class=" control-label">Ganti Logo Kiri</label>
					<input type="file" name="flogokiri" class="form-control">
				</div>
				<div class="col-sm-6">
					<label for="" class=" control-label">Ganti Logo Kanan</label>
					<input type="file" name="flogokanan" class="form-control">
				</div>
				<div class="col-sm-6">
					<label for="" class=" control-label">Client Key Midtrans</label>
					<input type="text" name="nipBendahara" class="form-control" value="<?php echo $record['nipBendahara']; ?>">
				</div>
				<div class="col-sm-6">
					<label for="" class=" control-label">Server Key </label>
					<input type="text" name="nipKaTU" class="form-control" value="<?php echo $record['nipKaTU']; ?>">
				</div>

				<div class="col-sm-6">
					<label for="" class=" control-label">Link Snap JS</label>
					
						<select class="form-control" name="link">
							<option value="<?php echo $record['link']; ?>"><?php echo $record['link']; ?></option>
							<option value="https://app.sandbox.midtrans.com/snap/snap.js">Sandbox</option>
							<option value="https://app.midtrans.com/snap/snap.js">Production</option>


						</select>
											
				</div>
				<div class="col-sm-6">
					<label for="" class=" control-label">Link WhatsApp GW </label>
					
						<input type="text" name="link_one_sender" class="form-control" value="<?php echo $record['link_one_sender']; ?>">
					
				</div>
				<div class="col-sm-6">
					<label for="" class=" control-label">Token </label>
				
						<input type="text" name="token" class="form-control" value="<?php echo $record['token']; ?>">
					
				</div>
				<div class="col-sm-6">
					<label for="" class=" control-label">Nomor Pengirim </label>
					
						<input type="text" name="wa" class="form-control" value="<?php echo $record['wa']; ?>">
				
				</div>
              <div class="col-sm-12">
					<label for="" class=" control-label">Tema Aplikasi</label>
					<select class="form-control" name="tema">
						<option value="<?php echo $record['tema']; ?>"><?php echo $record['tema']; ?></option>
						<option value="yellow">Yellow</option>
						<option value="yellow-light">Yellow Light</option>
						<option value="green">Green</option>
						<option value="green-light">Green Light</option>
						<option value="black">Black</option>
						<option value="black-light">Black Light</option>
						<option value="purple">Purple</option>
						<option value="purple-light">Purple Light</option>
						<option value="red">Red</option>
						<option value="red-light">Red Light</option>

					</select>

				</div>
				<div class="col-md-12">
              <label for="" class="control-label">Footer</label>
              <div class="md-form amber-textarea active-amber-textarea">
                <textarea id="form19" style="resize:none;height:190px;" class="md-textarea form-control" name="footer" rows="3"><?php echo $record['footer']; ?></textarea>

              </div>
            </div>
              <div class="col-md-6">
              <label for="" class="control-label">Keterangan Invoice DP</label>
              <div class="md-form amber-textarea active-amber-textarea">
                <textarea id="form19" style="resize:none;height:150px;" class="md-textarea form-control" name="ket" rows="3"><?php echo $record['ket']; ?></textarea>

              </div>
            </div>
				<div class="col-md-6">
              <label for="" class="control-label">Keterangan Invoice Pelunasan</label>
              <div class="md-form amber-textarea active-amber-textarea">
                <textarea id="form19" style="resize:none;height:150px;" class="md-textarea form-control" name="ket_lunas" rows="3"><?php echo $record['ket_lunas']; ?></textarea>

              </div>
            </div>
			  <div class=" form-group">
            <label for="" class="col-sm-2 control-label"></label>
            <div class="col-sm-12">
					
						<input type="submit" name="update" value="Simpan Data" class="btn btn-success">
</div>
					
				</div>
			</form>
		</div>
	</div>
</div>

<div class="col-md-4">
	<div class="box box-warning box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"> Logo Kop Surat</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<table class="table table-bordered">
				<tr class="danger">
					<th class="text-center">Logo Kiri</th>
				</tr>
				<tr>
					<td class="text-center">
						<img src="./gambar/logo/<?php echo $record['logo_kiri']; ?>" width="160px">
					</td>
				</tr>
			</table>
			<hr>
			<table class="table table-bordered">
				<tr class="success">
					<th class="text-center">Logo Kanan</th>
				</tr>
				<tr>
					<td class="text-center">
						<img src="./gambar/logo/<?php echo $record['logo_kanan']; ?>" width="160px">
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>


<script>
	var biayaAdmin = document.getElementById('biayaAdmin');
	biayaAdmin.addEventListener('keyup', function(e) {
		biayaAdmin.value = formatRupiah(this.value);
	});

	function formatRupiah(angka, prefix) {
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			rupiah = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);

		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}

	// MAPS
	// Creating map options
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			// var mapOptions = {
			// 	center: [position.coords.latitude, position.coords.longitude],
			// 	zoom: 6
			// }
			// Creating a map object
			// var map = new L.map('map', mapOptions);
			// // Creating a Layer object
			// var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

			// // Adding layer to the map
			// map.addLayer(layer);

			var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
			var layer = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
				maxZoom: 18,
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
					'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
				id: 'mapbox/satellite-v9',
				tileSize: 512,
				zoomOffset: -1
			}).addTo(map);
			// var dataMarker = [];

			var listPolygon = [];
			JSON.parse(atob('<?= $listPolygon ?>')).forEach(item => {
				listPolygon.push([item.lat, item.lng]);
			});

			L.polygon(listPolygon).addTo(map);

			var initPolygon = null;
			var newPolygon = [];
			map.on('click', function(position) {
				var latlng = [position.latlng.lat, position.latlng.lng];
				// var newMarker = new L.Marker([position.latlng.lat, position.latlng.lng]);
				// dataMarker.push(newMarker);
				// newMarker.addTo(map)
				// console.log([position.latlng.lat, position.latlng.lng]);
				$("#parent-polygon").append(`<input type='text' value='${latlng[0]}' name='lat[]' hidden><input type='text' value='${latlng[1]}' name='lng[]' hidden>`)
				newPolygon.push(latlng);

				if (initPolygon != null) {
					map.removeLayer(initPolygon);
				}

				initPolygon = L.polygon(newPolygon);
				initPolygon.addTo(map);

				if (newPolygon.length > 0) {
					document.getElementById("resetPolygon").style = 'display: inline;';
				} else {
					document.getElementById("resetPolygon").style = 'display: none;';
				}

				if (newPolygon.length >= 3) {
					document.getElementById("simpanPolygon").style = 'display: inline;';
				} else {
					document.getElementById("simpanPolygon").style = 'display: none;';
				}
			});

			document.getElementById("resetPolygon").addEventListener('click', function(e) {
				e.preventDefault();
				if (initPolygon != null) map.removeLayer(initPolygon);
				initPolygon = null;
				newPolygon = [];
				$("#parent-polygon").html('');

				document.getElementById("simpanPolygon").style = 'display: none;';
				this.style = 'display: none';
			})

			var mymarker = new L.Marker([position.coords.latitude, position.coords.longitude]);
			mymarker.addTo(map);
			// map.setView([position.coords.latitude, position.coords.longitude], 5, {
			// 	animation: true
			// });
		})
	}
</script>
