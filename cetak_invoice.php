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
$inco = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(penerimaan) as bayar FROM jurnal_umums where idProject='$_GET[id]'"));
								$dibayar = $inco['bayar'];
	$lokasi_ttd_ketua = '<img src="img/ttd_rivani.png" width="85px"/>';
	$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas where npsn='10700295'"));
	$project = mysqli_fetch_array(mysqli_query($conn, "SELECT project.*, nmMitra, idProject,alamat FROM project INNER JOIN mitra ON project.idClient=mitra.id
	
	WHERE idProject='$_GET[id]'"));
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Invoice #<?php echo $project['idProject']; ?></title>
		<link rel="stylesheet" href="bootstrap/css/printer.css">
		<link rel="shortcut icon" href="img/loh.png" />
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<style>
			body {

			
				font-family: 'Poppins';
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

		<div class="col-xs-12">
			<table width="100%">
				<tr>
					<td align="left"><img src="./gambar/Invoice.jpg" height="265px" width="980px"></td>


				</tr>

			</table>
			<table width="10%" align="right">


				<tr>
					<td width="10px" align="right">
						<b>
                          <?php if (!empty($dibayar)){
          
          ?>
							<h2>#<?php echo $project['idProject']; ?>(2)</h2>
                         
                          <?php }elseif (empty($dibayar)){ ?>
                          	<h2>#<?php echo $project['idProject']; ?></h2>
                            <?php } ?>
						</b>
					</td>
				</tr>
			</table>
			<table width="100%">



				<tr>
					<td width="50px" align="right">
						<p style="">Tanggal tagihan :<?php echo $project['mulai']; ?></p>
					</td>

				</tr>
				<tr>

					<td width="50px" align="right">
						<p style="">Tanggal jatuh tempo :<?php echo $project['berakhir']; ?></p>
					</td>
				</tr>
			</table>
			<table width="50%">
				<tr>
					<td width="50px" align="left">
						Tagihan Kepada:<b>
							<h3 style=""><?php echo $project['nmMitra']; ?></h3>
						</b>
					</td>

				</tr>
				<tr>
					<td width="20px" align="left">
						<p style=""><?php echo $project['alamat']; ?></p>
					</td>

				</tr>

			</table>

			<br>
			<div class="box box-info box-solid">

				<div class="box-body">
					<table class="table table-bordered table-striped">
						<thead class="thead">
							<tr>
								<th width="40px">No.</th>
								<th width="560px">Item</th>
								<th>Kuantitas</th>
								<th>Harga</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$sqlKelas = mysqli_query($conn, "SELECT invoice.*, nmItem, harga,kuantitas ,rincian,tipe,diskon,pajak FROM invoice 
							INNER JOIN item ON invoice.id=item.id
							INNER JOIN project ON invoice.idProject=project.idProject
							where invoice.idProject='$_GET[id]' ");
							while ($dk = mysqli_fetch_array($sqlKelas)) {
								$harga = $dk['harga'] * $dk['kuantitas'];

								echo "<tr>
								<td align='center'>$no</td>
								<td>$dk[nmItem]<br>  $dk[rincian]</td>
								<td align='center'>$dk[kuantitas] $dk[tipe]</td>
								<td align='center'>" . buatRp($dk['harga']) . "</td>
								<td align='right'>" . buatRp($harga) . "</td>
							</tr>";
								$no++;
								$gTotal += $harga;
								$diskon = $dk['diskon'];
								$pajak = $dk['pajak'];
								
							}
							echo "
							
							<tr>
							<td colspan='4' align='right'> <b>Diskon  </b></td>
							
							<td align='right'><b>" . buatRp($diskon) . "</b></td>
							</tr>
							<tr>
							<td colspan='4' align='right'> <b>Pajak  </b></td>
							
							<td align='right'><b>" . buatRp($pajak) . "</b></td>
							</tr>
							<tr>
							<td colspan='4' align='right'> <b>Dibayar  </b></td>
							
							<td align='right'><b>" . buatRp($dibayar) . "</b></td>
							</tr>
							<tr>
							<td colspan='4' align='right'> <b>Grand Total  </b></td>
							
							<td align='right'><b>" . buatRp($gTotal + $pajak - $diskon - $dibayar) . "</b></td>
							</tr>";
							?>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div>
		<br />
		<?php
		$total = ($gTotal + $pajak - $diskon - $dibayar) * 40 / 100; ?>
		<table width="100%" cellspacing="2" class="font-12" border="0">
			<br>
			<tr>
              <?php if (!empty($dibayar)){
          
          ?>
				<td align="justify" width="40%"><i><?php echo $idt['ket_lunas']; ?> <b><?php echo  buatRp($gTotal + $pajak - $diskon - $dibayar); ?></b> (<?php echo  terbilang($gTotal + $pajak - $diskon - $dibayar); ?> rupiah) .</i></td>
			<?php }elseif (empty($dibayar)){ ?>
              <td align="justify" width="40%"><i><?php echo $idt['ket']; ?> <b><?php echo  buatRp($total); ?></b> (<?php echo  terbilang($total); ?> rupiah) .</i></td>
             <?php } ?>
          </tr>
			<tr>
				<td></td>
				<td align="right" width="40%">
					<center><?php echo $idt['kabupaten']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?>
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
		<br>
		<table width="80%">
			<tr>

				<td align="left">

					<p><?php echo $idt['footer']; ?></p>

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