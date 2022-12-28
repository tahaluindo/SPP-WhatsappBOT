<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Bank </h3>
        <a class='pull-right btn btn-primary btn-sm' href='?view=bank&act=tambah'>Tambahkan Data</a>
      </div><!-- /.box-header -->
      <div class="box-body">
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
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data tidak Di Proses, akun bank memiliki saldo..
                          </div>";
          } elseif (isset($_GET['sukseshapus'])) {
            echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                          <span aria-hidden='true'>×</span></button> <strong>Berhasil!</strong> - Data Berhasil dihapus.....
                                          </div>";
          }
          ?>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Bank</th>
                <th>Atas Nama</th>
                <th>Nomor Rekening</th>
                <th>Saldo</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $tampil = mysqli_query($conn, "SELECT * FROM bank ");
              $no = 1;
              while ($r = mysqli_fetch_array($tampil)) {
                echo "<tr><td>$no</td>
                              <td>$r[nmBank]</td>
                              <td>$r[atasNama]</td>
                              <td>$r[noRek]</td>
                              <td>" . buatRp($r['saldo']) . "</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=bank&act=edit&id=$r[id]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=bank&hapus&id=$r[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
                echo "</tr>";
                $no++;
              }
              if (isset($_GET['hapus'])) {
                $query_saldo = mysqli_query($conn, "SELECT sum(saldo) as total FROM bank WHERE id ='$_GET[id]' ");
                $saldo = mysqli_fetch_array($query_saldo);
                $saldoo =  $saldo['total'];
                if ($saldoo != '0') {
                  echo "<script>document.location='index.php?view=bank&gagal';</script>";
                } else {
                  mysqli_query($conn, "DELETE FROM bank where id='$_GET[id]'");
                 echo "<script>document.location='?view=bank&sukseshapus';</script>";
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
    $query = mysqli_query($conn, "UPDATE bank SET nmBank='$_POST[nmBank]',atasNama='$_POST[atasNama]',noRek='$_POST[noRek]' where id = '$_POST[id]'");
    if ($query) {
      echo "<script>document.location='?view=bank&sukses';</script>";
    } else {
      echo "<script>document.location='?view=bank&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn, "SELECT * FROM bank where id='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
  ?>
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Edit Data Saldo</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form method="post" action="" class="form-horizontal">
            <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Nama Bank</label>
              <div class="col-sm-4">
                <input type="text" name="nmBank" class="form-control" value="<?php echo $record['nmBank']; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Atas Nama</label>
              <div class="col-sm-4">
                <input type="text" name="atasNama" class="form-control" value="<?php echo $record['atasNama']; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">No Rekening</label>
              <div class="col-sm-4">
                <input type="text" name="noRek" class="form-control" value="<?php echo $record['noRek']; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <input type="submit" name="update" value="Update" class="btn btn-success">
                <a href="?view=bank" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST['tambah'])) {
    $query = mysqli_query($conn, "INSERT INTO bank(nmBank,atasNama,noRek,saldo) VALUES('$_POST[nmBank]','$_POST[atasNama]','$_POST[noRek]','$_POST[saldo]')");
    if ($query) {
      echo "<script>document.location='?view=bank&sukses';</script>";
    } else {
      echo "<script>document.location='?view=bank&gagal';</script>";
    }
  }
  ?>
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Tambah Data Saldo </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form method="POST" action="" class="form-horizontal">
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Nama Bank</label>
              <div class="col-sm-4">
                <input type="text" name="nmBank" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Atas Nama</label>
              <div class="col-sm-4">
                <input type="text" name="atasNama" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">No Rekening</label>
              <div class="col-sm-4">
                <input type="text" name="noRek" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Jumlah</label>
              <div class="col-sm-4">
                <input type="text" name="saldo" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
                <a href="?view=bank" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
}
  ?>