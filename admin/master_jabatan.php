<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Jabatan </h3>
        <a class='pull-right btn btn-primary btn-sm' href='?view=jabatan&act=tambah'>Tambahkan Data</a>
      </div><!-- /.box-header -->
      <div class="table-responsive">
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
        }
        ?>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Jabatan</th>
              <th>Nama Jabatan</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $tampil = mysqli_query($conn, "SELECT * FROM kelas_siswa ORDER BY idKelas ASC");
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
              echo "<tr><td>$no</td>
                              <td>$r[idKelas]</td>
                              <td>$r[nmKelas]</td>
                              <td>$r[ketKelas]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=jabatan&act=edit&id=$r[idKelas]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=jabatan&hapus&id=$r[idKelas]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
              echo "</tr>";
              $no++;
            }
            if (isset($_GET['hapus'])) {
              mysqli_query($conn, "DELETE FROM kelas_siswa where idKelas='$_GET[id]'");
              echo "<script>document.location='?view=jabatan';</script>";
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
    $query = mysqli_query($conn, "UPDATE kelas_siswa SET nmKelas='$_POST[nmKelas]', 
										 ketKelas='$_POST[ketKelas]' where idKelas = '$_POST[id]'");
    if ($query) {
      echo "<script>document.location='?view=jabatan&sukses';</script>";
    } else {
      echo "<script>document.location='?view=jabatan&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn, "SELECT * FROM kelas_siswa where idKelas='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Edit Data Jabatan</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="post" action="" class="form-horizontal">
          <input type="hidden" name="id" value="<?php echo $record['idKelas']; ?>">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nama Jabatan</label>
            <div class="col-sm-4">
              <input type="text" name="nmKelas" class="form-control" value="<?php echo $record['nmKelas']; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-6">
              <input type="text" name="ketKelas" class="form-control" value="<?php echo $record['ketKelas']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              <input type="submit" name="update" value="Update" class="btn btn-success">
              <a href="?view=jabatan" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST['tambah'])) {
    $query = mysqli_query($conn, "INSERT INTO kelas_siswa(nmKelas,ketKelas) VALUES('$_POST[nmKelas]','$_POST[ketKelas]')");
    if ($query) {
      echo "<script>document.location='?view=jabatan&sukses';</script>";
    } else {
      echo "<script>document.location='?view=jabatan&gagal';</script>";
    }
  }
?>
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Tambah Data Jabatan </h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="POST" action="" class="form-horizontal">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Nama Jabatan</label>
            <div class="col-sm-4">
              <input type="text" name="nmKelas" class="form-control" id="" placeholder="Nama Jabatan" required>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Keterangan</label>
            <div class="col-sm-6">
              <input type="text" name="ketKelas" class="form-control" id="" placeholder="Keterangan">
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
              <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
              <a href="?view=jabatan" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
}
?>