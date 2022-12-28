<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Pos Bayar </h3>
        <a class='pull-right btn btn-primary btn-sm' href='index.php?view=posbayar&act=tambah'>Tambahkan Data</a>
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
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $tampil = mysqli_query($conn,"SELECT * FROM pos_bayar ORDER BY idPosBayar ASC");
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
              echo "<tr><td>$no</td>
                              <td>$r[nmPosBayar]</td>
                              <td>$r[ketPosBayar]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=posbayar&act=edit&id=$r[idPosBayar]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=posbayar&hapus&id=$r[idPosBayar]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
              echo "</tr>";
              $no++;
            }
            if (isset($_GET['hapus'])) {
              $query = mysqli_query($conn,"DELETE FROM pos_bayar where idPosBayar='$_GET[id]'");
              if ($query) {
                echo "<script>document.location='index.php?view=posbayar&sukseshapus';</script>";
              } else {
                echo "<script>document.location='index.php?view=posbayar&gagalhapus';</script>";
              }
            }

            ?>
          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
<?php
} elseif ($_GET['act'] == 'edit') {
  if (isset($_POST[update])) {

    $query = mysqli_query($conn,"UPDATE pos_bayar SET nmPosBayar='$_POST[nmPosBayar]', 
										 ketPosBayar='$_POST[ketPosBayar]' where idPosBayar = '$_POST[id]'");
    if ($query) {
      echo "<script>document.location='index.php?view=posbayar&sukses';</script>";
    } else {
      echo "<script>document.location='index.php?view=posbayar&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn,"SELECT * FROM pos_bayar where idPosBayar='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"> Edit Data Pos Bayar</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="post" action="" class="form-horizontal">
          <input type="hidden" name="id" value="<?php echo $record['idPosBayar']; ?>">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-4">
              <input type="text" name="nmPosBayar" class="form-control" value="<?php echo $record['nmPosBayar']; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-6">
              <input type="text" name="ketPosBayar" class="form-control" value="<?php echo $record['ketPosBayar']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              <input type="submit" name="update" value="Update" class="btn btn-success">
              <a href="index.php?view=posbayar" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST[tambah])) {
    $query = mysqli_query($conn,"INSERT INTO pos_bayar(nmPosBayar,ketPosBayar) VALUES('$_POST[nmPosBayar]','$_POST[ketPosBayar]')");
    if ($query) {
      echo "<script>document.location='index.php?view=posbayar&sukses';</script>";
    } else {
      echo "<script>document.location='index.php?view=posbayar&gagal';</script>";
    }
  }
?>
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"> Tambah Data Pos Bayar</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="POST" action="" class="form-horizontal">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-4">
              <input type="text" name="nmPosBayar" class="form-control" id="" placeholder="Nama Pos Bayar" required>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-6">
              <input type="text" name="ketPosBayar" class="form-control" id="" placeholder="Keterangan">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
              <a href="index.php?view=posbayar" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
}
?>