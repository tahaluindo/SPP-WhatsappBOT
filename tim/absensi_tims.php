<?php
if ($_GET[act] == '') {
  if (isset($_GET[gettanggal])) {
    $filtertgl = $_GET[gettanggal];
  } else {
    if (isset($_POST[tgl])) {
      $tgl = $_POST[tgl];
    } else {
      $tgl = date("d");
    }
    if (isset($_POST[bln])) {
      $bln = $_POST[bln];
    } else {
      $bln = date("m");
    }
    if (isset($_POST[thn])) {
      $thn = $_POST[thn];
    } else {
      $thn = date("Y");
    }
    $lebartgl = strlen($tgl);
    $lebarbln = strlen($bln);

    switch ($lebartgl) {
      case 1: {
          $tglc = "0" . $tgl;
          break;
        }
      case 2: {
          $tglc = $tgl;
          break;
        }
    }

    switch ($lebarbln) {
      case 1: {
          $blnc = "0" . $bln;
          break;
        }
      case 2: {
          $blnc = $bln;
          break;
        }
    }
    $filtertgl = $thn . "-" . $blnc . "-" . $tglc;
  }
  $ex = explode('-', $filtertgl);
  $tahun = $ex[0];
  $bulane = $ex[1];
  $tanggal = $ex[2];
  if (substr($tanggal, 0, 1) == '0') {
    $tgle = substr($tanggal, 1, 1);
  } else {
    $tgle = substr($tanggal, 0, 2);
  }
  if (substr($bulane, 0, 1) == '0') {
    $blnee = substr($bulane, 1, 1);
  } else {
    $blnee = substr($bulane, 0, 2);
  }

  $waktus = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM rb_setting_absen  "));
  $waktu_masuks = $waktus['waktu_masuk'];
  $waktu_pulangs = $waktus['waktu_pulang'];
  $waktu_absen = $waktus['waktu_absen'];
  $waktu_vatas = $waktus['waktu_batas_pulang'];
  if ($jam_sekarang < $waktu_masuks && $jam_sekarang > $waktu_absen && $jam_sekarang < $waktu_pulangs) {
    $statuss = 'Masuk';
  } elseif ($jam_sekarang > $waktu_pulangs && $jam_sekarang < $waktu_vatas) {
    $statuss = 'Pulang';
  } elseif ($jam_sekarang > $waktu_masuks && $jam_sekarang < $waktu_pulangs && $jam_sekarang < $waktu_vatas) {
    $statuss = 'Terlambat';
  } else {
    $statuss = 'Bukan Jam Absen';
  }
?>
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">

        <center>
          <h3 class="box-title">Data Absensi TIM Pada : <b style='color:red'><?php echo tgl_indo("$filtertgl") . "</b>"; ?> </h3>
          <br>

          <h3 class="box-title"> Absensi : <b style='color:red'><?php echo ("$statuss") . "</b>"; ?> </h3>
          <br>
          <h4>
            <script type="text/javascript">
              //fungsi displayTime yang dipanggil di bodyOnLoad dieksekusi tiap 1000ms = 1detik
              function tampilkanwaktu() {
                //buat object date berdasarkan waktu saat ini
                var waktu = new Date();
                //ambil nilai jam, 
                //tambahan script + "" supaya variable sh bertipe string sehingga bisa dihitung panjangnya : sh.length
                var sh = waktu.getHours() + "";
                //ambil nilai menit
                var sm = waktu.getMinutes() + "";
                //ambil nilai detik
                var ss = waktu.getSeconds() + "";
                //tampilkan jam:menit:detik dengan menambahkan angka 0 jika angkanya cuma satu digit (0-9)
                document.getElementById("clock").innerHTML = (sh.length == 1 ? "0" + sh : sh) + ":" + (sm.length == 1 ? "0" + sm : sm) + ":" + (ss.length == 1 ? "0" + ss : ss);
              }
            </script>

            <body onload="tampilkanwaktu();setInterval('tampilkanwaktu()', 1000);">
              <b> <span id="clock"></span></b>
          </h4>
        </center>
        <div style="clear:both"></div>

        <?php
        echo "<div class='col-md-7 pull-right' style='margin:5px -14px 5px 0px'>
                 </div>";
        ?>
      </div><!-- /.box-header -->
      <form action='' method='POST' enctype="multipart/form-data">

        <div class="box-body">
          <?php
          if (isset($_GET['sukses'])) {
            echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Anda sudah absen masuk hari ini,..
					</div>";
          } elseif (isset($_GET['gagal'])) {
            echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
					<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Anda sudah absen Masuk dan Pulang hari ini..
					</div>";
          } elseif (isset($_GET['gagals'])) {
            echo "<div class='alert alert-warning alert-dismissible fade in' role='alert'> 
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>×</span></button> <strong>Perhatian!</strong> - Sekarang bukan jam absen..
        </div>";
          } elseif (isset($_GET['suksess'])) {
            echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Anda sudah absen pulang hari ini,..
            </div>";
          }
          ?>
          <table id="example" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style='width:20px'>No</th>
                <th>TIM</th>
                <th>Hari</th>

              </tr>
            </thead>
            <tbody>
              <?php
              if (isset($_GET[tahun])) {
                $tampil = mysqli_query($conn, "SELECT * FROM view_detil_siswa  
                                                 where username='$_SESSION[id]'
                                                       ORDER BY username DESC");
              }
              $no = 1;
              while ($r = mysqli_fetch_array($tampil)) {

                $waktus = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM rb_setting_absen  "));
                $waktu_masuks = $waktus['waktu_masuk'];
                $waktu_pulangs = $waktus['waktu_pulang'];
                $waktu_absen = $waktus['waktu_absen'];
                $waktu_vatas = $waktus['waktu_batas_pulang'];
                if ($jam_sekarang > $waktu_masuks && $jam_sekarang > $waktu_absen && $jam_sekarang < $waktu_pulangs) {
                  $statuss = 'T';
                } elseif ($jam_sekarang < $waktu_masuks && $jam_sekarang > $waktu_absen && $jam_sekarang < $waktu_pulangs) {
                  $statuss = 'H';
                } elseif ($jam_sekarang > $waktu_pulangs && $jam_sekarang < $waktu_vatas) {
                  $statuss = 'P';
                } else {
                  echo "<script>document.location='?view=absentim&gagals';</script>";
                }

                $a = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM rb_absensi_guru where nip='$_SESSION[id]' AND tanggal='$sekarangabsen' "));
                echo "<tr><td>$no</td>
                              
                              <td>$r[nama_lengkap]</td>
                              <td>" . hari_ini($sekarangabsen) . "</td>
                              <input type='hidden' value='$_SESSION[id]' name='nip[$no]'>
                              <input type='hidden' value='$statuss' name='a[$no]'>
                             
                                    
                              </tr>";
                $no++;
              }
              ?>
            </tbody>
          </table>

          <div class='col-md-12 row'>
            <div class='col-12 col-md-3' style='display: flex; flex-direction: column; justify-content: center; align-items: center;'>
              <div id='vid-cam'></div>
              <div style='display: flex;'>
                <button type='button' class='btn btn-info' style='margin: 1rem;' id='take'>Ambil Gambar</button>
                <button type='button' class='btn btn-info' style='margin: 1rem; display: none;' id='reCam'>Ambil Gambar Ulang</button>
              </div>
            </div>
            <div class='col-12 col-md-3'>
              <div style='margin: 2rem;'>
                <div class='form-group'>
                  <input type='file' name='gambar' id='file-cam' style="display:none;">
                  <label>Latitude, Longitude</label>
                  <input type='text' name='latlng' id='latlng' class='form-control' readonly>
                </div>
               
                <div class='form-group'>
                  <label>Keterangan</label>
                  <textarea type='text' name='keterangan' id='keterangan' class='form-control'></textarea>
                </div>
              </div>
            </div>
            <div class='col-12 col-md-6' style='height: 300px;'>
              <div id='map' style='height: 100%; width: 100%;'></div>
            </div>
          </div>

        </div><!-- /.box-body -->

        <div class='box-footer'>
          <?php
          echo "<input type='hidden' name='filtertgl' value='$filtertgl'>";
          ?>
          <button type='submit' name='simpan' id="toSubmit" class='btn btn-info pull-right'>Simpan Absensi</button>
        </div>

      </form>
    </div><!-- /.box -->
  </div>
<?php
  if (isset($_POST[simpan])) {
    $jml_data = count($_POST[nip]);
    $nip = $_POST[nip];
    $a = $_POST[a];
    $tglabsen = $_POST[filtertgl];
    for ($i = 1; $i <= $jml_data; $i++) {
      $cak = mysqli_query($conn, "SELECT * FROM rb_absensi_guru where nip='" . $nip[$i] . "' AND tanggal='$tglabsen' ");

      $cae = mysqli_num_rows($cak);

      if ($cae == '2') {
        echo "<script>document.location='?view=absentim&gagal';</script>";
      } else {

        $cek = mysqli_query($conn, "SELECT * FROM rb_absensi_guru where nip='" . $nip[$i] . "' AND tanggal='$tglabsen'  ");
        $total = mysqli_num_rows($cek);
        if ($total >= 1) {
          $nama_file = $_FILES['gambar']['name'];
          $ukuran_file = $_FILES['gambar']['size'];
          $tipe_file = $_FILES['gambar']['type'];
          $tmp_file = $_FILES['gambar']['tmp_name'];

          $path = "./images/" . $nama_file;
          move_uploaded_file($tmp_file, $path);

          $waktus = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM rb_setting_absen  "));
          $waktu_masuks = $waktus['waktu_masuk'];
          $waktu_pulangs = $waktus['waktu_pulang'];
          $waktu_absen = $waktus['waktu_absen'];
          $waktu_vatas = $waktus['waktu_batas_pulang'];
          if ($jam_sekarang > $waktu_masuks && $jam_sekarang > $waktu_absen && $jam_sekarang < $waktu_pulangs) {
            $statuss = 'T';
          } elseif ($jam_sekarang < $waktu_masuks && $jam_sekarang > $waktu_absen && $jam_sekarang < $waktu_pulangs) {
            $statuss = 'H';
          } elseif ($jam_sekarang > $waktu_pulangs && $jam_sekarang < $waktu_vatas) {
            $statuss = 'P';
          } else {
            echo "<script>document.location='?view=absentim&gagal';</script>";
          }

          mysqli_query($conn, "INSERT INTO rb_absensi_guru VALUES ('',
                                                             
                '" . $nip[$i] . "',
                'P',
                '$tglabsen',
                '" . date('Y-m-d H:i:s') . "', '" . $nama_file . "','" . $ukuran_file . "','" . $tipe_file . "', '" . $_POST['latlng'] . "',  '" . $_POST['keterangan'] . "')");

          $lst_siswa = mysqli_query($conn, "SELECT * FROM view_detil_siswa where username='" . $nip[$i] . "'");
          while ($cs = mysqli_fetch_array($lst_siswa)) {
            $cek = mysqli_query($conn, "SELECT * FROM rb_absensi_guru where  nip='" . $nip[$i] . "' AND tanggal='$tglabsen' and kode_kehadiran='P' ");
            while ($cik = mysqli_fetch_array($cek)) {

              $idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));
              $idts = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM view_detil_siswa where level='kepsek'"));
              $link = $idt['link_one_sender'];
              $links = $idt['token'];
              $wa = $idt['wa'];

              $phone = $idts['no_telp'];
              $cak = $cik['kode_kehadiran'];
              $waktu = tgl_indo($cik['tanggal']);
              $waktus = hari_ini($cik['tanggal']);

              if ($cak == 'A') {
                $statush = 'Alpa';
              } elseif ($cak == 'S') {
                $statush = 'Sakit';
              } elseif ($cak == 'I') {
                $statush = 'Izin';
              } elseif ($cak == 'H') {
                $statush = 'Hadir';
              } else {
                $statush = 'Pulang';
              }
              $isi_pesan = 'Diberitahukan Bahwa Bpk/Ibu Guru dengan nama *' . $cs['nama_guru'] . '*, absensi Hari ini ' . $waktus . ', ' . $waktu . ' : _*' . $statush . '*_';

              $data = [
                "api_key" => $links,
                "sender" => $wa,
                "number" => $phone,
                "message" => $isi_pesan
              ];
              $data_string = json_encode($data);

              $curl = curl_init();
              curl_setopt_array($curl, array(
                CURLOPT_URL => $link,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data_string,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_VERBOSE => 0,
                CURLOPT_CONNECTTIMEOUT => 0,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/json',
                  'Content-Length: ' . strlen($data_string)
                ),
              ));

              $response = curl_exec($curl);
              curl_close($curl);

              echo $response . '<br>';
            }
            echo "<script>document.location='?view=absentim&suksess';</script>";
          }
        } else {
          $nama_file = $_FILES['gambar']['name'];
          $ukuran_file = $_FILES['gambar']['size'];
          $tipe_file = $_FILES['gambar']['type'];
          $tmp_file = $_FILES['gambar']['tmp_name'];

          $path = "./images/" . $nama_file;
          move_uploaded_file($tmp_file, $path); // Cek apakah gambar berhasil diupload atau tidak
          // Jika gambar berhasil diupload, Lakukan :	

          mysqli_query($conn, "INSERT INTO rb_absensi_guru VALUES ('',
                                                             
                                                              '" . $nip[$i] . "',
                                                              '" . $a[$i] . "',
                                                              '$tglabsen',
                                                              '" . date('Y-m-d H:i:s') . "', '" . $nama_file . "','" . $ukuran_file . "','" . $tipe_file . "', '" . $_POST['latlng'] . "',  '" . $_POST['keterangan'] . "')");
          $lst_siswa = mysqli_query($conn, "SELECT * FROM view_detil_siswa where username='" . $nip[$i] . "'");
          while ($cs = mysqli_fetch_array($lst_siswa)) {
            $cek = mysqli_query($conn, "SELECT * FROM rb_absensi_guru where nip='" . $nip[$i] . "' AND tanggal='$tglabsen' ");
            while ($cik = mysqli_fetch_array($cek)) {

              $idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas"));
              $idts = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM view_detil_siswa where level='kepsek'"));

              $link = $idt['link_one_sender'];
              $links = $idt['token'];
              $wa = $idt['wa'];

              $phone = $idts['no_telp'];
              $cak = $cik['kode_kehadiran'];
              $waktu = tgl_indo($cik['tanggal']);
              $waktus = hari_ini($cik['tanggal']);

              if ($cak == 'A') {
                $statush = 'Alpa';
              } elseif ($cak == 'S') {
                $statush = 'Sakit';
              } elseif ($cak == 'I') {
                $statush = 'Izin';
              } elseif ($cak == 'T') {
                $statush = 'Terlambat';
              } else {
                $statush = 'Hadir';
              }
              $isi_pesan = "Diberitahukan Bahwa *$cs[nama_guru]*, absensi Hari ini $waktus, $waktu : _*$statush*_";

              $data = [
                "api_key" => $links,
                "sender" => $wa,
                "number" => $phone,
                "message" => $isi_pesan
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
            }
          }
          echo "<script>document.location='?view=absentim&sukses';</script>";
        }
      }
    }
  }
}
?>