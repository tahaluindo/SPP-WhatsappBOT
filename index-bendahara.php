<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/excel_reader.php";
include "config/fungsi_seo.php";
include "config/fungsi_thumb.php";
if (isset($_SESSION[id])) {
  if ($_SESSION[level] == 'bendahara') {
  }
  $iden = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM users where username='$_SESSION[id]'"));
  $nama =  $iden[nama_lengkap];
  $level = 'bendahara';
  $foto = './dist/img/avatar5.png';

  $idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas"));

  $ta = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tahun_ajaran where aktif='Y'"));
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Financial System | Juragan Karya Digital Teknologi</title>

    <link rel="shortcut icon" href="favicon.ico">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./assets/font-awesome-4.6.3/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="./assets/ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="plugins/datetimepicker/bootstrap-datetimepicker.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="assets/bootstrap-select/css/bootstrap-select.min.css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <style type="text/css">
      .files {
        position: absolute;
        z-index: 2;
        top: 0;
        left: 0;
        filter: alpha(opacity=0);
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        opacity: 0;
        background-color: transparent;
        color: transparent;
      }
    </style>
    <stlye> hallo word ></style>
    <script type="text/javascript" src="plugins/jQuery/jquery-1.12.3.min.js"></script>
    <script language="javascript" type="text/javascript">
      var maxAmount = 160;

      function textCounter(textField, showCountField) {
        if (textField.value.length > maxAmount) {
          textField.value = textField.value.substring(0, maxAmount);
        } else {
          showCountField.value = maxAmount - textField.value.length;
        }
      }
    </script>
    <script type="text/javascript" src="getDataCombo.js"></script>

  </head>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <?php include "main-header-bendahara.php"; ?>
      </header>

      <aside class="main-sidebar">
        <?php
        include "menu-bendahara.php";
        ?>
      </aside>

      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $judul; ?>
          </h1>
        </section>

        <section class="content">
          <?php if ($_GET[view] == 'home') {
            echo "<div class='row'>";
            include "bendahara/home_admin_row.php";
            echo "</div>";
          } elseif ($_GET[view] == 'pembayaran') {

            echo "<div class='row'>";
            include "bendahara/keuangan_pembayaran.php";
            echo "</div>";
          } elseif ($_GET[view] == 'tarif' && $_GET[tipe] == 'bulanan') {

            echo "<div class='row'>";
            include "bendahara/keuangan_tarif_bulanan.php";
            echo "</div>";
          } elseif ($_GET[view] == 'tarif' && $_GET[tipe] == 'bebas') {

            echo "<div class='row'>";
            include "bendahara/keuangan_tarif_bebas.php";
            echo "</div>";
          } elseif ($_GET[view] == 'pembayaran') {

            echo "<div class='row'>";
            include "bendahara/keuangan_pembayaran.php";
            echo "</div>";
          } elseif ($_GET[view] == 'admin') {

            echo "<div class='row'>";
            include "bendahara/master_admin.php";
            echo "</div>";
          } elseif ($_GET[view] == 'angsuran') {

            echo "<div class='row'>";
            include "bendahara/keuangan_pembayaran_bebas.php";
            echo "</div>";
          } elseif ($_GET[view] == 'bayarbulanan') {

            echo "<div class='row'>";
            include "bendahara/keuangan_pembayaran_bulanan.php";
            echo "</div>";
          } elseif ($_GET[view] == 'lapsiswa') {

            echo "<div class='row'>";
            include "bendahara/laporan_siswa.php";
            echo "</div>";
          } elseif ($_GET[view] == 'lappembayaran') {

            echo "<div class='row'>";
            include "bendahara/laporan_pembayaran_perkelas.php";
            echo "</div>";
          } elseif ($_GET[view] == 'lappembayaranperbulan') {

            echo "<div class='row'>";
            include "bendahara/laporan_pembayaran_perbulan.php";
            echo "</div>";
          } elseif ($_GET[view] == 'lappembayaranperposbayar') {

            echo "<div class='row'>";
            include "bendahara/laporan_pembayaran_perposbayar.php";
            echo "</div>";
          } elseif ($_GET[view] == 'laptagihansiswa') {

            echo "<div class='row'>";
            include "bendahara/laporan_tagihan_siswa.php";
            echo "</div>";
          } elseif ($_GET[view] == 'rekapitulasi') {

            echo "<div class='row'>";
            include "bendahara/laporan_rekapitulasi.php";
            echo "</div>";
          } elseif ($_GET[view] == 'rekappengeluaran') {

            echo "<div class='row'>";
            include "bendahara/laporan_rekappengeluaran.php";
            echo "</div>";
          } elseif ($_GET[view] == 'rekapkondisikeuangan') {

            echo "<div class='row'>";
            include "bendahara/laporan_kondisi_keuangan.php";
            echo "</div>";
          }
          ?>
        </section>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <?php include "footer.php"; ?>
      </footer>
    </div><!-- ./wrapper -->
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="plugins/highcharts/js/highcharts.js"></script>
    <script src="plugins/highcharts/js/modules/data.js"></script>
    <script src="plugins/highcharts/js/modules/exporting.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>

    <script src="assets/js/script.js"></script>
    <script src="assets/app.js"></script>

    <script src="assets/bootstrap-select/js/bootstrap-select.min.js"></script>

    <script>
      $('.textarea').wysihtml5();

      $(function() {
        // datepicker plugin
        $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true,
          format: 'yyyy-mm-dd'
        });

        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        $('#example3').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200
        });

        $('#mastersiswa').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200
        });

        $('#example5').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200,
          "order": [
            [5, "desc"]
          ]
        });
      });

      //$('.datepicker').datepicker();

      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
      });

      $('.datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1
      });

      $(".harusAngka").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          return false;
        }
      });

      $("#parent").click(function() {
        $(".child").prop("checked", this.checked);
      });

      $('.child').click(function() {
        if ($('.child:checked').length == $('.child').length) {
          $('#parent').prop('checked', true);
        } else {
          $('#parent').prop('checked', false);
        }
      });

      //hitung
      /*
      $('#hitungBayaran').keyup(function(){
      	if ($(this).val() > $("#sisa").val()){
      		alert('Anda memasukkan nilai melebihi total tagihan!');
      		$(this).val($("#sisa").val());
      	}
      });
      */

      $("#allTarif").keypress(function(e) {
        var allTarif = $("#allTarif").val();
        if (e.which == 13) {
          $("#n1").val(allTarif);
          $("#n2").val(allTarif);
          $("#n3").val(allTarif);
          $("#n4").val(allTarif);
          $("#n5").val(allTarif);
          $("#n6").val(allTarif);
          $("#n7").val(allTarif);
          $("#n8").val(allTarif);
          $("#n9").val(allTarif);
          $("#n10").val(allTarif);
          $("#n11").val(allTarif);
          $("#n12").val(allTarif);
        }
      });
      $("#allTarifBebas").keypress(function(e) {
        var allTarif = $("#allTarifBebas").val();
        if (e.which == 13) {
          $(".nTagihan").val(allTarif);
        }
      });
    </script>

  </body>

  </html>

<?php
} else {
  include "login-bendahara.php";
}
?>