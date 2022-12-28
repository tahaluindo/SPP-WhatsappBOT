<?php 
$uri = str_replace('&id='.$_GET['id'],NULL,$_SERVER['REQUEST_URI']);
include "./config/rupiah.php";
include "../config/koneksi.php";
$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas"));
$link = $idt['link_one_sender'];
$links = $idt['token'];
$wa = $idt['wa'];
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
<?php if ($_GET['act'] == '') { ?>
	<div class="col-xs-4">
		<div class="box box-info box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Informasi Tagihan</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php

				$siswa = $_GET['siswa'];
				$sqlInfoTagihanSiswa = mysqli_query($conn,"SELECT jenis_bayar.idJenisBayar,
									jenis_bayar.nmJenisBayar,
									jenis_bayar.tipeBayar,
									jenis_bayar.idTahunAjaran,
									tahun_ajaran.nmTahunAjaran,
									Sum(tagihan_bulanan.jumlahBayar) AS jmlTagihanBulanan,
									kelas_siswa.idKelas,
									kelas_siswa.nmKelas,
									siswa.nisSiswa,
									siswa.nisnSiswa,
									siswa.nmSiswa
									FROM
									jenis_bayar
									INNER JOIN tagihan_bulanan ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
									INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
									INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
									INNER JOIN kelas_siswa ON tagihan_bulanan.idKelas = kelas_siswa.idKelas
									WHERE jenis_bayar.idJenisBayar='$_GET[jenis]' AND jenis_bayar.idTahunAjaran='$_GET[tahun]' AND siswa.idSiswa='$siswa'
									GROUP BY
									jenis_bayar.idJenisBayar");
				$dtInfo = mysqli_fetch_array($sqlInfoTagihanSiswa);

				?>
				<table class="table table-striped">
					<tr>
						<td>Jenis</td>
						<td>:</td>
						<td><?php echo $dtInfo['nmJenisBayar']; ?></td>
					</tr>
					<tr>
						<td>Tahun Ajaran</td>
						<td>:</td>
						<td><?php echo $dtInfo['nmTahunAjaran']; ?></td>
					</tr>
					<tr>
						<td>NIS</td>
						<td>:</td>
						<td><?php echo $dtInfo['nisSiswa']; ?></td>
					</tr>
					<tr>
						<td>NISN</td>
						<td>:</td>
						<td><?php echo $dtInfo['nisnSiswa']; ?></td>
					</tr>
					<tr>
						<td>Nama Siswa</td>
						<td>:</td>
						<td><?php echo $dtInfo['nmSiswa']; ?></td>
					</tr>
					<tr>
						<td>Kelas</td>
						<td>:</td>
						<td><?php echo $dtInfo['nmKelas']; ?></td>
					</tr>
					<tr class="warning">
						<td>Total Tagihan</td>
						<td>:</td>
						<td><b><?php echo buatRp($dtInfo['jmlTagihanBulanan']); ?></b></td>
					</tr>
				</table>
			</div>
			<div class="box-footer">
				<a href="index.php?view=pembayaran&siswa=<?php echo $siswa; ?>&cari=Cari+Siswa" class="btn btn-primary pull-right"><span class="fa fa-reply"></span> Kembali</a>
			</div>
		</div>
	</div>
	<div class="col-xs-8">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Pembayaran Tagihan Bulanan</h3>
				<span class="pull-right">

					<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#ModalCetakSemuaSlip"><span class="fa fa-print"></span> Cetak Semua Slip</button>

					<a class="btn btn-success btn-xs" target="_blank" title="Cetak Slip" href="./slip_bulanan_persiswa.php?tahun=<?php echo $_GET['tahun']; ?>&jenis=<?php echo $dtInfo['idJenisBayar']; ?>&siswa=<?php echo $siswa; ?>"><span class="fa fa-print"></span> Cetak Semua</a>
				</span>
			</div><!-- /.box-header -->

			<!-- modal filter tanggal cetak semua slip -->
			<div id="ModalCetakSemuaSlip" class="modal fade" role="dialog">
				<form method="GET" action="./slip_bulanan_persiswa_peritem.php" class="form-horizontal" target="_blank" title="Cetak Slip">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Filter Data</h4>
							</div>
							<div class="modal-body">
								<input type="hidden" name="tahun" value="<?php echo $_GET['tahun']; ?>">
								<input type="hidden" name="siswa" value="<?php echo $siswa; ?>">
								<input type="hidden" name="kelas" value="<?php echo $dtInfo['idKelas']; ?>">

								<table class="table table-striped">
									<thead>
										<tr>
											<th>Mulai</th>
											<th>Sampai</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" name="tgl1" id="tgl1" class="form-control pull-right date-picker" required="">
												</div>
												<!-- /.input group -->
											</td>
											<td>
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" name="tgl2" id="tgl2" class="form-control pull-right date-picker" required="">
												</div>
												<!-- /.input group -->
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<input type="submit" value="Cetak" class="btn btn-success" onclick="checkTanggal('#tgl1','#tgl2');">
								<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!-- /.modal filter tanggal cetak semua slip -->




			<div class="box-body">
				<?php
				if (isset($_GET['ok'])) {
					$url_sms = 'https://gsm.zenziva.net/api/balance/?userkey=vmezut&passkey=ceabd0a34bde5902f2c8a2da';
					$get_content_sms = file_get_contents($url_sms);
					$json = json_decode($get_content_sms, TRUE);
					$credit_sms = $json['credit'];
					echo "<div class='alert alert-success'><b>SUKSES</b> - SMS ke Orang Tua Berhasil dikirimkan! <b style='float:right'>(Sisa Kuota $credit_sms SMS)</b></div>";
				} elseif (isset($_GET['err'])) {
					echo "<div class='alert alert-danger'><b>GAGAL</b> - Notifikasi SMS Gagal Terkirim, Cek Lagi No Tujuan!</div>";
				}
				?>
				<table class="table table-striped table-hover table-condensed">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama Bulan</th>
							<th>Tagihan</th>

							<th width="110px">Tgl. Bayar</th>
							<th>Opsi</th>
							<th>Bayar</th>
							<th>Cetak</th>

							<th>Tagihan Wa</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sqlSiswa1 = mysqli_query($conn,"SELECT siswa.*,kelas_siswa.nmKelas FROM siswa
											INNER JOIN kelas_siswa ON siswa.idKelas = kelas_siswa.idKelas
											WHERE siswa.idSiswa='$siswa'");
						$dts = mysqli_fetch_array($sqlSiswa1);
						$sqlTagihanBulanan = mysqli_query($conn,"SELECT
										tagihan_bulanan.idTagihanBulanan,
										tagihan_bulanan.idJenisBayar,
										tagihan_bulanan.idSiswa,
										tagihan_bulanan.idKelas,
										tagihan_bulanan.idBulan,
										tagihan_bulanan.jumlahBayar,
										tagihan_bulanan.tglBayar,
										tagihan_bulanan.tglUpdate,
										tagihan_bulanan.statusBayar,
										tagihan_bulanan.caraBayar,
										jenis_bayar.idPosBayar,
										jenis_bayar.idTahunAjaran,
										jenis_bayar.nmJenisBayar,
										jenis_bayar.tipeBayar,
										siswa.nisSiswa,
										siswa.nisnSiswa,
										siswa.nmSiswa,
										siswa.jkSiswa,
										siswa.agamaSiswa,
										siswa.idKelas,
										siswa.statusSiswa,
										tahun_ajaran.nmTahunAjaran,
										kelas_siswa.nmKelas,
										bulan.nmBulan,
										bulan.urutan
									FROM
										tagihan_bulanan
									INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
									INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
									INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
									INNER JOIN kelas_siswa ON tagihan_bulanan.idKelas = kelas_siswa.idKelas
									INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
									INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
									WHERE jenis_bayar.idJenisBayar='$_GET[jenis]' AND jenis_bayar.idTahunAjaran='$_GET[tahun]' AND siswa.idSiswa='$siswa' ORDER BY bulan.urutan ASC");
						$no = 1;
						while ($rt = mysqli_fetch_array($sqlTagihanBulanan)) {
							if ($rt['statusBayar'] == 0) {
								$status = 1;
								$icon = "fa-check";
								$btn = "btn-danger";
								$statusBayar = "Belum Bayar";
								$color = "red";
								$btnBayar = "disabled";
								$alt = "Bayar Sekarang";
								$onClick = "return confirm('Akan Melakukan Pembayaran bulan $rt[nmBulan] ?')";
								$opsi = " Bayar";
								$tombolBayar = "<input type='submit' class='btn btn-success btn-xs' value='Bayar'>";
								$inputTanggal = "<input type='text' class='form-control datepicker text-center' name='tglBayar' value='" . date('Y-m-d') . "'>";
								$comboCaraBayar = "<select style='width: 90px;' name='caraBayar' class='form-control select-sm'>
														<option value='Tunai'>Tunai</option>
														<option value='Transfer'>Transfer</option>
													</select>";
							} else {
								$status = 0;
								$icon = "fa-close";
								$btn = "btn-danger";
								$statusBayar = "Lunas";
								$color = "green";
								$btnBayar = "";
								$alt = "Hapus Pembayaran";
								$onClick = "return confirm('Akan Menghapus Pembayaran bulan $rt[nmBulan] ?')";
								$opsi = "";
								$inputTanggal = "<input type='text' class='form-control datepicker text-center' name='tglBayar' value='$rt[tglBayar]' disabled>";
								$comboCaraBayar = $rt['caraBayar'];
								$tombolBayar = "<a class='btn $btn btn-xs' title='$alt' href='?view=bayarbulanan&act=hapus&tahun=$rt[idTahunAjaran]&tipe=bulanan&siswa=$rt[idSiswa]&idt=$rt[idTagihanBulanan]&idjenis=$rt[idJenisBayar]&status=$status&bln=$rt[nmBulan]' 
												onclick=\"$onClick\"><span class='fa $icon'>$opsi</span></a>";
							}
							echo "<tr style='color:$color'>								
								<td>$no</td>
								<td>$rt[nmBulan]</td>
								<td>" . buatRp($rt['jumlahBayar']) . "</td>
							
								<td>
									<form method='get' action='index.php'>
									<input type='hidden' name='view' value='bayarbulanan'>
									<input type='hidden' name='act' value='bayar'>
									<input type='hidden' name='tahun' value='$rt[idTahunAjaran]'>
									<input type='hidden' name='tipe' value='bulanan'>
									<input type='hidden' name='siswa' value='$rt[idSiswa]'>
									<input type='hidden' name='idt' value='$rt[idTagihanBulanan]'>
									<input type='hidden' name='idjenis' value='$rt[idJenisBayar]'>
									<input type='hidden' name='status' value='$status'>
									$inputTanggal
								</td>
								<td class='text-center'>
									$comboCaraBayar
								</td>
								<td style='text-align:center'>									
									$tombolBayar
								</form>";
							if ($rt['statusBayar'] != 0) {
								echo "
									<a class='btn btn-info btn-xs' title='Kirimkan Notifikasi WhatsApp Lunas' href='https://api.whatsapp.com/send?phone=$dts[noHpOrtu]&text=Assalamualaikum, Terima Kasih pembayaran Tagihan bulanan untuk bulan $rt[nmBulan] sebesar  *" . buatRp($rt['jumlahBayar']) . "* anak anda yang bernama *$rt[nmSiswa]*, *Lunas* Terima kasih (Keuangan Smk Aswaja).' target='_blank'><span class='fa fa-commenting'></span></a></td>";
							}
							echo "<td width='105px'>
									<a class='btn btn-success btn-xs $btnBayar' target='_blank' title='Cetak Slip' href='./slip_bulanan_persiswa_perbulan.php?tagihan=$rt[idTagihanBulanan]'><span class='fa fa-print'></span> Cetak</a>
								</td>
								
								
						<td class='text-center'>
							<a class='btn btn-info btn-xs' title='Kirimkan Notifikasi Tagihan' href='https://api.whatsapp.com/send?phone=$dts[noHpOrtu]&text=Assalamualaikum, Harap menyelesaikan pembayaran Tagihan bulanan untuk bulan $rt[nmBulan] sebesar *" . buatRp($rt['jumlahBayar']) . "* anak anda yang bernama *$rt[nmSiswa]*, Terima kasih (Keuangan Smk Aswaja). ' target='_blank'><span class='fa fa-commenting'></span>Kirim</a>
						</td>
							</tr>";
							$no++;
						}

						if (isset($_GET['sms'])) {
							$row = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM siswa where idSiswa='$_GET[siswa]'"));
							if ($row['noHpOrtu'] == '') {
								echo "<script>document.location='index.php?view=bayarbulanan&jenis=$_GET[jenis]&tahun=$_GET[tahun]&siswa=$_GET[siswa]&err';</script>";
							} else {
								$userkey = "vmezut";
								$passkey = "ceabd0a34bde5902f2c8a2da";
								$telepon = $row['noHpOrtu'];
								$message = "Assalamualaikum, Harap menyelesaikan pembayaran Tagihan bulanan anak anda $row[nmSiswa] untuk bulan $_GET[bln], Terima kasih.";
								$url = "https://gsm.zenziva.net/api/sendsms/";
								$curlHandle = curl_init();
								curl_setopt($curlHandle, CURLOPT_URL, $url);
								curl_setopt($curlHandle, CURLOPT_HEADER, 0);
								curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
								curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
								curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
								curl_setopt($curlHandle, CURLOPT_POST, 1);
								curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
									'userkey' => $userkey,
									'passkey' => $passkey,
									'nohp' => $telepon,
									'pesan' => $message
								));
								$results = json_decode(curl_exec($curlHandle), true);
								curl_close($curlHandle);
								echo "<script>document.location='index.php?view=bayarbulanan&jenis=$_GET[jenis]&tahun=$_GET[tahun]&siswa=$_GET[siswa]&ok';</script>";
							}
						} elseif (isset($_GET['lunas'])) {
							$row = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM siswa where idSiswa='$_GET[siswa]'"));
							if ($row['noHpOrtu'] == '') {
								echo "<script>document.location='index.php?view=bayarbulanan&jenis=$_GET[jenis]&tahun=$_GET[tahun]&siswa=$_GET[siswa]&err';</script>";
							} else {
								$userkey = "vmezut";
								$passkey = "ceabd0a34bde5902f2c8a2da";
								$telepon = $row['noHpOrtu'];
								$message = "Assalamualaikum, Pembayaran Tagihan bulanan anak anda $row[nmSiswa] untuk bulan $_GET[bln] telah Lunas, Terima kasih.";
								$url = "https://gsm.zenziva.net/api/sendsms/";
								$curlHandle = curl_init();
								curl_setopt($curlHandle, CURLOPT_URL, $url);
								curl_setopt($curlHandle, CURLOPT_HEADER, 0);
								curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
								curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
								curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
								curl_setopt($curlHandle, CURLOPT_POST, 1);
								curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
									'userkey' => $userkey,
									'passkey' => $passkey,
									'nohp' => $telepon,
									'pesan' => $message
								));
								$results = json_decode(curl_exec($curlHandle), true);
								curl_close($curlHandle);
								echo "<script>document.location='index.php?view=bayarbulanan&jenis=$_GET[jenis]&tahun=$_GET[tahun]&siswa=$_GET[siswa]&ok';</script>";
							}
						}
						?>

					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
<?php
} elseif ($_GET['act'] == 'bayar') {
	if ($_GET['tipe'] == 'bulanan') {
		//$tglBayar = date("Y-m-d H:i:s");
		$tglBayar = $_GET['tglBayar'];
		$caraBayar = $_GET['caraBayar'];
		$query = mysqli_query($conn,"UPDATE tagihan_bulanan SET tglBayar='$tglBayar', statusBayar='$_GET[status]', caraBayar='$caraBayar' WHERE idTagihanBulanan='$_GET[idt]'");


		$a = mysqli_query($conn,"SELECT nmBulan as Bulan, nmSiswa as nama, noHpOrtu as hpo, noHpSis as hps, jumlahBayar as tagihan FROM siswa 
		INNER JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa 
		INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan         
		WHERE idTagihanBulanan='$_GET[idt]'    
		  "); 	

		$re = mysqli_fetch_array($a);
		
		$tagihan = $re['tagihan'];
		$siswa = $re['nama'];
		$hpo = $re['hpo'];
		$hps = $re['hps'];
		$bulan = $re['Bulan'];					

		$tagihan_bulan = [$hpo, $hps];					

		$msg =  "Assalamualaikum, Terima Kasih pembayaran Tagihan bulanan untuk bulan $bulan sebesar *Rp.".rupiah($tagihan)."* anak anda yang bernama *$siswa*, *Lunas* Terima kasih";				
		$msgs =  "Assalamualaikum, Terima Kasih pembayaran Tagihan bulanan untuk bulan $bulan sebesar *Rp.".rupiah($tagihan)."*  anda yang bernama *$siswa*, *Lunas* Terima kasih";				

		    

		$phone = $hpo;	

		$data = [
			"api_key" => $links,
			"sender" => $wa,
			"number" => $phone,
			"message" => $msg
		];
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $idt['link_one_sender'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);


		echo $msg . '<br>';
		var_dump($response);

			$phone = $hps;	

			
		$data2 = [
			"api_key" => $links,
			"sender" => $wa,
			"number" => $phone,
			"message" => $msgs
		];
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $idt['link_one_sender'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($data2),
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
			),
		));

		$response2 = curl_exec($curl);

		curl_close($curl);


		echo $msgs . '<br>';
		var_dump($response2);						

		

		echo "<script>document.location='index.php?view=bayarbulanan&jenis=$_GET[idjenis]&tahun=$_GET[tahun]&siswa=$_GET[siswa]';</script>";		


	}

?>
<?php
} elseif ($_GET['act'] == 'hapus') {
	if ($_GET['tipe'] == 'bulanan') {
		//$tglBayar = date("Y-m-d H:i:s");
		$tglBayar = $_GET['tglBayar'];
		$caraBayar = $_GET['caraBayar'];
		$query = mysqli_query($conn,"UPDATE tagihan_bulanan SET tglBayar=null, statusBayar='0', caraBayar=null WHERE idTagihanBulanan='$_GET[idt]'");

		echo "<script>document.location='index.php?view=bayarbulanan&jenis=$_GET[idjenis]&tahun=$_GET[tahun]&siswa=$_GET[siswa]';</script>";		


	}
}
?>