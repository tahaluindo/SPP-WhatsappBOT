<style>
  .pink-textarea textarea.md-textarea:focus:not([readonly]) {
    border-bottom: 1px solid #f48fb1;
    box-shadow: 0 1px 0 0 #f48fb1;
  }

  .active-pink-textarea.md-form label.active {
    color: #f48fb1;
  }

  .active-pink-textarea.md-form textarea.md-textarea:focus:not([readonly])+label {
    color: #f48fb1;
  }


  .amber-textarea textarea.md-textarea:focus:not([readonly]) {
    border-bottom: 1px solid #ffa000;
    box-shadow: 0 1px 0 0 #ffa000;
  }

  .active-amber-textarea.md-form label.active {
    color: #ffa000;
  }

  .active-amber-textarea.md-form textarea.md-textarea:focus:not([readonly])+label {
    color: #ffa000;
  }


  .active-pink-textarea-2 textarea.md-textarea {
    border-bottom: 1px solid #f48fb1;
    box-shadow: 0 1px 0 0 #f48fb1;
  }

  .active-pink-textarea-2.md-form label.active {
    color: #f48fb1;
  }

  .active-pink-textarea-2.md-form label {
    color: #f48fb1;
  }

  .active-pink-textarea-2.md-form textarea.md-textarea:focus:not([readonly])+label {
    color: #f48fb1;
  }


  .active-amber-textarea-2 textarea.md-textarea {
    border-bottom: 1px solid #ffa000;
    box-shadow: 0 1px 0 0 #ffa000;
  }

  .active-amber-textarea-2.md-form label.active {
    color: #ffa000;
  }

  .active-amber-textarea-2.md-form label {
    color: #ffa000;
  }

  .active-amber-textarea-2.md-form textarea.md-textarea:focus:not([readonly])+label {
    color: #ffa000;
  }
</style>

<?php if ($_GET['act'] == '') {
  $query_selesai = mysqli_query($conn, "SELECT *  FROM project where status='Selesai'");
  $num_selesai = mysqli_num_rows($query_selesai);

  $query_proses = mysqli_query($conn, "SELECT *  FROM project where status='Proses'");
  $num_proses = mysqli_num_rows($query_proses);

  $query_pending = mysqli_query($conn, "SELECT *  FROM project where status='Pending'");
  $num_pending = mysqli_num_rows($query_pending);

  $query_batal = mysqli_query($conn, "SELECT *  FROM project where status='Batal'");
  $num_batal = mysqli_num_rows($query_batal);

?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
      </div><!-- /.box-header -->
      <div class="box-body">
        <?php
        if (isset($_GET['sukses'])) {
          echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil Di Proses,..
                          </div>";
        } elseif (isset($_GET['gagal'])) {
          echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data tidak Di Proses, terjadi kesalahan dengan data..
                          </div>";
        } elseif (isset($_GET['sukseshapus'])) {
          echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Berhasil!</strong> - Data Berhasil dihapus.....
                          </div>";
        } elseif (isset($_GET['gagalhapus'])) {
          echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data ini telah digunakan oleh data lain, sehingga tidak bida dihapus!!
                          </div>";
        }


        ?>

        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active">
            <li class="active"><a href="#tab_1" data-toggle="tab">Hosting</a></li>
            <li><a href="#tab_2" data-toggle="tab">Domain </a></li>
          </ul>
          <div class="tab-content">

            <!-- List Tagihan Bulanan -->
            <div class="tab-pane active" id="tab_1">
              <div class="box-body table-responsive">
                <form method="GET" action="" class="form-horizontal">
                  <input type="hidden" name="view" value="keuangan_project" />
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td>
                          <span class="pull-right">
                            <a class=' btn btn-primary btn-sm' href='?view=keuangan_hosting&act=tambah'><span class="fa fa-plus faa-bounce animated"></span> Tambahkan Data</a>
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Link</th>
                      <th>Supplier</th>
                      <th>Tanggal Ditagih </th>
                      <th>Tanggal Jatuh Tempo</th>
                      <th>Tanggal Berakhir</th>
                      <th>Harga</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_POST['ganti'])) {
                      $query = mysqli_query($conn, "UPDATE project SET  status='$_POST[link]'
                      where idHosting = '$_POST[id]'");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_hosting&sukses';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_hosting&gagal';</script>";
                      }
                    }
                    $no = 1;
                    $sekarang    = date("Y-m-d");
                    $tampils = mysqli_query($conn, "SELECT hosting.*, DATE_ADD(tglAkhir, INTERVAL 3 DAY) 
                as jatuh_tempo, DATEDIFF(DATE_ADD(tglAkhir, INTERVAL 3 DAY), CURDATE()), idHosting,harga,nmMitra,tglAkhir FROM hosting 
                    INNER JOIN mitra ON hosting.idMitra=mitra.id ");
                    while ($r = mysqli_fetch_array($tampils)) {
                      $tgl1 = new DateTime($sekaranag);
                      $tgl2 = new DateTime($r['tglAkhir']);
                      $diff  = date_diff($tgl1, $tgl2);
                      echo "<tr>
                        <td>$no</td>
                        <td><a class='btn btn-primary btn-xs' title='Bayar' href='$r[link]' target='_blank'><span class='fa fa-code-fork'></span>  $r[link]</a>
                              </td>
                              <td >" . $r['supplier'] . "</td>
                        <td> $diff->y tahun $diff->m bulan, $diff->d  hari lagi</td>
                        <td>" . tgl_indo($r['tglAkhir']) . "</td>
                        <td>" . tgl_indo($r['jatuh_tempo']) . "</td>
                        <td>" . buatRp($r['harga']) . "</td>
                        <td>
                        <a class='btn btn-success btn-xs' title='Edit Data' href='?view=keuangan_hosting&act=edit&id=$r[idHosting]'><span class='glyphicon glyphicon-edit'></span>Edit</a>
                        <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=keuangan_hosting&hapus&id=$r[idHosting]' onclick=\"return confirm('Menghapus data project, juga menghapus data item di dalamnya, Apa anda yakin?')\"><span class='glyphicon glyphicon-remove'></span>Hapus</a>
                        </td>";
                      echo "</tr>";
                      $no++;
                    }
                    if (isset($_GET['hapus'])) {
                      $query = mysqli_query($conn, "DELETE FROM hosting where idHosting='$_GET[id]'");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_hosting&sukseshapus';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_hosting&gagalhapus';</script>";
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- End List Tagihan Bulanan -->
            <div class="tab-pane" id="tab_2">
              <!-- List Tagihan Lainnya (Bebas) -->
              <div class="box-body table-responsive">
                <form method="GET" action="" class="form-horizontal">
                  <input type="hidden" name="view" value="keuangan_project" />
                  <table class="table table-striped">
                    <tbody>
                      <tr>
                        <td>
                          <span class="pull-right">
                            <a class=' btn btn-primary btn-sm' href='?view=keuangan_hosting&act=tambahs'><span class="fa fa-plus faa-bounce animated"></span> Tambahkan Data</a>
                          </span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Link</th>
                      <th>Supplier</th>
                      <th>Tanggal Ditagih </th>
                      <th>Tanggal Jatuh Tempo</th>
                      <th>Tanggal Berakhir</th>
                      <th>Harga</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_POST['ganti'])) {
                      $query = mysqli_query($conn, "UPDATE project SET  status='$_POST[link]'
                      where idHosting = '$_POST[id]'");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_hosting&sukses';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_hosting&gagal';</script>";
                      }
                    }
                    $no = 1;
                    $sekarang    = date("Y-m-d");
                    $tampils = mysqli_query($conn, "SELECT domain.*, DATE_ADD(tglAkhir, INTERVAL 3 DAY) 
                     as jatuh_tempo, DATEDIFF(DATE_ADD(tglAkhir, INTERVAL 3 DAY), CURDATE()), idHosting,harga,nmMitra,tglAkhir FROM domain 
                    INNER JOIN mitra ON domain.idMitra=mitra.id ");
                    while ($r = mysqli_fetch_array($tampils)) {
                      $tgl1 = new DateTime($sekaranag);
                      $tgl2 = new DateTime($r['tglAkhir']);
                      $diff  = date_diff($tgl1, $tgl2);
                      echo "<tr>
                        <td>$no</td>
                        <td><a class='btn btn-warning btn-xs' title='Bayar' href='$r[link]' target='_blank'><span class='fa fa-code-fork'></span>  $r[link]</a>
                              </td>
                                 <td >" . $r['supplier'] . "</td>
                        <td > $diff->y tahun $diff->m bulan, $diff->d  hari lagi</td>
                        <td >" . tgl_indo($r['tglAkhir']) . "</td>
                        <td >" . tgl_indo($r['jatuh_tempo']) . "</td>
                        <td >" . buatRp($r['harga']) . "</td>
                        <td>
                        <a class='btn btn-success btn-xs' title='Edit Data' href='?view=keuangan_hosting&act=edits&id=$r[idHosting]'><span class='glyphicon glyphicon-edit'></span>Edit</a>
                        <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=keuangan_hosting&hapuss&id=$r[idHosting]' onclick=\"return confirm('Menghapus data project, juga menghapus data item di dalamnya, Apa anda yakin?')\"><span class='glyphicon glyphicon-remove'></span>Hapus</a>
                        </td>";
                      echo "</tr>";
                      $no++;
                    }
                    if (isset($_GET['hapuss'])) {
                      $query = mysqli_query($conn, "DELETE FROM domain where idHosting='$_GET[id]'");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_hosting&sukseshapus';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_hosting&gagalhapus';</script>";
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php
    } elseif ($_GET['act'] == 'onoff') {
      $a = $_GET['a'];
      $query = mysqli_query($conn, "UPDATE project SET status='$a' where idHosting = '$_GET[id]'");

      if ($query) {
        echo "<script>document.location='index.php?view=keuangan_hosting';</script>";
      } else {
        echo "<script>document.location='index.php?view=keuangan_hosting';</script>";
      }
    } elseif ($_GET['act'] == 'edit') {
      if (isset($_POST['update'])) {
        $query = mysqli_query($conn, "UPDATE hosting SET idMitra='$_POST[idMitra]',link='$_POST[link]',
                        harga='$_POST[harga]' ,tglAkhir='$_POST[tglAkhir]',supplier='$_POST[supplier]'
										 where idHosting='$_POST[id]'");
        if ($query) {
          echo "<script>document.location='?view=keuangan_hosting&sukses';</script>";
        } else {
          echo "<script>document.location='?view=keuangan_hosting&gagal';</script>";
        }
      }
      $edit = mysqli_query($conn, "SELECT * FROM hosting where idHosting='$_GET[id]'");
      $record = mysqli_fetch_array($edit);
      ?>

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> Edit Data Hosting</h3>
            </div><!-- /.box-header -->

            <div class="box-body">
              <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="id" class="form-control" value="<?php echo $record['idHosting']; ?>" required>
                <div class="col-md-6">
                  <label for="" class="control-label">Mitra </label>
                  <select id="kelas" name='idMitra' class="form-control">
                    <option value="" selected> - Pilih Client - </option>
                    <?php
                    $sqk = mysqli_query($conn, "SELECT * FROM mitra ORDER BY id ASC");
                    while ($k = mysqli_fetch_array($sqk)) {
                      $selected = ($k['id'] == $record['idMitra']) ? ' selected="selected"' : "";
                      echo '<option value="' . $k['id'] . '" ' . $selected . '>' . $k['nmMitra'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="" class=" control-label">Link</label>
                  <input type="text" name="link" class="form-control" value="<?php echo $record['link']; ?>" required>
                </div>
                <div class="col-md-6">
                  <label for="" class=" control-label">Supplier</label>
                  <input type="text" name="supplier" class="form-control" value="<?php echo $record['supplier']; ?>" required>
                </div>
                <div class="col-md-6">
                  <label for="" class=" control-label">Tanggal Akhir</label>
                  <input type="text" name="tglAkhir" class="form-control pull-right date-picker" id="" value="<?php echo $record['tglAkhir']; ?>" required>
                </div>
                <div class="col-md-6">
                  <label for="" class=" control-label">Harga</label>
                  <input type="text" name="harga" class="form-control" value="<?php echo $record['harga']; ?>" required>
                </div>
            </div>
            <br>
            <div class="box-body">
              <div class="form-group">
                <label for="" class="col-sm-2 control-label"></label>
                <div class="col-sm-12">
                  <input type="submit" name="update" value="Update" class="btn btn-success pull-right">
                  <a href="?view=keuangan_hosting" class="btn btn-default pull-left">Cancel</a>
                </div>
              </div>
              </form>


            </div>

          </div>
        </div>

      <?php
    } elseif ($_GET['act'] == 'edits') {
      if (isset($_POST['update'])) {

        $query = mysqli_query($conn, "UPDATE domain SET idMitra='$_POST[idMitra]',link='$_POST[link]',
                        harga='$_POST[harga]' ,tglAkhir='$_POST[tglAkhir]',supplier='$_POST[supplier]'
										 where idHosting='$_POST[id]'");
        if ($query) {
          echo "<script>document.location='?view=keuangan_hosting&sukses';</script>";
        } else {
          echo "<script>document.location='?view=keuangan_hosting&gagal';</script>";
        }
      }
      $edit = mysqli_query($conn, "SELECT * FROM domain where idHosting='$_GET[id]'");
      $record = mysqli_fetch_array($edit);
      ?>

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> Edit Data Domain</h3>
            </div><!-- /.box-header -->

            <div class="box-body">
              <form method="post" action="" class="form-horizontal">
                <input type="hidden" name="id" class="form-control" value="<?php echo $record['idHosting']; ?>" required>
                <div class="col-md-6">
                  <label for="" class="control-label">Mitra </label>
                  <select id="kelas" name='idMitra' class="form-control">
                    <option value="" selected> - Pilih Client - </option>
                    <?php
                    $sqk = mysqli_query($conn, "SELECT * FROM mitra ORDER BY id ASC");
                    while ($k = mysqli_fetch_array($sqk)) {
                      $selected = ($k['id'] == $record['idMitra']) ? ' selected="selected"' : "";
                      echo '<option value="' . $k['id'] . '" ' . $selected . '>' . $k['nmMitra'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="" class=" control-label">Link</label>
                  <input type="text" name="link" class="form-control" value="<?php echo $record['link']; ?>" required>
                </div>
                <div class="col-md-6">
                  <label for="" class=" control-label">Supplier</label>
                  <input type="text" name="supplier" class="form-control" value="<?php echo $record['supplier']; ?>" required>
                </div>
                <div class="col-md-6">
                  <label for="" class=" control-label">Tanggal Akhir</label>
                  <input type="text" name="tglAkhir" class="form-control pull-right date-picker" id="" value="<?php echo $record['tglAkhir']; ?>" required>
                </div>
                <div class="col-md-6">
                  <label for="" class=" control-label">Harga</label>
                  <input type="text" name="harga" class="form-control" value="<?php echo $record['harga']; ?>" required>
                </div>
            </div>
            <br>
            <div class="box-body">
              <div class="form-group">
                <label for="" class="col-sm-2 control-label"></label>
                <div class="col-sm-12">
                  <input type="submit" name="update" value="Update" class="btn btn-success pull-right">
                  <a href="?view=keuangan_hosting" class="btn btn-default pull-left">Cancel</a>
                </div>
              </div>
              </form>


            </div>

          </div>
        </div>
      <?php
    } elseif ($_GET['act'] == 'tambah') {
      if (isset($_POST['tambah'])) {
        $query = mysqli_query($conn, "INSERT INTO hosting(idMitra,link,tglAkhir,harga,supplier) 
    VALUES('$_POST[idMitra]','$_POST[link]','$_POST[tglAkhir]','$_POST[harga]','$_POST[supplier]')");
        if ($query) {
          echo "<script>document.location='?view=keuangan_hosting&sukses';</script>";
        } else {
          echo "<script>document.location='?view=keuangan_hosting&gagal';</script>";
        }
      }
      ?>

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> Tambah Data Hosting </h3>
            </div><!-- /.box-header -->
            <div class="box-body">

              <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data" method="POST">

                <div class="form-group">


                  <div class="col-md-4">
                    <label for="" class="control-label">Mitra </label>

                    <select id="kelas" name='idMitra' class="form-control">
                      <option value="" selected> - Pilih Mitra - </option>

                      <?php
                      $sqk = mysqli_query($conn, "SELECT * FROM mitra ORDER BY id ASC");
                      while ($k = mysqli_fetch_array($sqk)) {
                        echo "<option value=" . $k['id'] . ">" . $k['nmMitra'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label for="" class=" control-label">Link</label>
                    <input type="text" name="link" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label for="" class=" control-label">Supplier</label>
                    <input type="text" name="supplier" class="form-control" required>
                  </div>
                  <div class="col-md-4">
                    <label for="" class=" control-label">Tanggal Akhir </label>
                    <input type="date" name="tglAkhir" class="form-control" id="" value="<?php echo date('Y-m-d'); ?>" required>
                  </div>

                  <div class="col-md-4">
                    <label for="" class=" control-label">Harga</label>
                    <input type="text" name="harga" class="form-control" id="" placeholder="Harga" required>
                  </div>


                </div>



                <div class="form-group">
                  <label for="" class="col-sm-2 control-label"></label>
                  <div class="col-sm-12">
                    <input type="submit" name="tambah" value="Simpan" class="btn btn-success pull-right">
                    <a href="?view=keuangan_hosting" class="btn btn-default pull-left">Cancel</a>
                  </div>
                </div>
              </form>

            </div>
          </div>
        <?php
      } elseif ($_GET['act'] == 'tambahs') {
        if (isset($_POST['tambah'])) {
          $query = mysqli_query($conn, "INSERT INTO domain(idMitra,link,tglAkhir,harga,supplier) 
    VALUES('$_POST[idMitra]','$_POST[link]','$_POST[tglAkhir]','$_POST[harga]','$_POST[supplier]')");
          if ($query) {
            echo "<script>document.location='?view=keuangan_hosting&sukses';</script>";
          } else {
            echo "<script>document.location='?view=keuangan_hosting&gagal';</script>";
          }
        }
        ?>

          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"> Tambah Data Domain </h3>
              </div><!-- /.box-header -->
              <div class="box-body">

                <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data" method="POST">

                  <div class="form-group">


                    <div class="col-md-4">
                      <label for="" class="control-label">Mitra </label>

                      <select id="kelas" name='idMitra' class="form-control">
                        <option value="" selected> - Pilih Mitra - </option>

                        <?php
                        $sqk = mysqli_query($conn, "SELECT * FROM mitra ORDER BY id ASC");
                        while ($k = mysqli_fetch_array($sqk)) {
                          echo "<option value=" . $k['id'] . ">" . $k['nmMitra'] . "</option>";
                        }
                        ?>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label for="" class=" control-label">Link</label>
                      <input type="text" name="link" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label for="" class=" control-label">Supplier</label>
                      <input type="text" name="supplier" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                      <label for="" class=" control-label">Tanggal Akhir </label>
                      <input type="date" name="tglAkhir" class="form-control" id="" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="col-md-4">
                      <label for="" class=" control-label">Harga</label>
                      <input type="text" name="harga" class="form-control" id="" placeholder="Harga" required>
                    </div>


                  </div>



                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label"></label>
                    <div class="col-sm-12">
                      <input type="submit" name="tambah" value="Simpan" class="btn btn-success pull-right">
                      <a href="?view=keuangan_hosting" class="btn btn-default pull-left">Cancel</a>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          <?php
        }
          ?>