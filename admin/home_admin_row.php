<?php
include 'config/rupiah.php';
// include 'config/lisensi.php';
$query_saldo = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi");
$row_saldo = mysqli_fetch_array($query_saldo);
$saldo_keseluruhan = $row_saldo['jumlah_debit'] - $row_saldo['jumlah_kredit'];

$total = 0;
//$sqlJU = mysqli_query($conn,"SELECT * FROM jurnal_umum WHERE DATE(tgl) BETWEEN '$tgl1' AND '$tgl2' ORDER BY tgl ASC");

//hitung pemasukan dan pengeluaran dari jurnal umum
$dPJU = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(penerimaan) AS totalMasuk, SUM(pengeluaran) AS totalKeluar FROM jurnal_umum"));
$totalPemasukan = $dPJU['totalMasuk'];
$totalPengeluaran = $dPJU['totalKeluar'];

$dPJUs = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(penerimaan) AS totalMasuk, SUM(pengeluaran) AS totalKeluar FROM saldoawal"));
$totalPemasukans = $dPJUs['totalMasuk'];
$totalPengeluarans = $dPJUs['totalKeluar'];

// Hitung Pembayaran Bulanan
$dBul = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBul FROM tagihan_bulanan WHERE statusBayar='1'"));
$totalPendapatanBulanan = $dBul['totalBul'];
// Hitung Saldo
$saldod = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(nominal) AS nominals FROM bank"));
$saldonya = $saldod['nominals'];
// Hitung Pembayaran Bebas
$dBeb = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBeb FROM tagihan_bebas_bayar"));
$totalPendapatanBebas = $dBeb['totalBeb'];

$query_saldo = mysqli_query($conn, "SELECT SUM(sisa) as jumlah_debit FROM hutangtoko");
$row = mysqli_fetch_array($query_saldo);
$saldo_keseluruhans = $row['jumlah_debit'];

$bulan = date('m');
$query_saldo = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE DATE_FORMAT((tanggal),'%m') like '%$bulan%'");
$saldo = mysqli_fetch_array($query_saldo);
$saldo_bulan = $saldo['jumlah_debit'] - $saldo['jumlah_kredit'];


$hari = date('d');
$query_hari = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE DATE_FORMAT((tanggal),'%m') like '%$bulan%'");
$saldo_h = mysqli_fetch_array($query_hari);
$saldo_hari = $saldo_h['jumlah_debit'] - $saldo_h['jumlah_kredit'];


$edit = mysqli_query($conn, "SELECT * FROM identitas ");
$record = mysqli_fetch_array($edit);
?>

<div class="col-xs-12">
  <?php if (isset($_GET['alert']) && $_GET['alert'] == 'updb') { ?>
    <div class="alert alert-success alert-dismissible text-center" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <p><b>Update Datbase Berhasil..</b></p>
    </div>
  <?php } ?>

  <div class="box box-warning box-solid">
    <div class="box-header with-border">
      <h3 class="box-title">

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
                  document.write('Selamat malam, ');
                }
              }
            }
          }
        </SCRIPT> <?php echo $_SESSION['namalengkap']; ?> ||<div class="col" role="main">
      </h3>
      <h3 class="box-title">

        <?php
        $hari = date('l');
        /*$new = date('l, F d, Y', strtotime($Today));*/
        if ($hari == "Sunday") {
          echo "Minggu";
        } elseif ($hari == "Monday") {
          echo "Senin";
        } elseif ($hari == "Tuesday") {
          echo "Selasa";
        } elseif ($hari == "Wednesday") {
          echo "Rabu";
        } elseif ($hari == "Thursday") {
          echo ("Kamis");
        } elseif ($hari == "Friday") {
          echo "Jum'at";
        } elseif ($hari == "Saturday") {
          echo "Sabtu";
        }
        ?>,
        <?php
        $tgl = date('d');
        echo $tgl;
        $bulan = date('F');
        if ($bulan == "January") {
          echo " Januari ";
        } elseif ($bulan == "February") {
          echo " Februari ";
        } elseif ($bulan == "March") {
          echo " Maret ";
        } elseif ($bulan == "April") {
          echo " April ";
        } elseif ($bulan == "May") {
          echo " Mei ";
        } elseif ($bulan == "June") {
          echo " Juni ";
        } elseif ($bulan == "July") {
          echo " Juli ";
        } elseif ($bulan == "August") {
          echo " Agustus ";
        } elseif ($bulan == "September") {
          echo " September ";
        } elseif ($bulan == "October") {
          echo " Oktober ";
        } elseif ($bulan == "November") {
          echo " November ";
        } elseif ($bulan == "December") {
          echo " Desember ";
        }
        $tahun = date('Y');
        echo $tahun;
        ?> ||<script type="text/javascript">
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
          <span id="clock"></span>
      </h3>
    </div><!-- /.box-header -->
    <?php
    $query_pegawai = mysqli_query($conn, "SELECT *  FROM users");
    $num_pegawai = mysqli_num_rows($query_pegawai);
    $query_project_s = mysqli_query($conn, "SELECT *  FROM project where status='Selesai'");
    $num_project_s = mysqli_num_rows($query_project_s);
    $query_project_p = mysqli_query($conn, "SELECT *  FROM project where status='Pending'");
    $num_project_p = mysqli_num_rows($query_project_p);
    $query_project_pe = mysqli_query($conn, "SELECT *  FROM project where status='Proses'");
    $num_project_pe = mysqli_num_rows($query_project_pe);
    $query_project_b = mysqli_query($conn, "SELECT *  FROM project where status='Batal'");
    $num_project_b = mysqli_num_rows($query_project_b);
    $query_nasabah = mysqli_query($conn, "SELECT *  FROM siswa");
    $num_nasabah = mysqli_num_rows($query_nasabah);
    $query_pegawais = mysqli_query($conn, "SELECT *  FROM mitra");
    $num_pegawais = mysqli_num_rows($query_pegawais);
    ?>
    <section class="content">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Nama Perusahaan</span>
              <span class="info-box-number"><?php echo $record['nmSekolah']; ?> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-code-fork"></i></span>


            <div class="info-box-content">
              <span class="info-box-text dash-text">Mitra</span>
              <span class="info-box-number"><?php echo $num_pegawais; ?> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>

            <div class="info-box-content">

              <span class="info-box-text dash-text">User Aktif</span>
              <span class="info-box-number"><?php echo $num_pegawai; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">TIM Hebat</span>
              <span class="info-box-number"><?php echo $num_nasabah; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- /.col -->

        <!-- /.col -->
        <!-- /.col -->
        <!-- <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-money "></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Saldo kas</span>
              <span class="info-box-number">Rp. <?php echo rupiah($totalPemasukans + $totalPendapatanBulanan + $totalPendapatanBebas + $totalPemasukan - $totalPengeluaran); ?></span>
            </div>
   
          </div>
       
        </div>-->
        <!-- /.col -->
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-toggle-down text-azure"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Total Pembayaran Gaji</span>
              <span class="info-box-number">Rp. <?php echo rupiah($totalPendapatanBulanan + $totalPendapatanBebas); ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


      </div>
      <div class="box box-info box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"> Manajemen Project</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-folder-open"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text"> Selesai</span>
              <span class="info-box-number"><?php echo $num_project_s; ?> Project</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-folder-open"></i></span>


            <div class="info-box-content">
              <span class="info-box-text dash-text"> Pending</span>
              <span class="info-box-number"><?php echo $num_project_p; ?> Project</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-folder-open"></i></span>

            <div class="info-box-content">

              <span class="info-box-text dash-text">Proses</span>
              <span class="info-box-number"><?php echo $num_project_pe; ?> Project</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-folder-open"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Batal</span>
              <span class="info-box-number"><?php echo $num_project_b; ?> Project</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <!-- /.col -->

        <!-- /.col -->
        <!-- /.col -->


      </div><br>
      <?php
      $hari  = date('d');
      $bulan = date('m');
      $tahun = date('Y');
      $sqlTagihanBebas = mysqli_fetch_array(mysqli_query($conn, "SELECT
									jurnal_umums.*,
									jenis_penerimaan.idPenerimaan,
									jenis_penerimaan.nmPenerimaan,
									sum(jurnal_umums.penerimaan) as penerimaaN,
									jurnal_umums.ket
								FROM
								jurnal_umums
								INNER JOIN jenis_penerimaan ON jurnal_umums.idPenerimaan = jenis_penerimaan.idPenerimaan
									WHERE jurnal_umums.idPenerimaan='3' and year(jurnal_umums.tgl)='$tahun' ORDER BY jurnal_umums.idPenerimaan ASC"));
      $ppn = $sqlTagihanBebas['penerimaaN'] * 0.5 / 100;
      // Hitung pemasukan hari ini
      $dHah = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBul FROM tagihan_bulanan WHERE  day(tglBayar)='$hari' AND month(tglBayar)='$bulan' AND year(tglBayar)='$tahun' and statusBayar='1'"));
      $dBebs = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBebs FROM tagihan_bebas_bayar WHERE day(tglBayar)='$hari' AND month(tglBayar)='$bulan' AND year(tglBayar)='$tahun'"));
      $totalPemasukanHariInis = $dHah['totalBul'];
      $totalPemasukanHariIniss = $dBebs['totalBebs'];
      $totalPemasukanHariIni = $totalPemasukanHariInis  + $totalPemasukanHariIniss;
      // Hitung pemasukan bulan ini
      $dTah = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBul FROM tagihan_bulanan WHERE  month(tglBayar)='$bulan' AND year(tglBayar)='$tahun' and statusBayar='1'"));
      $dBeb = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBebs FROM tagihan_bebas_bayar WHERE month(tglBayar)='$bulan' AND year(tglBayar)='$tahun'"));;
      $totalPemasukanBulanInis = $dTah['totalBul'];
      $totalPemasukanBulanIniss = $dBeb['totalBebs'];
      $totalPemasukanBulanIni = $totalPemasukanBulanInis + $totalPemasukanBulanIniss;
      // Hitung pemasukan tahun ini
      $dBul = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBul  FROM tagihan_bulanan WHERE  year(tglBayar)='$tahun' and statusBayar='1'"));
      $dBeb = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBebs FROM tagihan_bebas_bayar WHERE year(tglBayar)='$tahun'"));
      $totalPemasukanTahunInis = $dBul['totalBul'];
      $totalPemasukanTahunIniss = $dBeb['totalBebs'];
      $totalPemasukanTahunIni =  $totalPemasukanTahunInis  +  $totalPemasukanTahunIniss;
      // Hitung seluruh pemasukan
      $dTahS = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBul FROM tagihan_bulanan where statusBayar='1'"));
      $dBebS = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(jumlahBayar) AS totalBebs FROM tagihan_bebas_bayar "));
      $totalPemasukanSeluruhnyas = $dTahS['totalBul'];
      $totalPemasukanSeluruhnyass = $dBebS['totalBebs'];
      $totalPemasukanSeluruhnya = $totalPemasukanSeluruhnyas + $totalPemasukanSeluruhnyass;
      // Hitung pengeluaran hari ini
      $dPJU = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(pengeluaran) AS totalKeluar FROM jurnal_umum WHERE day(tgl)='$hari' AND month(tgl)='$bulan' AND year(tgl)='$tahun'"));
      $totalPengeluaranHariIni = $dPJU['totalKeluar'];

      // Hitung pengeluaran bulan ini
      $dPJUss = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(pengeluaran) AS totalKeluar FROM jurnal_umum WHERE month(tgl)='$bulan' AND year(tgl)='$tahun'"));
      $totalPengeluaranBulanIni = $dPJUss['totalKeluar'];

      // Hitung pengeluaran tahun ini
      $dPJUs = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(pengeluaran) AS totalKeluar FROM jurnal_umum WHERE year(tgl)='$tahun'"));
      $totalPengeluaranTahunIni = $dPJUs['totalKeluar'];

      // Hitung seluruh pengeluaran

      $dPJUa = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(pengeluaran) AS totalKeluar FROM jurnal_umum "));
      $totalPengeluaranSeluruhnya = $dPJUa['totalKeluar'];

      // Hitung penerimaan hari ini
      $dPJU = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(penerimaan) AS totalKeluar FROM jurnal_umums WHERE day(tgl)='$hari' AND month(tgl)='$bulan' AND year(tgl)='$tahun'"));
      $totalPenerimaanHariIni = $dPJU['totalKeluar'];

      // Hitung penerimaan bulan ini
      $dPJUss = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(penerimaan) AS totalKeluar FROM jurnal_umums WHERE month(tgl)='$bulan' AND year(tgl)='$tahun'"));
      $totalPenerimaanBulanIni = $dPJUss['totalKeluar'];

      // Hitung penerimaan tahun ini
      $dPJUs = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(penerimaan) AS totalKeluar FROM jurnal_umums WHERE year(tgl)='$tahun'"));
      $totalPenerimaanTahunIni = $dPJUs['totalKeluar'];

      // Hitung seluruh penerimaan

      $dPJUa = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(penerimaan) AS totalKeluar FROM jurnal_umums "));
      $totalPenerimaanSeluruhnya = $dPJUa['totalKeluar'];

      $totalkeluar = $totalPemasukanSeluruhnya + $totalPengeluaranSeluruhnya;
      ?>
  </div>
  <div class="box box-success box-solid">
    <div class="box-header with-border">
      <h3 class="box-title">
        Rekapitulasi Keuangan
      </h3>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($totalPenerimaanHariIni); ?></h3>
                <p class="dash-text">Pemasukan Hari Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="?view=jurnalumums" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($totalPenerimaanBulanIni); ?></h3>
                <p class="dash-text">Pemasukan Bulan Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="?view=jurnalumums" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($totalPenerimaanTahunIni); ?></h3>

                <p class="dash-text">Pemasukan Tahun Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="?view=jurnalumums" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-black">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($totalPenerimaanSeluruhnya); ?></h3>

                <p class="dash-text">Seluruh Pemasukan</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="?view=jurnalumums" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($totalPemasukanHariIni + $totalPengeluaranHariIni); ?></h3>

                <p class="dash-text">Pengeluaran Hari Ini </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($totalPemasukanBulanIni + $totalPengeluaranBulanIni); ?></h3>

                <p class="dash-text">Pengeluaran Bulan Ini </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($totalPemasukanTahunIni + $totalPengeluaranTahunIni); ?></h3>

                <p class="dash-text">Pengeluaran Tahun Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-black">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($totalPemasukanSeluruhnya + $totalPengeluaranSeluruhnya); ?></h3>

                <p class="dash-text">Seluruh Pengeluaran</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <?php
          $tampil = mysqli_query($conn, "SELECT * FROM bank ORDER BY id DESC");
          $data = array();
          while ($row = mysqli_fetch_array($tampil)) {
            $data[] = $row;
          }
          ?>
          <?php foreach ($data as $item) {
            $no = 1;
            $colors = ['green', 'yellow', 'black', 'aqua', 'red'];
            $randomColor = $colors[array_rand($colors)];
          ?>
            <div class="col-lg-6 col-12">
              <!-- small box -->
              <div class="small-box bg-<?php echo $randomColor; ?>">
                <div class="inner">
                  <h3 style="font-size: 2.5rem;"><?php echo buatRp($item['saldo']); ?></h3>
                  <p class="dash-text">Total Saldo <?php echo $item['nmBank']; ?> - <?php echo $item['atasNama']; ?></p>
                </div>
                <div class="icon">
                  <i class="ion ion-calculator"></i>
                </div>
                <a href="?view=bank" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          <?php } ?>
          <div class="col-lg-6 col-12">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($totalPenerimaanSeluruhnya - $totalkeluar); ?></h3>

                <p class="dash-text">Total Saldo Kas Perusahaan</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3 style="font-size: 2.5rem;"><?php echo buatRp($ppn); ?></h3>

                <p class="dash-text">Total Pajak Perusahaan</p>
              </div>
              <div class="icon">
                <i class="fa fa-money"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

      </div>


  </div>
</div>