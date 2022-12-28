<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_seo.php";
if (isset($_SESSION[id])) {
	if ($_SESSION['level'] == 'admin') {
		$iden = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM users where username='$_SESSION[id]'"));
		$nama =  $iden['nama_lengkap'];
		$level = 'Administrator';
		$foto = 'dist/img/user.png';
	}

	//$ta = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
	//$idTahun = $ta['idTahunAjaran'];
	$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas where npsn='10700295'"));
	$pos = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar where idPosBayar='$_GET[pos]'"));
	$PosBayar = $_GET[pos];
	$OpsiBayar = $_GET[opsi];
	$MulaiTgl = $_GET[tgl1];
	$SampaiTgl = $_GET[tgl2];
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=laporan_pembayaran_pos_" . str_replace(" ", "_", $pos['nmPosBayar']) . "_" . date('dmyHis') . ".xls");
?>
	<h3 align="center"><?php echo $idt['nmSekolah']; ?><br />LAPORAN PEMBAYARAN</h3>
	<table border="1" class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No.</th>
				<th>Pos Bayar</th>
				<th>Jenis Pembayaran</th>
				<th>Jumlah Pembayaran</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$totDibayar = 0;
			if (($PosBayar == 'Semua Pos Bayar') and ($OpsiBayar == 'Semua Opsi Bayar')) {
				//bulanan
				$sqlLapBayBul = mysqli_query($conn,"SELECT * FROM view_laporan_bayar_bulanan WHERE(DATE(tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') GROUP BY idJenisBayar");
				while ($djb = mysqli_fetch_array($sqlLapBayBul)) {
					$sqlJenBay = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$djb[idJenisBayar]'"));
					$sqlpOS = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar WHERE idPosBayar='$sqlJenBay[idPosBayar]'"));
					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
										jenis_bayar.idPosBayar,
										pos_bayar.nmPosBayar,
										jenis_bayar.nmJenisBayar,
										Sum(tagihan_bulanan.jumlahBayar) AS TotalPembayaranPerJenis,
										tagihan_bulanan.statusBayar
										FROM
										tagihan_bulanan
										INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
										INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
										WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND jenis_bayar.tipeBayar='bulanan' AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl')
										GROUP BY
										tagihan_bulanan.idJenisBayar"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];

					echo "<tr>
								<td align='center'>$no</td>
								<td>$sqlpOS[nmPosBayar]</td>
								<td>$djb[nmJenisBayar]</td>
								<td align='right'>" . buatRp($jBayar) . "</td>
								</tr>";
					$no++;
					$totDibayar += $jBayar;
				}
				//bebas
				$sqlLapBayBeb = mysqli_query($conn,"SELECT * FROM tagihan_bebas_bayar INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar WHERE (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') GROUP BY tagihan_bebas.idJenisBayar");
				while ($djb = mysqli_fetch_array($sqlLapBayBeb)) {
					$sqlJenBay = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$djb[idJenisBayar]'"));
					$sqlpOS = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar WHERE idPosBayar='$sqlJenBay[idPosBayar]'"));
					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
												tagihan_bebas.idJenisBayar,
												jenis_bayar.nmJenisBayar,
												tagihan_bebas_bayar.idTagihanBebas,
												Sum(tagihan_bebas_bayar.jumlahBayar) AS TotalPembayaranPerJenis,
												tagihan_bebas_bayar.ketBayar
												FROM
												tagihan_bebas_bayar
												INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
												INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
												WHERE tagihan_bebas.idJenisBayar='$djb[idJenisBayar]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') AND jenis_bayar.tipeBayar='bebas'
												GROUP BY jenis_bayar.idJenisBayar"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];

					echo "<tr>
										<td align='center'>$no</td>
										<td>$sqlpOS[nmPosBayar]</td>
										<td>$djb[nmJenisBayar]</td>
										<td align='right'>" . buatRp($jBayar) . "</td>
									</tr>";
					$no++;
					$totDibayar += $jBayar;
				}
			} else if (($PosBayar != 'Semua Pos Bayar') and ($OpsiBayar == 'Semua Opsi Bayar')) {
				//bulanan
				$sqlLapBayBul = mysqli_query($conn,"SELECT * FROM view_laporan_bayar_bulanan INNER JOIN jenis_bayar ON view_laporan_bayar_bulanan.idJenisBayar = jenis_bayar.idJenisBayar WHERE jenis_bayar.idPosBayar='$PosBayar' AND (DATE(view_laporan_bayar_bulanan.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') GROUP BY view_laporan_bayar_bulanan.idJenisBayar");
				while ($djb = mysqli_fetch_array($sqlLapBayBul)) {
					$sqlJenBay = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$djb[idJenisBayar]'"));
					$sqlpOS = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar WHERE idPosBayar='$sqlJenBay[idPosBayar]'"));
					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
										jenis_bayar.idPosBayar,
										pos_bayar.nmPosBayar,
										jenis_bayar.nmJenisBayar,
										Sum(tagihan_bulanan.jumlahBayar) AS TotalPembayaranPerJenis,
										tagihan_bulanan.statusBayar
										FROM
										tagihan_bulanan
										INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
										INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
										WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND jenis_bayar.tipeBayar='bulanan' AND jenis_bayar.idPosBayar='$PosBayar' AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl')
										GROUP BY tagihan_bulanan.idJenisBayar"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];

					echo "<tr>
										<td align='center'>$no</td>
										<td>$sqlpOS[nmPosBayar]</td>
										<td>$djb[nmJenisBayar]</td>
										<td align='right'>" . buatRp($jBayar) . "</td>
									</tr>";
					$no++;
					$totDibayar += $jBayar;
				}
				//bebas
				$sqlLapBayBeb = mysqli_query($conn,"SELECT * FROM tagihan_bebas_bayar INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar WHERE jenis_bayar.idPosBayar='$PosBayar' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') GROUP BY tagihan_bebas.idJenisBayar");
				while ($djb = mysqli_fetch_array($sqlLapBayBeb)) {
					$sqlJenBay = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$djb[idJenisBayar]'"));
					$sqlpOS = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar WHERE idPosBayar='$sqlJenBay[idPosBayar]'"));
					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
												tagihan_bebas.idJenisBayar,
												jenis_bayar.nmJenisBayar,
												tagihan_bebas_bayar.idTagihanBebas,
												Sum(tagihan_bebas_bayar.jumlahBayar) AS TotalPembayaranPerJenis,
												tagihan_bebas_bayar.ketBayar
												FROM
												tagihan_bebas_bayar
												INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
												INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
												WHERE tagihan_bebas.idJenisBayar='$djb[idJenisBayar]'  AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') AND jenis_bayar.tipeBayar='bebas' AND jenis_bayar.idPosBayar='$PosBayar'
												GROUP BY
												tagihan_bebas.idJenisBayar"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];

					echo "<tr>
										<td align='center'>$no</td>
										<td>$sqlpOS[nmPosBayar]</td>
										<td>$djb[nmJenisBayar]</td>
										<td align='right'>" . buatRp($jBayar) . "</td>
									</tr>";
					$no++;
					$totDibayar += $jBayar;
				}
			} else if (($PosBayar == 'Semua Pos Bayar') and ($OpsiBayar != 'Semua Opsi Bayar')) {
				//bulanan
				$sqlLapBayBul = mysqli_query($conn,"SELECT * FROM view_laporan_bayar_bulanan INNER JOIN jenis_bayar ON view_laporan_bayar_bulanan.idJenisBayar = jenis_bayar.idJenisBayar WHERE view_laporan_bayar_bulanan.caraBayar='$OpsiBayar' AND (DATE(view_laporan_bayar_bulanan.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') GROUP BY view_laporan_bayar_bulanan.idJenisBayar");
				while ($djb = mysqli_fetch_array($sqlLapBayBul)) {
					$sqlJenBay = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$djb[idJenisBayar]'"));
					$sqlpOS = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar WHERE idPosBayar='$sqlJenBay[idPosBayar]'"));
					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
										jenis_bayar.idPosBayar,
										pos_bayar.nmPosBayar,
										jenis_bayar.nmJenisBayar,
										Sum(tagihan_bulanan.jumlahBayar) AS TotalPembayaranPerJenis,
										tagihan_bulanan.statusBayar
										FROM
										tagihan_bulanan
										INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
										INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
										WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND jenis_bayar.tipeBayar='bulanan' AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') AND tagihan_bulanan.caraBayar='$OpsiBayar'
										GROUP BY
										tagihan_bulanan.idJenisBayar"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];

					echo "<tr>
										<td align='center'>$no</td>
										<td>$sqlpOS[nmPosBayar]</td>
										<td>$djb[nmJenisBayar]</td>
										<td align='right'>" . buatRp($jBayar) . "</td>
									</tr>";
					$no++;
					$totDibayar += $jBayar;
				}
				//bebas
				$sqlLapBayBeb = mysqli_query($conn,"SELECT * FROM tagihan_bebas_bayar INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar WHERE tagihan_bebas_bayar.caraBayar='$OpsiBayar' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') GROUP BY tagihan_bebas.idJenisBayar");
				while ($djb = mysqli_fetch_array($sqlLapBayBeb)) {
					$sqlJenBay = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$djb[idJenisBayar]'"));
					$sqlpOS = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar WHERE idPosBayar='$sqlJenBay[idPosBayar]'"));
					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
												tagihan_bebas.idJenisBayar,
												jenis_bayar.nmJenisBayar,
												tagihan_bebas_bayar.idTagihanBebas,
												Sum(tagihan_bebas_bayar.jumlahBayar) AS TotalPembayaranPerJenis,
												tagihan_bebas_bayar.ketBayar
												FROM
												tagihan_bebas_bayar
												INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
												INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
												WHERE tagihan_bebas.idJenisBayar='$djb[idJenisBayar]'  AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') AND jenis_bayar.tipeBayar='bebas' AND tagihan_bebas_bayar.caraBayar='$OpsiBayar'
												GROUP BY
												tagihan_bebas.idJenisBayar"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];

					echo "<tr>
										<td align='center'>$no</td>
										<td>$sqlpOS[nmPosBayar]</td>
										<td>$djb[nmJenisBayar]</td>
										<td align='right'>" . buatRp($jBayar) . "</td>
									</tr>";
					$no++;
					$totDibayar += $jBayar;
				}
			} else {
				//bulanan
				$sqlLapBayBul = mysqli_query($conn,"SELECT * FROM view_laporan_bayar_bulanan INNER JOIN jenis_bayar ON view_laporan_bayar_bulanan.idJenisBayar = jenis_bayar.idJenisBayar WHERE jenis_bayar.idPosBayar='$PosBayar' AND view_laporan_bayar_bulanan.caraBayar='$OpsiBayar' AND (DATE(view_laporan_bayar_bulanan.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') GROUP BY view_laporan_bayar_bulanan.idJenisBayar");
				while ($djb = mysqli_fetch_array($sqlLapBayBul)) {
					$sqlJenBay = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$djb[idJenisBayar]'"));
					$sqlpOS = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar WHERE idPosBayar='$sqlJenBay[idPosBayar]'"));
					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
										jenis_bayar.idPosBayar,
										pos_bayar.nmPosBayar,
										jenis_bayar.nmJenisBayar,
										Sum(tagihan_bulanan.jumlahBayar) AS TotalPembayaranPerJenis,
										tagihan_bulanan.statusBayar
										FROM
										tagihan_bulanan
										INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
										INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
										WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND jenis_bayar.tipeBayar='bulanan' AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') AND tagihan_bulanan.caraBayar='$OpsiBayar'
										GROUP BY
										tagihan_bulanan.idJenisBayar"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];

					echo "<tr>
										<td align='center'>$no</td>
										<td>$sqlpOS[nmPosBayar]</td>
										<td>$djb[nmJenisBayar]</td>
										<td align='right'>" . buatRp($jBayar) . "</td>
									</tr>";
					$no++;
					$totDibayar += $jBayar;
				}

				//bebas
				$sqlLapBayBeb = mysqli_query($conn,"SELECT * FROM tagihan_bebas_bayar INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar WHERE jenis_bayar.idPosBayar='$PosBayar' AND tagihan_bebas_bayar.caraBayar='$OpsiBayar' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') GROUP BY tagihan_bebas.idJenisBayar");
				while ($djb = mysqli_fetch_array($sqlLapBayBeb)) {
					$sqlJenBay = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$djb[idJenisBayar]'"));
					$sqlpOS = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM pos_bayar WHERE idPosBayar='$sqlJenBay[idPosBayar]'"));
					$dbayar = mysqli_fetch_array(mysqli_query($conn,"SELECT
												tagihan_bebas.idJenisBayar,
												jenis_bayar.nmJenisBayar,
												tagihan_bebas_bayar.idTagihanBebas,
												Sum(tagihan_bebas_bayar.jumlahBayar) AS TotalPembayaranPerJenis,
												tagihan_bebas_bayar.ketBayar
												FROM
												tagihan_bebas_bayar
												INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
												INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
												WHERE tagihan_bebas.idJenisBayar='$djb[idJenisBayar]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$MulaiTgl' AND '$SampaiTgl') AND jenis_bayar.tipeBayar='bebas' AND tagihan_bebas_bayar.caraBayar='$OpsiBayar' AND jenis_bayar.idPosBayar='$PosBayar'
												GROUP BY
												tagihan_bebas.idJenisBayar"));
					$jBayar 	= $dbayar['TotalPembayaranPerJenis'];

					echo "<tr>
										<td align='center'>$no</td>
										<td>$sqlpOS[nmPosBayar]</td>
										<td>$djb[nmJenisBayar]</td>
										<td align='right'>" . buatRp($jBayar) . "</td>
									</tr>";
					$no++;
					$totDibayar += $jBayar;
				}
			}
			?>
			<tr>
				<td colspan="3">Jumlah Pembayaran</td>
				<td align="right"><b><?php echo buatRp($totDibayar); ?></b></td>
			</tr>
		</tbody>
	</table>
	<br />
	<table width="100%">
		<tr>
			<td align="center"></td>
			<td align="center" width="400px">
				<?php echo $idt['kabupaten']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?>
				<br />Kepala Tata Usaha,<br /><br /><br /><br />
				<b><u><?php echo $idt['nmKaTU']; ?></u><br /><?php echo $idt['nipKaTU']; ?></b>
			</td>
		</tr>
	</table>
<?php
} else {
	include "login.php";
}
?>