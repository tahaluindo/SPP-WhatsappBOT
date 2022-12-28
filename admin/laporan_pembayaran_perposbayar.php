<div class="col-xs-12">
	<div class="box box-info box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Filter Data</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="" class="form-horizontal">
				<input type="hidden" name="view" value="lappembayaranperposbayar" />
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Pos Bayar</th>
							<th>Opsi Bayar</th>
							<th>Mulai</th>
							<th>Sampai</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<select id="pos" name="pos" class="form-control" required>
									<option value="Semua Pos Bayar">- Semua Pos Bayar -</option>
									<?php
									$sqlPosBayar = mysqli_query($conn,"SELECT * FROM pos_bayar ORDER BY idPosBayar ASC");
									while ($pb = mysqli_fetch_array($sqlPosBayar)) {

										$selected = ($pb['idPosBayar'] == $_GET['pos']) ? ' selected="selected"' : "";

										echo "<option value=" . $pb['idPosBayar'] . " " . $selected . ">" . $pb['nmPosBayar'] . "</option>";
									}
									?>
								</select>
							</td>
							<td>
								<select id="opsi" name="opsi" class="form-control" required>
									<?php
									if ($_GET[opsi] == 'Semua Opsi Bayar') {
										echo '<option value="Semua Opsi Bayar" selected>- Semua Opsi Bayar -</option>';
									} else {
										echo '<option value="Semua Opsi Bayar">- Semua Opsi Bayar -</option>';
									}
									if ($_GET[opsi] == 'Tunai') {
										echo "<option value='Tunai' selected>Tunai</option>";
									} else {
										echo "<option value='Tunai'>Tunai</option>";
									}
									if ($_GET[opsi] == 'Transfer') {
										echo "<option value='Transfer' selected>Transfer</option>n>";
									} else {
										echo "<option value='Transfer'>Transfer</option>";
									}
									?>
								</select>
							</td>
							<td>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<?php
									if ($_GET['tgl1'] != '') {
										echo '<input type="text" name="tgl1" class="form-control pull-right date-picker" required="" value="' . $_GET[tgl1] . '">';
									} else {
										echo '<input type="text" name="tgl1" class="form-control pull-right date-picker" required="">';
									}
									?>
								</div>
								<!-- /.input group -->
							</td>
							<td>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<?php
									if ($_GET['tgl2'] != '') {
										echo '<input type="text" name="tgl2" class="form-control pull-right date-picker" required="" value="' . $_GET[tgl2] . '">';
									} else {
										echo '<input type="text" name="tgl2" class="form-control pull-right date-picker" required="">';
									}
									?>
								</div>
								<!-- /.input group -->
							</td>
							<td width="100">
								<input type="submit" name="proses" value="Proses" class="btn btn-success pull-right">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div><!-- /.box-body -->

		<?php
		if (isset($_GET['proses'])) {
			$PosBayar = $_GET[pos];
			$OpsiBayar = $_GET[opsi];
			$MulaiTgl = $_GET[tgl1];
			$SampaiTgl = $_GET[tgl2];
		?>
			<div class="table-responsive">
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
			</div>

			<div class="box-footer text-center">
				<a class="btn btn-success" target="_blank" href="./excel_laporan_pembayaran_perposbayar.php?pos=<?php echo $_GET['pos']; ?>&opsi=<?php echo $_GET['opsi']; ?>&tgl1=<?php echo $_GET['tgl1']; ?>&tgl2=<?php echo $_GET['tgl2']; ?>"><span class="fa fa-file-excel-o"></span> Export ke Excel</a>

				<a class="btn btn-danger" target="_blank" href="./cetak_laporan_pembayaran_perposbayar.php?pos=<?php echo $_GET['pos']; ?>&opsi=<?php echo $_GET['opsi']; ?>&tgl1=<?php echo $_GET['tgl1']; ?>&tgl2=<?php echo $_GET['tgl2']; ?>"><span class="glyphicon glyphicon-print"></span> Cetak Laporan </a>
			</div>
		<?php
		}
		?>

	</div><!-- /.box -->

</div>