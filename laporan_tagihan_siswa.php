<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";

	$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas where npsn='10700295'"));
	//$ta = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
	//$kls = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM kelas_siswa where idKelas='$_GET[kelas]'"));
	
	$dsw = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM view_detil_siswa WHERE idSiswa='$_GET[siswa]'"));
	$taa = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tahun_ajaran where aktif='Y'"));
    
    $now = date('m');

    //bulan
    $b = mysqli_query($conn,"SELECT nmBulan as bulan, urutan as urt, idBulan as id_bln FROM bulan WHERE idBulan = $now");
    $bl = mysqli_fetch_array($b);
    $id_bln = $bl['id_bln'];
    $bulan = $bl['bulan'];
    $urut_bln = $bl['urt'];
    $t = mysqli_query($conn,"SELECT idTahunAjaran as ta FROM tahun_ajaran WHERE aktif = 'Y'");
$ta = mysqli_fetch_array($t);
$thn_ajar = $ta['ta'];
    $pisah_thn = explode('/', $taa['nmTahunAjaran']);
    if ($urut_bln <= 6){
        $bulan_thn = $bulan.' '.$pisah_thn[0];
    }else{
        $bulan_thn = $bulan.' '.$pisah_thn[1];
    }

    $sws = $_GET['siswa'];
    $tahun = $_GET['tahun'];
    $tag_bln = mysqli_query($conn,"SELECT tagihan_bulanan.idSiswa, tagihan_bulanan.jumlahBayar,
                            jenis_bayar.idPosBayar, 
                            jenis_bayar.nmJenisBayar, 
                            tahun_ajaran.nmTahunAjaran,
                            pos_bayar.nmPosBayar,
                            bulan.nmBulan,
                            bulan.urutan
                    FROM tagihan_bulanan 
                    LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                    LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                    WHERE tagihan_bulanan.idSiswa='$dsw[idSiswa]' AND jenis_bayar.idTahunAjaran<='$tahun' AND tagihan_bulanan.statusBayar='0' AND bulan.urutan<='$urut_bln'
                          order by bulan.urutan asc
                ");
   $tag_bebas = mysqli_query($conn,"SELECT tagihan_bebas.*, 
                                  SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, 
                                  jenis_bayar.idPosBayar, 
                                  jenis_bayar.nmJenisBayar, 
                                  tahun_ajaran.nmTahunAjaran,
                                  pos_bayar.nmPosBayar,
                                  bulan.nmBulan,
                                  bulan.urutan
                          FROM tagihan_bebas 
                          LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                          LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                          LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                          LEFT JOIN bulan ON tagihan_bebas.idBulan = bulan.idBulan
                          WHERE tagihan_bebas.idSiswa='$sws[idSiswa]' AND jenis_bayar.idTahunAjaran<='$thn_ajar' AND tagihan_bebas.statusBayar!='1' AND bulan.urutan<='$urut_bln'
                          GROUP BY tagihan_bebas.idJenisBayar order by bulan.urutan asc");

	
	$tgl_jam = date("d-m-Y h:i:s a");
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Cetak - Tagihan Pembayaran Siswa</title>
		<link rel="stylesheet" href="bootstrap/css/printer.css">
		<style type="text/css">
			@media print {
				footer {
					page-break-after: always;
				}
			}
		</style>
	</head>

	<body style="font-size:80%;">

		<div class="col-xs-12">
			<table width="100%">
				<tr>
					<td width="100px" align="left"><img src="./gambar/logo/<?php echo $idt['logo_kiri']; ?>" height="40px"></td>
					<td valign="top">
						<h3 align="center" style="margin-bottom:8px ">
							<?php echo $idt['nmSekolah']; ?>
						</h3>
						<center><?php echo $idt['alamat']; ?></center>
					</td>
					<td width="100px" align="right"><img src="./gambar/logo/<?php echo $idt['logo_kanan']; ?>" height="40px"></td>
				</tr>
			</table>

			<hr style="margin:4px" />
			<div class="box box-info box-solid">
				<div class="box-header with-border">


					<table width="100%" style="margin-top:10px;margin-bottom:10px;">
						<tr>
							<td width="80px">Nama Siswa</td>
							<td width="8"> : </td>
							<td> <?php echo $dsw['nmSiswa']; ?></td>
							<td></td>
                            <td></td>
						</tr>
						<tr>
							<td>NIS/NISN</td>
							<td>: </td>
							<td> <?php echo $dsw['nisSiswa']; ?>/<?php echo $dsw['nisnSiswa']; ?></td>
							<td></td>
							<td style="float:right">Sampai Bulan : <?= $bulan_thn ?></td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>: </td>
							<td> <?php echo $dsw['nmKelas']; ?></td>
							<td></td>
							<td></td>
						</tr>
					</table>
				</div><!-- /.box-header -->

				<hr style="margin:4px" />
				<center><b>Tagihan Pembayaran </b></center>
				<hr style="margin:4px" /><br>

				<table class="table table-bordered table-striped">
					<thead>
						<tr>
                            <th>No</th>
                            <th>Jenis Pembayaran</th>
							<th>Tagihan/Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
                            $tot = 0;
                            $no = 1;
                            while ($tBln = mysqli_fetch_array($tag_bln)) {
                                if ($tBln['jumlahBayar'] <> 0){
                                    $pisah_TA = explode('/', $tBln['nmTahunAjaran']);
                                    if ($tBln['urutan'] <= 6){
                                        $nmBulan = $tBln['nmBulan'].' '.$pisah_TA[0];
                                    }else{
                                        $nmBulan = $tBln['nmBulan'].' '.$pisah_TA[1];
                                    }
                                    echo '<tr>
                                            <td>'.$no++.'</td>
                                            <td>'.$tBln['nmJenisBayar'].' - T.A '.$tBln['nmTahunAjaran'].' - ('.$nmBulan.')'.'</td>
                                            <td align="right">'.buatRp($tBln['jumlahBayar']).' / Belum Lunas</td>';

                                    $tot += $tBln['jumlahBayar'];
                                }
                            }

                            while ($tBbs = mysqli_fetch_array($tag_bebas)) {
                                if ($tBbs['totalTagihanBebas'] <> 0){
                                  $pisah_TA = explode('/', $tBbs['nmTahunAjaran']);
                                  if ($tBbs['urutan'] <= 6){
                                      $nmBulan = $tBbs['nmBulan'].' '.$pisah_TA[0];
                                  }else{
                                      $nmBulan = $tBbs['nmBulan'].' '.$pisah_TA[1];
                                  }
                                $bayar_bebas = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) as totalBayarBebas FROM tagihan_bebas_bayar WHERE idTagihanBebas='$tBbs[idTagihanBebas]'"));
                                $sisa_tag_bebas = $tBbs['totalTagihanBebas'] - $bayar_bebas['totalBayarBebas'];
                                if ($sisa_tag_bebas <> 0){
                                    echo '<tr>
                                            <td>'.$no++.'</td>
                                            <td>'.$tBbs['nmJenisBayar'].' - T.A '.$tBbs['nmTahunAjaran'].'</td>
                                            <td align="right">'.buatRp($sisa_tag_bebas).' / Belum Lunas</td>';

                                    $tot += $sisa_tag_bebas;
                                }
                                }
                            }
						?>
						<tr>
							<td colspan="2">Jumlah Tagihan</td>
							<td align="right"><b><?php echo buatRp($tot); ?></b></td>
						</tr>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
		<br />
		<table width="100%">
			<td valign="top">
				<b>Terbilang :</b><br>
				<i><?php echo ucfirst(strtolower(terbilang($tot))); ?> Rupiah</i>
			</td>
			<tr>
				<td align="center"></td>
				<td align="center" width="200px">
					<?php echo $idt['kabupaten']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?>
					<br />Bendahara,<br /><br /><br /><br />
					<b><u><?php echo $idt['nmBendahara']; ?></u><br>
                    <b><u><?php echo $idt['nipBendahara']; ?></u>
				</td>
			</tr>
		</table>
		<!--<footer></footer>-->
		<hr style="margin:20px 0px; border-style: dashed;">

	</body>
	<script>
		window.print()
	</script>

	</html>
