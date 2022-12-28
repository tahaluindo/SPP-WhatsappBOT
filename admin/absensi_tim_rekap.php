<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <form method="GET">
          <input type="hidden" name="view" value="<?= $_GET['view'] ?>">
          <div class="row">
            <div class="col-md-2">
              <label>Dari Tanggal</label>
              <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tgl_mulai" readonly="readonly" placeholder="Tanggal Awal" value="<?= $_GET['tgl_mulai'] ?>">
              </div>
            </div>
            <div class="col-md-2">
              <label>Sampai Tanggal</label>
              <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tgl_akhir" readonly="readonly" placeholder="Sampai Tanggal" value="<?= $_GET['tgl_akhir'] ?>">
              </div>
            </div>
            <div class="col-md-2">
              <label>Sampai Tanggal</label>
              <select id="kelas" name="kelas" class="form-control">
                <option value="" selected> - Pilih Jabatan - </option>
                <option value="all" selected> Semua Jabatan </option>
                <?php
                $sqk = mysqli_query($conn, "SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
                while ($k = mysqli_fetch_array($sqk)) {
                  $selected = ($k['idKelas'] == $kelas) ? ' selected="selected"' : "";
                  echo "<option value=" . $k['idKelas'] . " " . $selected . ">" . $k['nmKelas'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="col-md-2">
              <div style="margin-top:25px;">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Cari</button>
              </div>
            </div>
          </div>
          <br>
        </form>
      <?php } ?>
      <?php if (isset($_GET['tgl_mulai']) && isset($_GET['tgl_akhir']) && isset($_GET['kelas'])) {  
        $tgl_mulai = $_GET['tgl_mulai'];
        $tgl_akhir = $_GET['tgl_akhir'];
        $jabatan = $_GET['kelas'];
        ?>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <h3 class='box-title'></h3> <a class='pull-right btn btn-warning btn-sm' style='margin-right:5px' target='_blank' href='cetak_absens.php?tgl_mulai=<?php echo $_GET['tgl_mulai']; ?>&tgl_akhir=<?php echo $_GET['tgl_akhir']; ?>&kelas=<?php echo $_GET['kelas']; ?>'><i class='fa fa-print'></i> Cetak Rekap Absen</a>
          <h3 class='box-title'></h3> <a class='pull-right btn btn-success btn-sm' style='margin-right:5px' target='_blank' href='excel_absens.php?tgl_mulai=<?php echo $_GET['tgl_mulai']; ?>&tgl_akhir=<?php echo $_GET['tgl_akhir']; ?>&kelas=<?php echo $_GET['kelas']; ?>'><i class='fa fa-file-excel-o'></i> Excel Rekap Absensi </a>
          <h3 class='box-title'></h3> <a class='pull-right btn btn-info btn-sm' style='margin-right:5px' target='_blank' href='excel_absen_per_siswa.php?tgl_mulai=<?php echo $_GET['tgl_mulai']; ?>&tgl_akhir=<?php echo $_GET['tgl_akhir']; ?>&kelas=<?php echo $_GET['kelas']; ?>'><i class='fa fa-file-excel-o'></i> Excel Rekap Absensi dan Presensi </a>
          <br><br>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>

                <th>Nama TIM</th>

                <th>Waktu Input</th>


                <th>Kode Kehadiran</th>
                <th>Lokasi</th>

                <th>Foto</th>

              </tr>
            </thead>
            <tbody>
              <?php


              $tampil = mysqli_query($conn, "SELECT nmSiswa,waktu_input,nama,latlng,keterangan,kode_kehadiran 
                FROM rb_absensi_guru 
              INNER JOIN view_detil_siswa ON rb_absensi_guru.nip = view_detil_siswa.username  
            
              where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' and view_detil_siswa.idKelas='$jabatan'
                ");

              $no = 1;
              while ($r = mysqli_fetch_array($tampil)) {

                $total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' GROUP BY tanggal"));
                if ($total == 'null') {
                  $sw = "<center style='padding:60px; color:red'>Maaf Tidak ada data...</center>";
                } else {

                  $hadir = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='H'"));
                  $sakit = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='S'"));
                  $izin = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='I'"));
                  $alpa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='A'"));
                  $telat = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='T'"));
                  //hitung keseluruhan siswa

                  $hadirs = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='H'"));
                  $sakits = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='S'"));
                  $izins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='I'"));
                  $alpas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='A'"));
                  $telats = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='T'"));
                  $totals = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' "));

                  $tambah = $hadir + $telat;
                  $persen = $tambah / ($total) * 100;
                  $data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'"));
                  if (!file_exists("images/$r[nama]") or $r['nama'] == '') {
                    $foto_user = "blank.png";
                  } else {
                    $foto_user = $r['nama'];
                  }
                  $kode = $r['kode_kehadiran'];
                  if ($kode == 'A') {
                    $statush = 'Alpa';
                  } elseif ($kode == 'S') {
                    $statush = 'Sakit';
                  } elseif ($kode == 'I') {
                    $statush = 'Izin';
                  } elseif ($kode == 'H') {
                    $statush = 'Hadir';
                  } elseif ($kode == 'T') {
                    $statush = 'Terlambat';
                  } else {
                    $statush = 'Pulang';
                  }
                  echo "<tr bgcolor=$warna>
                <td>$no</td>
              
                <td>$r[nmSiswa]</td>
            
                <td>$r[waktu_input]</td>
            
              
                <td>$statush</td>
                <td id='map' >" . $r['latlng'] . "</td>
               
                <td align=center><img src=" . './images/' . $foto_user . " id='target'  width='100' height='100' class='img-thumbnail img-responsive'>
                </td>
               ";
                  echo " 
    </tr>
    ";
                  $no++;
                }
              }
              echo "</tbody></table><tr>
            <td colspan='1'><b>Keterangan</b></td>
            
          </tr>
          <table id='example' class='table table-bordered table-striped' width='40%'>
          <tr>
          <td colspan='1'>Siswa Hadir</td>
          <td > $hadirs</td>
        </tr>
          <tr>
            <td colspan='1'>TIM Izin</td>
            <td > $izins</td>
          </tr>
          <tr>
            <td colspan='1'>TIM Sakit</td>
            <td > $sakits</td>
          </tr>
          <tr>
            <td colspan='1'>TIM Alpha</td>
            <td > $alpas</td>
          </tr>
          <tr>
          <td colspan='1'>TIM Terlambat</td>
          <td > $telats</td>
        </tr>
          <tr>
          <td colspan='1'><b>Jumlah Total</b></td>
          <td >  $totals</td>
        </tr>
          ";
              echo " </tbody>
          </table> ";
              ?>

            </tbody>
          </table>
        </div><!-- /.box-body -->
        <?php

        echo $sw;

        ?>
      </div>
    </div>
  <?php
      } elseif ($_GET['act'] == 'tampilabsen') {
        $d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kelas_siswa where idKelas='$_GET[id]'"));
        $m = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM rb_mata_pelajaran where kode_pelajaran='$_GET[kd]'"));
        $n = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM rb_jadwal_pelajaran where "));
        echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Rekap Data Absensi Siswa </b></h3> <a class='pull-right btn btn-success btn-sm' style='margin-right:5px' target='_blank' href='cetak_absen.php?id=$_GET[id]&kd=$_GET[kd]&jdwl=$_GET[jdwl]&tahun=$_GET[tahun]'><i class='fa fa-print'></i> Cetak Rekap Absen</a>
                </div>
              <div class='table-responsive'>

              <div class='col-md-12'>
              <table class='table table-condensed table-hover'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[idKelas]'>
                   
                    <tr><th width='120px' scope='row'>Nama Kelas</th> <td>$d[nmKelas]</td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>           <td>$m[namamatapelajaran]</td></tr>
                  </tbody>
              </table>
              </div>

              <form method='POST' class='form-horizontal' action='' enctype='multipart/form-data'>
                <div class='col-md-12'>
                  <table class='table table-condensed table-bordered table-striped'>
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>Nama Siswa</th>
                        <th>Pertemuan</th>
                        <th>Hadir</th>
                        <th>Sakit</th>
                        <th>Izin</th>
                        <th>Alpa</th>
                        <th><center>% Kehadiran</center></th>
                      </tr>
                    </thead>
                    <tbody>";

        $no = 1;
        $tampil = mysqli_query($conn, "SELECT * FROM siswa a where a.idKelas='$_GET[id]' ORDER BY a.idSiswa");
        while ($r = mysqli_fetch_array($tampil)) {
          $total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  GROUP BY tanggal"));
          $hadir = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  AND nisn='$r[username]' AND kode_kehadiran='H'"));
          $sakit = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  AND nisn='$r[username]' AND kode_kehadiran='S'"));
          $izin = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  AND nisn='$r[username]' AND kode_kehadiran='I'"));
          $alpa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  AND nisn='$r[username]' AND kode_kehadiran='A'"));
          $persen = $hadir / ($total) * 100;
          echo "<tr bgcolor=$warna>
                            <td>$no</td>
                            <td>$r[username]</td>
                            <td>$r[nmSiswa]</td>
                            <td align=center>$total</td>
                            <td align=center>$hadir</td>
                            <td align=center>$sakit</td>
                            <td align=center>$izin</td>
                            <td align=center>$alpa</td>
                            <td align=right>" . number_format($persen, 2) . " %</td>";
          echo "</tr>";
          $no++;
        }

        echo "</tbody>
                  </table>
                </div>
              </div>
            </div>";
      }
  ?>