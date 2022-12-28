<html>

<head>
  <title>Cetak - Laporan Absensi TIM</title>
  <link rel="stylesheet" href="bootstrap/css/printer.css">
  <link rel="shortcut icon" href="img/loh.png" />
  <style>
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
  <?php
  session_start();
  error_reporting(0);
  include "config/koneksi.php";
  include "config/fungsi_indotgl.php";


  $tgl_mulai = $_GET['tgl_mulai'];
  $tgl_akhir = $_GET['tgl_akhir'];


  $idKelas = $_GET['kelas'];
  if ($_GET['kelas'] != 'all') {
    $kls = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));
    $kelas = 'Kelas ' . $kls['nmKelas'];
  } else {
    $kelas = 'Semua Kelas';
  }
  $idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas "));

  $d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kelas_siswa where idKelas='$_GET[kelas]'"));
  ?>
  <div class='col-md-12'>
    <div class='box box-info'>
      <div class='box-header with-border'>
        <h3 align='center'>Rekap Data Absensi TIM </b></h3>
      </div>
      <div class='table-responsive'>

        <div class='col-md-12'>

       
         
          <h4 class='box-title'>Dari Tanggal : <?php echo  tgl_indo($tgl_mulai); ?> Sampai <?php echo   tgl_indo($tgl_akhir); ?>

          </h4>

        </div>

        <?php
        $tgl_mulai = $_GET['tgl_mulai'];
        $tgl_akhir = $_GET['tgl_akhir'];


   


        $ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
       


        ?>

      </div><!-- /.box-header -->
      <div class="table-responsive">
        <table id="example" class="table table-bordered table-striped">
          <thead class="thead">
            <tr>
              <th>No</th>
              <th>Nama TIM</th>
            
              <th>Kode Kehadiran</th>
              <th>Waktu Input</th>
             
 
              <th>Lokasi</th>
              <th>Foto Selfie</th>

            </tr>
           
          </thead>
          <tbody>
            <?php

           
              $tampil = mysqli_query($conn, "SELECT nmSiswa,waktu_input,nama,latlng,keterangan,kode_kehadiran FROM rb_absensi_guru 
              INNER JOIN view_detil_siswa ON rb_absensi_guru.nip = view_detil_siswa.username
              where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  ");
          
            
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
             
              $total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' GROUP BY tanggal"));
              if ($total == 'null') {
                $sw = "<center style='padding:60px; color:red'>Maaf Tidak ada data...</center>";
              } else {

                $hadir = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='H'"));
                $sakit = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='S'"));
                $izin = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='I'"));
                $alpa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='A'"));
                $telat = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='T'"));
                //hitung keseluruhan siswa
                if ($idKelas == 'all') {
                    $sakits = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='S'"));
                  $izins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='I'"));
                  $alpas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='A'"));
                  $telats = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='T'"));
                  $totals = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' and kode_kehadiran!='H' "));
                } else {
                    $sakits = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='S'"));
                  $izins = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='I'"));
                  $alpas = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND kode_kehadiran='A'"));
                  $telats = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  AND kode_kehadiran='T'"));
                  $totals = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir'  and kode_kehadiran!='H'  "));
                }
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
                <td >$no</td>
              
                <td>$r[nmSiswa]</td>
              
                <td align='center'> $statush </td>
               
                <td>$r[waktu_input]</td>
                
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
            echo " ";
            ?>

          </tbody>
        </table>
      </div><!-- /.box-body -->
      <?php

      echo $sw;

      ?>
    </div>
  </div>
  <br>
  <table width="100%">
    <tr>
      <td align="center"></td>
      <td align="center" width="400px">
        Banyuwangi, <?php echo tgl_raport(date("Y-m-d")); ?>
        <br><br><br><br><br><br>
        <b> <?php echo $idt['nmKepsek']; ?></b>

      </td>
    </tr>
  </table>
</body>
<script>
  window.print()
</script>

</html>