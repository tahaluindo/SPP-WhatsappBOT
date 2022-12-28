<?php
include 'config/rupiah.php';



$hari = date('d');
$query_hari = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE DATE_FORMAT((tanggal),'%m') like '%$bulan%'");
$saldo_h = mysqli_fetch_array($query_hari);
$saldo_hari = $saldo_h['jumlah_debit'] - $saldo_h['jumlah_kredit'];

$ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
$idTahun = $ta['idTahunAjaran'];
$tahun = $ta['nmTahunAjaran'];
// Hitung Pembayaran Bulanan
$dBul = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totalBul FROM tagihan_bulanan WHERE statusBayar='1' and idSiswa='$_SESSION[idsa]'"));
$totalPendapatanBulanan = $dBul['totalBul'];

// Hitung Pembayaran Bebas

$dBeb = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS totalBeb FROM tagihan_bebas_bayar where statusBayar='1'"));
$totalPendapatanBebas = $dBeb['totalBeb'];

$idt = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM identitas where npsn='10700295'"));
$pos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pos_bayar where idPosBayar='$_GET[pos]'"));

$idsiswa = $_GET['siswa'];
$dtsiswa = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM view_detil_siswa where nisnSiswa='$_SESSION[ids]'"));
$nissiswa = $dtsiswa['nisSiswa'];
$namasiswa = $dtsiswa['nmSiswa'];
$namakelas = $dtsiswa['nmKelas'];

$apa = mysqli_query($conn, "SELECT * FROM siswa where nisnSiswa='$_SESSION[ids]' ");
$ra = mysqli_fetch_array($apa);

$edit = mysqli_query($conn, "SELECT * FROM identitas ");
$record = mysqli_fetch_array($edit);
?>


<div class="col-md-12 col-sm-6 col-xs-12">


  <div class="box box-warning ">
    <div class="box-header with-border">
      <h3 class="box-title">
        <?php date_default_timezone_set('Asia/Jakarta');
        //Menampilkan tanggal hari ini dalam bahasa Indonesia dan English
        $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");
        $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $today = date('l, F j, Y');
        $sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n') - 1)] . " " . date('Y'); ?>

        <?php echo $sekarang; ?> | <?php
                                    date_default_timezone_set('Asia/Jakarta'); //Menyesuaikan waktu dengan tempat kita tinggal
                                    echo $timestamp = date('H:i:s'); //Menampilkan Jam Sekarang
                                    ?> |
        <SCRIPT language=JavaScript>
          var d = new Date();
          var h = d.getHours();
          if (h < 11) {
            document.write('Selamat pagi, ');
          } else {
            if (h < 15) {
              document.write('Selamat siang, ');
            } else {
              if (h < 19) {
                document.write('Selamat sore, ');
              } else {
                if (h <= 23) {
                  document.write('Selamat malam,');
                }
              }
            }
          }
        </SCRIPT><?php echo $ra['nmSiswa'] ?><div class="col" role="main">
      </h3>

    </div><!-- /.box-header -->
    <section class="content">
      <div class="row">

        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Nama Perusahan</span>
              <span class="info-box-number"><?php echo $record['nmSekolah']; ?> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-user-plus"></i></span>


            <div class="info-box-content">
              <span class="info-box-text dash-text">Total Pembayaran Gaji</span>
                <span class="info-box-number">Rp. <?php echo rupiah($totalPendapatanBulanan + $totalPendapatanBebas); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <?php
        $query_pegawai = mysqli_query($conn, "SELECT *  FROM users");
        $num_pegawai = mysqli_num_rows($query_pegawai);
        $query_nasabah = mysqli_query($conn, "SELECT *  FROM siswa");
        $num_nasabah = mysqli_num_rows($query_nasabah);


        ?>
        <!-- fix for small devices only -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Nama Lengkap</span>
              <span class="info-box-number"><?php echo $ra['nmSiswa'] ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-male"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">nama jabatan </span>
              <span class="info-box-number"> <?php echo $dtsiswa['nmKelas']; ?>(<?php echo $dtsiswa['ketKelas']; ?>)</span>

            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
        <div class="clearfix visible-sm-block"></div>


        <div class="clearfix visible-sm-block"></div>

        <!--<div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-credit-box"></i></span>

            <div class="info-box-content">

              <span class="info-box-text dash-text">Nomor Rekening Tabungan </span>
              <span class="info-box-number"><?php echo $ra['nisnSiswa']; ?></span>
            </div>
        
          </div>
 
        </div>-->
        <!-- /.col -->


        <!-- /.col -->

        <!-- /.info-box -->


        <!-- /.col -->

        <!-- /.info-box -->

        <!-- /.col -->


        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
  </div>
  <!-- /.col -->