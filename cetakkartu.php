<?php
session_start();
include "config/koneksi.php";
if (empty($_SESSION['idSiswa']) and empty($_SESSION['nmSiswa']))
	$nis = $_SESSION['idSiswa'];
$qtampil = mysqli_query($conn,"SELECT * FROM siswa where idSiswa='$nis' ");
$tampil = mysqli_fetch_array($qtampil);
?>

<head>
	<script src="js/jquery-1.10.2.min.js"></script>
	<script src="js/jquery.lock.js"></script>
	<script src="js/jquery.lock.min.js"></script>
	<script>
		$(document).ready(function() {
			$(".wibo").lock();
		});
	</script>
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;

			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}


		body {
			background: #ddd;
		}

		.page {
			position: relative;
			width: 21cm;
			min-height: 29.7cm;
			page-break-after: always;
			margin: 0.5cm auto;
			background: #FFF;
			padding: 1.5cm;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
			-webkit-box-sizing: none;
			-moz-box-sizing: none;
			box-sizing: none;

			page-break-after: always;
		}

		.page-landscape {
			position: relative;
			width: 29.7cm;
			min-height: 19cm;
			page-break-after: always;
			margin: 1.5cm;
			background: #FFF;
			padding: 1.5cm;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
			-webkit-box-sizing: none;
			-moz-box-sizing: none;
			box-sizing: none;

			page-break-after: always;
		}

		.footer {
			position: absolute;
			bottom: 1.5cm;
			left: 1.5cm;
			right: 1.5cm;
			width: auto;
			height: 30px;
		}

		.kanan {
			float: right;
		}

		.page *,
		.page-landscape * {
			font-family: arial;
			font-size: 11px;
		}

		.it-grid {
			background: #FFF;
			border-collapse: collapse;
			border: 1px solid #000;
		}

		.seri {
			font-family: 'Lucida Handwriting';
		}

		.it-grid th {
			color: #000;
			border: 1px solid #000;
			border-top: 1px solid #000;
			background: #C4BC96;
		}

		.it-grid tr:nth-child(even) {
			background: #f8f8f8;
		}

		.it-grid td,
		.it-grid th {
			padding: 3px;
			border: 1px solid #000;
		}

		.it-cetak td {
			padding: 5px 5px;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-weight: normal;
		}

		table {
			border-collapse: collapse;
		}

		td {
			padding: 1px;
		}

		.f14 {
			font-size: 14pt;
		}

		.f12 {
			font-size: 12pt;
		}

		.line-bottom {
			border-bottom: 1px solid black;
		}

		.detail {
			margin-top: 10px;
			margin-bottom: 10px;
		}

		.detail td {
			padding: 5px;
			font-size: 12px;
		}

		.detail span {
			border-bottom: 1px solid black;
			display: inline-block;
			font-size: 12px;
		}

		.cetakan {
			font-size: 14px;
			line-height: 1.5em;
		}

		.cetakan * {
			font-size: 14px;
			line-height: 1.5em;
		}

		.cetakan span {
			border-bottom: 1px solid black;
			display: inline-block;
		}

		.full {
			width: 100%;
		}

		nip {
			display: inline-block;
			width: 130px;
		}

		a {
			text-decoration: none;
			color: #006600;
		}

		ol {
			margin-left: 30px;
		}

		ol>li {
			padding: 10px;
		}

		table {
			page-break-inside: auto
		}

		tr {
			page-break-inside: avoid;
			page-break-after: auto
		}

		thead {
			display: table-header-group
		}

		tfoot {
			display: table-footer-group
		}


		@media print {
			body {
				background: #ddd;
			}

			.page {
				height: 10cm;
				padding: 0.7cm;
				box-shadow: none;
				margin: 0;
			}

			@page {
				size: A4;
				margin: 0;
				-webkit-print-color-adjust: exact;
			}

			.page-landscape {
				height: 5cm;
				padding: 0.5cm;
				box-shadow: none;
				margin: 0;
			}

			.footer {
				bottom: 0.7cm;
				left: 0.7cm;
				right: 0.7cm;
			}

			thead {
				display: table-header-group;
			}
		}
	</style>
</head>

<body>
	<div class="page">
		<center>
			<table align="left">
				<tbody>
					<tr>
						<td style="padding:8px;">
							<table style="width:8.5cm;border:1px solid black;" class="kartu">
								<tbody>
									<tr>
										<td colspan="3" style="border-bottom:1px solid black">
											<table width="100%" class="kartu">
												<tbody>
													<tr>
														<td><img src="./images/logo.png" height="40"></td>
														<td align="center" style="font-weight:bold">
															KARTU PESERTA UASBK<br> SMKN 5 BANJARMASIN 2015/2016
														</td>
													</tr>
												</tbody>
											</table>
										</td>
									</tr>

									<tr>
										<td width="100">Nama Peserta</td>
										<td width="1">:</td>
										<td class="wibo"><?php echo $tampil['nmSiswa']; ?></td>
									</tr>
									<tr>
										<td>Kelas</td>
										<td>:</td>
										<td class="wibo"><?php echo $tampil['kelas']; ?></td>
									</tr>
									<tr>
										<td>Username</td>
										<td>:</td>
										<td class="wibo" style="font-size:12px;font-weight:bold;"><?php echo $tampil['username']; ?></td>
									</tr>
									<tr>
										<td>Password</td>
										<td>:</td>
										<td class="wibo" style="font-size:12px;font-weight:bold;"><?php echo $tampil['password']; ?></td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>
											<font size="1">&nbsp <img src="./images/lengkap.jpg" sizes="80%" align="right"></font>
										</td>
									</tr>



								</tbody>
							</table>
							<br>
							<p><b>*Keterangan</b></p>
							<p>1. Potong kartu sesuai ukuran di atas</p>
							<p>2. Kartu harus di bawa saat ujian berlangsung</p>
							<p>3. Simpan dengan baik jangan sampai hilang</p>
							<p>4. Rahasiakan, karena pada kartu terdapat username dan password untuk mengikuti ujian</p>
						</td>

				</tbody>
			</table>

			</td>
			</tr>
			</tbody>
			</table>
			</td>
			</tr>
			<tr>
				<td></td>
			</tr>
			</tbody>
			</table>
		</center>

	</div>


	<script language="javascript">
		function printWindow() {

			bV = parseInt(navigator.appVersion);

			if (bV >= 4) window.print();
		}

		printWindow();
	</script>


</body>