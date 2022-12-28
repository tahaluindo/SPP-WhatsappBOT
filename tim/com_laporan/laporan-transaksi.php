<?php
include '../../config/koneksi.php';
include 'config/rupiah.php';
include '../../config/fungsi_indotgl.php';

$aksi = "application/com_nasabah/nasabah_aksi.php";
if ($_GET['aksi'] == '') {

  $apa = mysqli_query($conn,"SELECT * FROM siswa where nisnSiswa='$_SESSION[ids]'");
  $ra = mysqli_fetch_array($apa); ?>
  <!-- page content -->




  <div class="col-xs-12">
    <div class="box box-solid box-primary">
      <div class="box-header with-border">
        <h2>Riwayat Transaksi Anda <small></small></h2>

        <div class="form-group"></div>

        <div class="box-body">
          <form action="?view=laporan-transaksi&aksi=siswa" enctype="multipart/form-data" method="POST">

            <input type="hidden" class="typeahead form-control" placeholder="Tulis Nomor nisnSiswa..." name="nisnSiswa" disable value="<?php echo $ra['nisnSiswa']; ?>" /><br>
            <label for="nama">Periode :</label>
            <div class="well" style="overflow: auto">
              <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 8px;">
                <div class="input-group">
                  <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                  <input type="text" class="form-control date-picker" value="<?php echo date("Y-m-d"); ?>" id="tanggal3" name="tanggal1">
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 8px;">
                <h4 style="text-align: center;">
                  <font color=blue>Sampai
                </h4>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 8px;">
                <div class="input-group">
                  <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                  <input type="text" class="form-control date-picker" value="<?php echo date("Y-m-d"); ?>" id="tanggal4" name="tanggal2">
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
} elseif ($_GET['aksi'] == 'siswa') {
  $id = $_SESSION[ids];
  $query_rek = mysqli_query($conn,"SELECT * FROM siswa WHERE nisnSiswa='$id'");
  $r = mysqli_fetch_array($query_rek);

?>



  <div class="col-md-12">
    <!-- Advanced Tables -->
    <div class="box box-danger box-solid">
      <div class="box-header with-border">
        <!-- tools box -->
        <div class="pull-right box-tools">
          <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
            <i class="fa fa-minus"></i></button>
          <!--<a class="btn btn-success btn-sm pull-right" style="margin-right: 5px;" target="_blank" title="Cetak Slip" href="./slip_bebas_persiswa.php?tahun=<?php //echo $_GET['idTahunAjaran']; 
                                                                                                                                                                ?>&siswa=<?php //echo $_GET['nisSiswa']; 
                                                                                                                                                                                                              ?>"><span class="fa fa-print"></span> Cetak Semua Status Pembayaran</a>-->
        </div>
        <!-- /. tools -->
        <h3 class="box-title">Tagihan Lainnya</h3>
      </div><!-- /.box-header -->



      <form action="cetaks.php" target="_blank" enctype="multipart/form-data" method="GET">
        <input type="hidden" name="p" value="2">
        <input type="hidden" name="id" value="<?php echo $_SESSION[ids]; ?>">
        <input type="hidden" name="t1" value="<?php echo ($_POST[tanggal1]); ?>">
        <input type="hidden" name="t2" value="<?php echo ($_POST[tanggal2]); ?>">
        <br>
        <button type="submit" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button>
        <button type="button" class="btn btn-default btn-sm" onclick=self.history.back()>Batal</button>
      </form>




      <!-- /.box-header -->
      <div class="panel-body">
        <div class="table-responsive">
          <table id="example1" class="table table-responsive no-padding table-striped">
            <thead>
              <tr>
                <th width="20">Tipe</th>
                <th>Tanggal</th>
                <th>No Transaksi</th>
                <th>siswa</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th width="110">Saldo</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $tanggal1 = $_POST[tanggal1];
              $tanggal2 = $_POST[tanggal2];
              $tgl1 = date('Y-m-d', strtotime($tanggal1));
              $tgl2 = date('Y-m-d', strtotime($tanggal2));

              $no = 0;
              $query = mysqli_query($conn,"SELECT * FROM transaksi JOIN siswa ON transaksi.nisnSiswa=siswa.nisnSiswa WHERE (tanggal BETWEEN '$tgl1' AND '$tgl2') AND transaksi.nisnSiswa= '$r[nisnSiswa]' order by id_transaksi asc ");

              $count = 2;



              while ($row = mysqli_fetch_array($query)) {
                $no++;
              ?>

                <tr style="background: <?php if ($row['kredit'] == 0) { ?>
                          #defff1;
                          <?php } else { ?>
                            #feeeea;
                            <?php } ?>">
                  <td><?php if ($row['kredit'] == 0) { ?><a class="btn btn-success btn-xs"><i class="glyphicon glyphicon-save-file"></i></a> <?php } else { ?> <a class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-open-file"></i></a><?php } ?></td>
                  <td><?php echo $row['tanggal']; ?></td>
                  <td><?php echo $row['id_transaksi']; ?></td>
                  <td><?php echo $row['nmSiswa']; ?></td>

                  <?php if ($count == 1) { ?>

                    <td><?php echo "Rp." . rupiah($row['debit']); ?></td>
                    <td><?php echo "Rp." . rupiah($row['kredit']); ?></td>
                    <td>
                      <?php
                      $debit = $row['debit'];
                      $saldo = $row['debit'];
                      echo "Rp." . rupiah($saldo);
                      ?>
                    </td>

                    <?php } else {
                    if ($row['debit'] != 0) {
                    ?>
                      <td><?php echo "Rp." . rupiah($row['debit']); ?></td>
                      <td><?php echo "Rp." . rupiah($row['kredit']); ?></td>
                      <td>
                        <?php
                        $debit = $denit + $row['debit'];
                        $saldo = $saldo + $row['debit'];
                        echo "Rp." . rupiah($saldo);
                        ?>


                      <?php } else { ?>
                      <td><?php echo "Rp." . rupiah($row['debit']); ?></td>
                      <td><?php echo "Rp." . rupiah($row['kredit']); ?></td>
                      <td>
                    <?php
                      $kredit = $kredit + $row['kredit'];
                      $saldo = $saldo - $row['kredit'];
                      echo "Rp." . rupiah($saldo);
                    }
                  }
                  $count++
                    ?>

                </tr>

              <?php } ?>




            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  </div>
  </div>
  <!-- /page content -->
  </div><!-- /.box-header -->


<?php   } elseif ($_GET['aksi'] == 'simpan_edit') {

  $view = $_GET['view'];
  mysqli_query($conn,"UPDATE siswa SET nisnSiswa = '$_POST[nisnSiswa]',
                                    nmSiswa = '$_POST[nmSiswa]',
                                    alamatOrtuO = '$_POST[alamatOrtu]',
                                    tempat_lahir = '$_POST[tempat_lahir]',
                                    tanggal_lahir = '$_POST[tanggal_lahir]',
                                    orang_tua = '$_POST[orang_tua]',
                                    status = '$_POST[status]' 
                                    WHERE idSiswa = '$_POST[id]'");
  echo "<script language='javascript'>
        document.location='?view=" . $view . "';
        </script>";
} elseif ($_GET['aksi'] == 'hapus') {
  $view = $_GET['view'];
  $idd = $_GET[id];

  $id = decrypt($idd);
  $query = mysqli_query($conn,"Delete FROM siswa WHERE idSiswa='$id'");
  echo "<script language='javascript'>document.location='?view=" . $view . "';</script>";
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