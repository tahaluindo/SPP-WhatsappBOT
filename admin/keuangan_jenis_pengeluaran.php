<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Jenis Pengeluaran </h3>
        <a class='pull-right btn btn-primary btn-sm' href='index.php?view=jenis_pengeluaran&act=tambah'>Tambahkan Data</a>
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
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $tampil = mysqli_query($conn, "SELECT * FROM jenis_pengeluaran ORDER BY idPengeluaran ASC");
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
              echo "<tr><td>$no</td>
                              <td>$r[nmPengeluaran]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=jenis_pengeluaran&act=edit&id=$r[idPengeluaran]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=jenis_pengeluaran&hapus&id=$r[idPengeluaran]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
              echo "</tr>";
              $no++;
            }
            if (isset($_GET['hapus'])) {
              $query = mysqli_query($conn, "DELETE FROM jenis_pengeluaran where idPengeluaran='$_GET[id]'");
              if ($query) {
                echo "<script>document.location='index.php?view=jenis_pengeluaran&sukseshapus';</script>";
              } else {
                echo "<script>document.location='index.php?view=jenis_pengeluaran&gagalhapus';</script>";
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
  if (isset($_POST['update'])) {

    $query = mysqli_query($conn, "UPDATE jenis_pengeluaran SET nmPengeluaran='$_POST[nmPengeluaran]' 
										 where idPengeluaran = '$_POST[id]'");
    if ($query) {
      echo "<script>document.location='index.php?view=jenis_pengeluaran&sukses';</script>";
    } else {
      echo "<script>document.location='index.php?view=jenis_pengeluaran&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn, "SELECT * FROM jenis_pengeluaran where idPengeluaran='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Edit Data Jenis Pengeluaran</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="post" action="" class="form-horizontal">
          <input type="hidden" name="id" value="<?php echo $record['idPengeluaran']; ?>">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-4">
              <input type="text" name="nmPengeluaran" class="form-control" value="<?php echo $record['nmPengeluaran']; ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              <input type="submit" name="update" value="Update" class="btn btn-success">
              <a href="index.php?view=jenis_pengeluaran" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST['tambah'])) {
    $query = mysqli_query($conn, "INSERT INTO jenis_pengeluaran(nmPengeluaran) VALUES('$_POST[nmPengeluaran]')");
    if ($query) {
      echo "<script>document.location='index.php?view=jenis_pengeluaran&sukses';</script>";
    } else {
      echo "<script>document.location='index.php?view=jenis_pengeluaran&gagal';</script>";
    }
  }
?>
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Tambah Data Jenis Pengeluaran</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="POST" action="" class="form-horizontal">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-4">
              <input type="text" name="nmPengeluaran" class="form-control" id="" placeholder="Nama Jenis Pengeluaran" required>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
              <a href="index.php?view=jenis_pengeluaran" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
}
?>