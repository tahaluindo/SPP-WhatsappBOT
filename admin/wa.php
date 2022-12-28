<?php
include "../config/rupiah.php";
include 'config/rupiah.php';
include "../config/koneksi.php";
date_default_timezone_set('Asia/Jakarta');

$now = date('m');
$b = mysqli_query($conn,"SELECT nmBulan as bulan, urutan as urt, idBulan as id_bln FROM bulan WHERE idBulan = $now");
$bl = mysqli_fetch_array($b);
$id_bln = $bl['id_bln'];
$bulan = $bl['bulan'];
$urut_bln = $bl['urt'];

//tahun ajaran
$t = mysqli_query($conn,"SELECT idTahunAjaran as ta FROM tahun_ajaran WHERE aktif = 'Y'");
$ta = mysqli_fetch_array($t);
$thn_ajar = $ta['ta'];
//url tagihan
$page_URL = (@$_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('');

$idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas"));
$link = $idt['link_one_sender'];
$links = $idt['token'];
$wa = $idt['wa'];

$headers = array();
$headers[] = $idt[token];
$headers[] = 'Content-Type: application/x-www-form-urlencoded';

if (isset($_POST['send'])) {

    $lst_siswa = mysqli_query($conn,"SELECT * FROM siswa WHERE statusSiswa='Aktif'");
    while ($sws = mysqli_fetch_array($lst_siswa)) {

        $link_url_tagihan = "$page_URL$_SERVER[HTTP_HOST]/" . $uri_segments[1] . '/laporan_tagihan_siswa.php?tahun=' . $thn_ajar . '%26siswa=' . $sws['idSiswa'];
        $rincian_tagihan = '';
        $total_tagihan = 0;
        $no = 1;
        // tagihan bulan 
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
                          WHERE tagihan_bulanan.idSiswa='$sws[idSiswa]' AND jenis_bayar.idTahunAjaran<='$thn_ajar' AND tagihan_bulanan.statusBayar='0' AND bulan.urutan<='$urut_bln'
                          order by bulan.urutan asc ");
        while ($tBln = mysqli_fetch_array($tag_bln)) {
            if ($tBln['jumlahBayar'] <> 0) {
                $pisah_TA = explode('/', $tBln['nmTahunAjaran']);
                if ($tBln['urutan'] <= 6) {
                    $nmBulan = $tBln['nmBulan'] . ' ' . $pisah_TA[0];
                } else {
                    $nmBulan = $tBln['nmBulan'] . ' ' . $pisah_TA[1];
                }
                $rincian_tagihan = $rincian_tagihan . $no++ . ". " . $tBln['nmJenisBayar'] . " - T.A" . $tBln['nmTahunAjaran'] . " - (" . $nmBulan . ") => *" . str_replace('.', ',', buatRp($tBln['jumlahBayar'])) . "* %0A";
                $total_tagihan += $tBln['jumlahBayar'];
            }
        }

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

        while ($tBbs = mysqli_fetch_array($tag_bebas)) {
            if ($tBbs['totalTagihanBebas'] <> 0) {
                $pisah_TA = explode('/', $tBbs['nmTahunAjaran']);
                if ($tBbs['urutan'] <= 6) {
                    $nmBulan = $tBbs['nmBulan'] . ' ' . $pisah_TA[0];
                } else {
                    $nmBulan = $tBbs['nmBulan'] . ' ' . $pisah_TA[1];
                }
                $bayar_bebas = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) as totalBayarBebas FROM tagihan_bebas_bayar WHERE idTagihanBebas='$tBbs[idTagihanBebas]'"));
                $sisa_tag_bebas = $tBbs['totalTagihanBebas'] - $bayar_bebas['totalBayarBebas'];
                if ($sisa_tag_bebas <> 0) {
                    $rincian_tagihan = $rincian_tagihan . $no++ . ". " . $tBbs['nmJenisBayar'] . " - T.A" . $tBbs['nmTahunAjaran'] . " - (" . $nmBulan . ") => *" . str_replace('.', ',', buatRp($sisa_tag_bebas)) . "* %0A";
                    $total_tagihan += $sisa_tag_bebas;
                }
            }
        }

        $msg_sws = 'Assalamualaikum, Harap menyelesaikan pembayaran Tagihan sebesar *' . str_replace(".", ",", buatRp($total_tagihan)) . '* untuk Anda yang bernama *' . $sws['nmSiswa'] . '*, dengan rincian di bawah ini:%0A %0A' . $rincian_tagihan . '%0ADownload Tagihan : ' . $link_url_tagihan . ' %0A %0Akapan akan dibayarkan ?. Terima kasih';
        $msg_ortu = 'Assalamualaikum, Harap menyelesaikan pembayaran Tagihan sebesar *' . str_replace(".", ",", buatRp($total_tagihan)) . '* anak Anda yang bernama *' . $sws['nmSiswa'] . '*, dengan rincian di bawah ini:%0A %0A' . $rincian_tagihan . '%0ADownload Tagihan : ' . $link_url_tagihan . ' %0A %0Akapan akan dibayarkan ?. Terima kasih';

        if ($total_tagihan <> 0) {

            // siswa
            $phone = $sws['noHpSis'];

            $data = [
                "api_key" => $links,
                "sender" => $wa,
                "number" => $phone,
                "message" => $msg_sws
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


            echo $msg_sws . '<br>';
            var_dump($response);
            echo '<br>';


            // orang tua
            $phone1 = $sws['noHpOrtu'];
            $data2 = [
                "api_key" => $links,
                "sender" => $wa,
                "number" => $phone1,
                "message" => $msg_ortu
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

            echo $msg_ortu . '<br>';
            var_dump($response2);
            echo '<br>';
        }
    }
}





?>

<section class="content">
    <div class="col-xs-12 ">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title"> </h3>
                <form class="form-horizontal" method="POST">
                    <div class="box-body">

                        <div class="form-group">
                            <div class="col-sm-12 ">
                                <p>Tombol dibawah ini untuk memberikan notif kepada siswa dan orang tua, bagi siswa yang memiliki tanggungan pembayaran hinggan bulan ini</p>
                                <button type="submit" name="send" class="btn btn-danger pull-left">Kirim</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</section>