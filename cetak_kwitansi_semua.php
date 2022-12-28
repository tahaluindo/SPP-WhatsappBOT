<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_seo.php";
if (isset($_SESSION[id])) {
	if ($_SESSION['level'] == 'admin') {
		$iden = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users where username='$_SESSION[id]'"));
		$nama =  $iden['nama_lengkap'];
		$level = 'Administrator';
		$foto = 'dist/img/user.png';
	}
	$id = $_GET['id'];

	$lokasi_ttd_ketua = '<img src="img/ttd_rivani.png" width="85px"/>';
	$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas where npsn='10700295'"));
	$project = mysqli_fetch_array(mysqli_query($conn, "SELECT project.*, nmMitra,idProject,alamat FROM project
	 INNER JOIN mitra ON project.idClient=mitra.id
	 
	WHERE project.idProject='$_GET[id]'"));

	$tampil = mysqli_fetch_array(mysqli_query($conn, "SELECT
												jurnal_umums.*,
												project.nmProject,
                                                sum(jurnal_umums.penerimaan) as Jumlah
											FROM
												jurnal_umums
											INNER JOIN project ON jurnal_umums.idProject = project.idProject
                      where project.idProject='$_GET[id]'  ORDER BY jurnal_umums.tgl DESC "));


?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Kwitansi 00<?php echo $tampil['id']; ?></title>
		<link rel="stylesheet" href="bootstrap/css/printer.css">
		<link rel="shortcut icon" href="img/loh.png" />
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<style type="text/css">
			body {

				background-image: url('./gambar/Kosons.jpg');
				background-repeat: no-repeat;
				background-size: 100%;
				background-position: fixed;
				font-family: 'Poppins';
              	width: 100%;
                height: 100%;
              	
             margin: 1% 1%;
			}

			.title {
				text-align: center;
				font-size: 2.5em;
				color: #000;
			}

			img {
				border: 0px dotted aqua;
			}

			#detail {
				 margin: 1% 1%;
			}

			.font-elephan {
				font-family: elephant;
			}

			.font-Copperplate {
				font-family: Copperplate Gothic Bold;
			}

			.font-times {
				font-family: times new roman;
			}

			.font-old {
				font-family: Old English Text MT;
			}

			.font-31 {
				font-size: 25pt;
			}

			.font-14 {
				font-size: 14pt;
			}
			.font-13 {
				font-size: 10pt;
			}

			.font-12 {
				font-size: 12pt;
			}

			.font-10 {
				font-size: 10pt;
			}

			.font-9 {
				font-size: 9pt;
				font-style: italic;
			}

			.font-91 {
				font-size: 9pt;

			}

			.bold {
				font-weight: bold;
			}

			.undeline {
				text-decoration: underline;
			}

			.tulisan_dua {
				font-color: green;
			}

          h3 {
				color: #fff;
				
			}
			h2 {
				color: #fff;
				background-color: #01193E;
			}

			h1 {
				color: #fff;
				background-color: #6495ED;
			}

			p {
				color: #000;
			}
		</style>

	</head>

	<body>
		<div id="detail">
			<br>
			<table width="45%" align="right">
				<tr>
					<td width="" align="center">
						
						<b>
                         <?php
                          function rubah_tanggal($tgl)
                         {
                         $exp = explode('-',$tgl);
                         if(count($exp) == 3)
                         {
                         $tgl = $exp[2].'-'.$exp[1].'-'.$exp[0];
                         }
                         return $tgl;
                         }
  							$tg = rubah_tanggal(date('Y-m-d'));
 						 $result = preg_replace("/[^0-9]/", "", $tg );
							?>
							<h3>NO : 00<?php echo $tampil['id']; ?>.KWT.<?php echo  $result; ?></h3>
						</b>
					</td>
				</tr>
			</table>
			<br><br><br><br><br><br><br>
			<table width="100%" cellpadding="2">
			
				<tr>
					<td width="5%"></td>
					<td class="font-13" width="30%">Sudah di terima dari<br>
						<div class="font-9">Already received from</div>
					</td>
					<td>:<br>
						<div class="font-13">&nbsp;</div>
					</td>
					<td class="font-13"><b><b> <?php echo $project['nmMitra']; ?></b></b><br>
						<div class="font-9">&nbsp;</div>
					</td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td class="font-13">Jumlah<br>
						<div class="font-9">Total</div>
					</td>
					<td>:<br>
						<div class="font-10">&nbsp;</div>
					</td><br>
					<td class="font-13"><b><?php echo buatRp($tampil['Jumlah']); ?> </b><br>
						<div class="font-10">&nbsp;</div>

					</td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td class="font-13">Untuk pembayaran<br>
						<div class="font-9">For payment</div>
					</td>
					<td>:<br>
						<div class="font-13">&nbsp;&nbsp;</div>
					</td><br>
					<td class="font-13"><b><?php echo $project['nmProject']; ?></b><br>
						<div class="font-9">&nbsp;</div>

					</td>
				</tr>
				<tr>
					<td width="5%"></td>
					<td class="font-13">Terbilang<br>
						<div class="font-9">Counted</div>
					</td>
					<td>:<br>
						<div class="font-13">&nbsp;</div>
					</td><br>
					<td class="font-13"><b><?php echo terbilang($tampil['Jumlah']); ?> rupiah</b><br>
						<div class="font-9">&nbsp;</div>

					</td>
				</tr>
				
			</table>
			<br>
			<table width="100%" cellspacing="2" class="font-12" border="0">
				<tr>
					<td></td>
					<td class="font-13" align="right" width="40%">
						<center><?php echo $idt['kabupaten']; ?>, <?php echo tgl_raport($tampil['tgl']); ?>
							<br />Finance,<br />
							<?= $lokasi_ttd_ketua ?>
						<br>
							<b><u>Angga Juliyanto</u></b>
						</center>
						<br>
						<?= $npm_ketua ?>
					</td>
				</tr>
			</table>
	</body>
	<script>
		window.print()
	</script>

	</html>
<?php
} else {
	include "login.php";
}
?>