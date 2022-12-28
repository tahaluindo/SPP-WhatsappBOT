<?php
include '../../config/conn.php';
$aksi = "component/com_nasabah/nasabah_aksi.php";
if ($_GET['aksi'] == '') { ?>

  <!-- page content -->
  <div class="col" role="main">

    <div class="">
      <div class="page-title">
        <div class="title_left">
          <h3>Laporan Transaksi</h3>
        </div>

        <div class="title_right">
          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">

          </div>
        </div>

      </div>

      <div class="clearfix"></div><br>

      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title" style="text-transform: capitalize;">
            <h2>Riwayat Transaksi <small></small></h2>

            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form action="?module=laporan-transaksi&aksi=nasabah" enctype="multipart/form-data" method="POST">
              <label for="nama">No Rekening * :</label>
              <input type="text" class="typeahead form-control" placeholder="Tulis Nomor Rekening anda..." name="no_rekening" required /><br>
              <label for="nama">Periode :</label>
              <div class="well" style="overflow: auto">
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 8px;">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                    <input type="text" class="form-control " value="<?php echo date("d-m-Y"); ?>" id="tanggal3" name="tanggal1">
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 8px;">
                  <p style="text-align: center;">Sampai</p>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 8px;">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                    <input type="text" class="form-control " value="<?php echo date("d-m-Y"); ?>" id="tanggal4" name="tanggal2">
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 8px;">
                  <button type="submit" class="btn btn-success btn-sm">Submit</button>

            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  <!-- /page content -->


<?php
} elseif ($_GET['aksi'] == 'nasabah') {
  $id = $_POST['no_rekening'];
  $query_rek = mysqli_query($conn, "SELECT * FROM nasabah WHERE no_rekening='$id'");
  $r = mysqli_fetch_array($query_rek);

?>



<?php   } elseif ($_GET['aksi'] == 'simpan_edit') {

  $module = $_GET['module'];
  mysqli_query($conn, "UPDATE nasabah SET no_rekening = '$_POST[no_rekening]',
                                    nama = '$_POST[nama]',
                                    alamat = '$_POST[alamat]',
                                    tempat_lahir = '$_POST[tempat_lahir]',
                                    tanggal_lahir = '$_POST[tanggal_lahir]',
                                    orang_tua = '$_POST[orang_tua]',
                                    status = '$_POST[status]' 
                                    WHERE id_nasabah = '$_POST[id]'");
  echo "<script language='javascript'>
        document.location='?module=" . $module . "';
        </script>";
} elseif ($_GET['aksi'] == 'hapus') {
  $module = $_GET['module'];
  $idd = $_GET[id];

  $id = decrypt($idd);
  $query = mysqli_query($conn, "Delete FROM nasabah WHERE id_nasabah='$id'");
  echo "<script language='javascript'>document.location='?module=" . $module . "';</script>";
} ?>



<!-- Modal Popup untuk delete-->
<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Apakah anda yakin menghapus data ini ?</h4>
      </div>

      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger btn-sm" id="delete_link">Hapus</a>
        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>