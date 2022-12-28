<?php
include '../../config/conn.php';
if ($_GET['aksi'] == '') {

  $query_saldo = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi");
  $row_saldo = mysqli_fetch_array($query_saldo);
  $saldo_keseluruhan = $row_saldo['jumlah_debit'] - $row_saldo['jumlah_kredit'];


?>
  <!-- page content -->
  <div class="col" role="main">
    <div class="">
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12">
          <div class="x_panel">
            <div class="x_title" style="text-transform: capitalize;">
              <h2>Data <?php echo $_GET['module']; ?> <small></small></h2>

              <div class="clearfix"></div>
            </div>
            <div class="col-md-9 col-sm-12 col-xs-12">
              <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAdd"><i class="glyphicon glyphicon-save-file"></i> Setoran Tunai</a>
              <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#tarikAdd"><i class="glyphicon glyphicon-open-file"></i> Penarikan Tunai</a>
            </div>
            <div class="col-md-3 col-sm-12 col-xs-12" style="margin-left: 0px;">
              <h4><small>Saldo : </small>Rp. <?php echo rupiah($saldo_keseluruhan); ?></h4>
            </div>
            <div class="x_content">

              <table id="datatable" class="table table-bordered">
                <thead>
                  <tr>
                    <th width="20">Tipe</th>
                    <th>Tanggal</th>
                    <th>No Transaksi</th>
                    <th>Nasabah</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th width="110">Saldo</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 0;
                  $query = mysqli_query($conn, "SELECT * FROM transaksi JOIN nasabah ON transaksi.id_nasabah=nasabah.id_nasabah order by id_transaksi asc ");

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
                      <td><?php echo $row['nama']; ?></td>

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
  </div>
  </div>
  </div>
  <!-- /page content -->






  <?php } elseif ($_GET['aksi'] == 'setoran_tunai') {

  if (isset($_POST['tunai'])) {

    if (empty($_POST['kredit'])) {
      mysqli_query($conn, "INSERT INTO transaksi(id_transaksi,
                                  id_nasabah,
                                  tanggal,
                                  debit,
                                  kredit,
                                  keterangan) VALUES('$_POST[id]',
                                                 '$_POST[id_nasabah]',
                                                 '$_POST[tanggal]',
                                                 '$_POST[debit]',
                                                 '0',
                                                 '$_POST[keterangan]')");


      $query_saldo = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE id_nasabah ='$_POST[id_nasabah]'");
      $saldo = mysqli_fetch_array($query_saldo);
      $saldoo = $saldo['jumlah_debit'] - $saldo['jumlah_kredit'];
      mysqli_query($conn, "UPDATE nasabah SET saldo = '$saldoo'
                                    WHERE id_nasabah = '$_POST[id_nasabah]'");
    } else {
      mysqli_query($conn, "INSERT INTO transaksi(id_transaksi,
                                  id_nasabah,
                                  tanggal,
                                  debit,
                                  kredit,
                                  keterangan) VALUES('$_POST[id]',
                                                 '$_POST[id_nasabah]',
                                                 '$_POST[tanggal]',
                                                 '0',
                                                 '$_POST[kredit]',
                                                 '$_POST[keterangan]')");

      $query_saldo = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE id_nasabah ='$_POST[id_nasabah]'");
      $saldo = mysqli_fetch_array($query_saldo);
      $saldoo = $saldo['jumlah_debit'] - $saldo['jumlah_kredit'];

      mysqli_query($conn, "UPDATE nasabah SET saldo = '$saldoo'
                                    WHERE id_nasabah = '$_POST[id_nasabah]'");
    }




    echo "<script language='javascript'>document.location='?module=transaksi';</script>";
  } else {

    $id = $_POST['no_rekening'];
    $query = mysqli_query($conn, "SELECT * FROM nasabah WHERE no_rekening='$id'");
    $r = mysqli_fetch_array($query);
    $cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM nasabah WHERE no_rekening='$_POST[no_rekening]'"));
    if ($cek == 0) {
      echo "<script>window.alert('Nomor Rekening Tidak ada !')
    window.location='?module=transaksi'</script>";
    } else {
  ?>
      <!-- page content -->
      <div class="col" role="main">
        <div class="">
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title" style="text-transform: capitalize;">
                  <h2>Setoran Tunai</h2>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form action="?module=transaksi&aksi=setoran_tunai" enctype="multipart/form-data" method="POST">
                    <div class="row">
                      <div class="col-md-6">
                        <?php
                        $query = "SELECT max(id_transaksi) as maxID FROM transaksi ";
                        $hasil = mysqli_query($conn, $query);
                        $data = @mysqli_fetch_array($hasil);
                        $idMax = $data['maxID'];

                        $noUrut = (int) substr($idMax, 1, 9);
                        $noUrut++;
                        $char = "T";
                        $newID = $char . sprintf("%04s", $noUrut);
                        ?>
                        <label for="id">ID Transaksi :</label>
                        <input type="text" class="form-control" disabled value="<?php echo $newID; ?>" />
                        <input type="hidden" class="form-control" name="id" value="<?php echo $newID; ?>" />


                        <label for="nama">Nomor Rekening :</label>
                        <input type="hidden" class="form-control" name="id_nasabah" value="<?php echo $r['id_nasabah']; ?>" />
                        <input type="text" disabled class="form-control" value="<?php echo $r['no_rekening']; ?>" />

                        <label for="alamat">Nama :</label>
                        <input class="form-control" disabled value="<?php echo $r['nama']; ?>">

                        <label for="telephone">Tempat, Tanggal Lahir :</label>
                        <input type="text" disabled class="form-control" value="<?php echo $r['tempat_lahir']; ?>, <?php echo $r['tanggal_lahir']; ?>" />
                        <input type="hidden" class="form-control" name="tanggal" value="<?php echo date('Y-m-d'); ?>" />


                        <label for="username">Alamat :</label>
                        <input type="text" disabled class="form-control" value="<?php echo $r['alamat']; ?>" disabled />

                        <label for="password">Orang Tua :</label>
                        <input type="text" class="form-control" value="<?php echo $r['orang_tua']; ?>" disabled />

                      </div>
                      <div class="col-md-6">

                        <label for="password">Saldo :</label>
                        <?php
                        $query_saldo = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE id_nasabah ='" . $r['id_nasabah'] . "'");
                        $saldo = mysqli_fetch_array($query_saldo);
                        $saldoo = $saldo['jumlah_debit'] - $saldo['jumlah_kredit'];
                        ?>
                        <h3>Rp. <?php echo rupiah($saldoo); ?></h3>

                        <label for="password">Saldo Bulan ini :</label>
                        <?php
                        $bulan = date('m');
                        $query_bulan = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE DATE_FORMAT((tanggal),'%m') like '%$bulan%' AND id_nasabah ='" . $r['id_nasabah'] . "'");
                        $saldo_bulan = mysqli_fetch_array($query_bulan);
                        $saldo_b = $saldo_bulan['jumlah_debit'] - $saldo_bulan['jumlah_kredit'];
                        ?>
                        <h3>Rp. <?php echo rupiah($saldo_b); ?></h3>

                        <label for="password">Jumlah Setoran :</label>
                        <input type="hidden" class="form-control" name="kredit" />
                        <input type="text" class="form-control" name="debit" autofocus=”autofocus” autocomplete="off" />



                        <label for="alamat">Keterangan :</label>
                        <textarea class="form-control" name="keterangan"></textarea>

                      </div>

                    </div>


                    <div class="ln_solid"></div>
                    <div class="form-group">
                      <button type="button" class="btn btn-default btn-sm" onclick=self.history.back()>Batal</button>
                      <button type="submit" name="tunai" class="btn btn-success btn-sm">Simpan</button>
                      <br>
                    </div>
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
      <!-- /page content -->





    <?php }
  }
} elseif ($_GET['aksi'] == 'penarikan_tunai') {

  if (isset($_POST['tarik'])) {

    if (empty($_POST['kredit'])) {
      mysqli_query($conn, "INSERT INTO transaksi(id_transaksi,
                                  id_nasabah,
                                  tanggal,
                                  debit,
                                  kredit,
                                  keterangan) VALUES('$_POST[id]',
                                                 '$_POST[id_nasabah]',
                                                 '$_POST[tanggal]',
                                                 '$_POST[debit]',
                                                 '0',
                                                 '$_POST[keterangan]')");


      $query_saldo = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE id_nasabah ='$_POST[id_nasabah]'");
      $saldo = mysqli_fetch_array($query_saldo);
      $saldoo = $saldo['jumlah_debit'] - $saldo['jumlah_kredit'];
      mysqli_query($conn, "UPDATE nasabah SET saldo = '$saldoo'
                                    WHERE id_nasabah = '$_POST[id_nasabah]'");
    } else {
      mysqli_query($conn, "INSERT INTO transaksi(id_transaksi,
                                  id_nasabah,
                                  tanggal,
                                  debit,
                                  kredit,
                                  keterangan) VALUES('$_POST[id]',
                                                 '$_POST[id_nasabah]',
                                                 '$_POST[tanggal]',
                                                 '0',
                                                 '$_POST[kredit]',
                                                 '$_POST[keterangan]')");

      $query_saldo = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE id_nasabah ='$_POST[id_nasabah]'");
      $saldo = mysqli_fetch_array($query_saldo);
      $saldoo = $saldo['jumlah_debit'] - $saldo['jumlah_kredit'];

      mysqli_query($conn, "UPDATE nasabah SET saldo = '$saldoo'
                                    WHERE id_nasabah = '$_POST[id_nasabah]'");
    }




    echo "<script language='javascript'>document.location='?module=transaksi';</script>";
  } else {


    $id = $_POST['no_rekening'];
    $query = mysqli_query($conn, "SELECT * FROM nasabah WHERE no_rekening='$id'");
    $r = mysqli_fetch_array($query);

    $cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM nasabah WHERE no_rekening='$_POST[no_rekening]'"));
    if ($cek == 0) {
      echo "<script>window.alert('Nomor Rekening Tidak ada !')
    window.location='?module=transaksi'</script>";
    } else {

    ?>

      <!-- page content -->
      <div class="col" role="main">
        <div class="">
          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title" style="text-transform: capitalize;">
                  <h2>Penarikan Tunai</h2>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form action="?module=transaksi&aksi=penarikan_tunai" enctype="multipart/form-data" method="POST">
                    <div class="row">
                      <div class="col-md-6">
                        <?php
                        $query = "SELECT max(id_transaksi) as maxID FROM transaksi ";
                        $hasil = mysqli_query($conn, $query);
                        $data = @mysqli_fetch_array($hasil);
                        $idMax = $data['maxID'];

                        $noUrut = (int) substr($idMax, 1, 9);
                        $noUrut++;
                        $char = "T";
                        $newID = $char . sprintf("%04s", $noUrut);
                        ?>
                        <label for="id">ID Transaksi :</label>
                        <input type="text" class="form-control" disabled value="<?php echo $newID; ?>" />
                        <input type="hidden" class="form-control" name="id" value="<?php echo $newID; ?>" />


                        <label for="nama">Nomor Rekening :</label>
                        <input type="hidden" class="form-control" name="id_nasabah" value="<?php echo $r['id_nasabah']; ?>" />
                        <input type="hidden" class="form-control" name="no_rekening" value="<?php echo $r['no_rekening']; ?>" />
                        <input type="text" disabled class="form-control" value="<?php echo $r['no_rekening']; ?>" />

                        <label for="alamat">Nama :</label>
                        <input class="form-control" disabled value="<?php echo $r['nama']; ?>">

                        <label for="telephone">Tempat, Tanggal Lahir :</label>
                        <input type="text" disabled class="form-control" value="<?php echo $r['tempat_lahir']; ?>, <?php echo $r['tanggal_lahir']; ?>" />
                        <input type="hidden" class="form-control" name="tanggal" value="<?php echo date('Y-m-d'); ?>" />


                        <label for="username">Alamat :</label>
                        <input type="text" disabled class="form-control" value="<?php echo $r['alamat']; ?>" disabled />

                        <label for="password">Orang Tua :</label>
                        <input type="text" class="form-control" value="<?php echo $r['orang_tua']; ?>" disabled />

                      </div>
                      <div class="col-md-6">

                        <label for="password">Saldo :</label>
                        <?php
                        $query_saldo = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE id_nasabah ='" . $r['id_nasabah'] . "'");
                        $saldo = mysqli_fetch_array($query_saldo);
                        $saldoo = $saldo['jumlah_debit'] - $saldo['jumlah_kredit'];
                        ?>
                        <h3>Rp. <?php echo rupiah($saldoo); ?></h3>

                        <label for="password">Saldo Bulan ini :</label>
                        <?php
                        $bulan = date('m');
                        $query_bulan = mysqli_query($conn, "SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE DATE_FORMAT((tanggal),'%m') like '%$bulan%' AND id_nasabah ='" . $r['id_nasabah'] . "'");
                        $saldo_bulan = mysqli_fetch_array($query_bulan);
                        $saldo_b = $saldo_bulan['jumlah_debit'] - $saldo_bulan['jumlah_kredit'];
                        ?>
                        <h3>Rp. <?php echo rupiah($saldo_b); ?></h3>

                        <label for="password">Jumlah Penarikan :</label>
                        <input type="text" class="form-control" name="kredit" autofocus=”autofocus” autocomplete="off" />
                        <input type="hidden" class="form-control" name="debit" />

                        <label for="alamat">Keterangan :</label>
                        <textarea class="form-control" name="keterangan"></textarea>

                      </div>

                    </div>


                    <div class="ln_solid"></div>
                    <div class="form-group">

                      <button type="button" class="btn btn-default btn-sm" onclick=self.history.back()>Batal</button>
                      <button type="submit" name="tarik" class="btn btn-success btn-sm">Simpan</button>

                      <br>
                    </div>
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
      <!-- /page content -->


<?php }
  }
} ?>

<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Setoran Tunai</h4>
      </div>
      <div class="modal-body">

        <form action="?module=transaksi&aksi=setoran_tunai" class="form-horizontal form-label-left" method="POST">

          <div class="form-group">
            <div class="col-sm-12 col-sm-12 col-xs-12 ">
              <div class="input-group">
                <input type="text" class="typeahead form-control" placeholder="Tulis Nomor Rekening" required name="no_rekening" autofocus=”autofocus” autocomplete="off">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Cari</button>
                </span>

              </div>

            </div>
          </div>
        </form>

      </div>

      <!-- end form for validations -->
    </div>
  </div>
</div>
<!-- /modal -->


<!-- Modal -->
<div class="modal fade" id="tarikAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Penarikan Tunai</h4>
      </div>
      <div class="modal-body">

        <form action="?module=transaksi&aksi=penarikan_tunai" class="form-horizontal form-label-left" method="POST">

          <div class="form-group">
            <div class="col-sm-12 ">
              <div class="input-group">
                <input type="text" class="typeahead form-control" placeholder="Tulis Nomor Rekening" required name="no_rekening" autofocus=”autofocus” autocomplete="off">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-danger"><i class="fa fa-search"></i> Cari</button>
                </span>

              </div>

            </div>
          </div>
        </form>

      </div>

      <!-- end form for validations -->
    </div>
  </div>
</div>
<!-- /modal -->