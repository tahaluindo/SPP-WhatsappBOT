<?php
session_start();
include '../../config/koneksi.php';
if (!isset($_SESSION['namauser'])) {
}
if ($_GET['aksi'] == '') {
?>
  <h2>Untuk mengetahui riwayat transaksi silahkan ketikkan nama anda di kolom search</h2>
  <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Kelas </h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Kelas</th>
              <th>Nama Kelas</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            <?php

            $no = 0;
            $query = mysqli_query($conn,"SELECT * FROM transaksi  JOIN siswa ON transaksi.idSiswa=siswa.idSiswa ORDER BY id_transaksi  DESC");
            while ($row = mysqli_fetch_array($query)) {
              $no++;
            ?>
              <tr>
                <td><?php echo $no; ?></td>

                <td><?php echo $row['nmSiswa']; ?></td>
                <td>Rp.<?php echo rupiah($row['debit']); ?></td>
                <td>Rp.<?php echo rupiah($row['kredit']); ?></td>
                <td><?php echo $row['tanggal']; ?></td>
                <td><?php echo $row['keterangan']; ?></td>
                <td>Rp. <?php echo rupiah($row['saldo']); ?></td>
              <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
<?php
} elseif ($_GET['aksi'] == 'cetak') {
?>

  <body onload="window.print()">
    <title>Cetak Laporan</title>

    <style type="text/css">
      body {
        font-family: sans-serif;
      }

      table {
        border-collapse: collapse;
        font-family: sans-serif;
      }

      th {
        height: 30px;
        font-size: 12px;
        font-family: sans-serif;
      }

      table,
      th,
      td {
        border: 1px solid black;
        font-size: 11px;
        padding: 5px;
      }

      h3 {
        padding-bottom: -15px;
        font-family: sans-serif;
        text-align: center;
        text-transform: uppercase;

      }

      p {
        font-size: 12px;
        text-align: center;
        padding-bottom: -8px;
      }

      .divider-dashed {
        border-top: 1px dashed #ccc;
        background-color: #fff;
        height: 1px;
        margin: 10px 0;
      }



      #kiri {
        width: 50%;
        height: 100px;
        background-color: #FF0;
        float: left;
      }

      #kanan {
        width: 50%;
        height: 100px;
        background-color: #0C0;
        float: right;
      }

      <script type="text/javascript">
      /*--This JavaScript method for Print command--*/

      function PrintDoc() {

        var toPrint=document.getElementById('tabel');
        var popupWin=window.open('');

        popupWin.document.open();

        popupWin.document.write('<html><title>::Print Data::</title><link rel="stylesheet" type="text/css" href="print.css" /></head><body onload="window.print()">') popupWin.document.write(toPrint.outerHTML);
        popupWin.document.write('</html>');
        popupWin.document.close();

      }

      /*--This JavaScript method for Print Preview command--*/

      function PrintPreview() {

        var toPrint=document.getElementById('tabel');

        var popupWin=window.open('');

        popupWin.document.open();

        popupWin.document.write('<html><title>::Printpreview Data::</title><link rel="stylesheet" type="text/css" href="print.css" media="screen"/></head><body">') popupWin.document.write(toPrint.outerHTML);

        popupWin.document.write('</html>');

        popupWin.document.close();
      }

      </script>
    </style>
    </head>

    <body>

    <?php
  }
    ?>