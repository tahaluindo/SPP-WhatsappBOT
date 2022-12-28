<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">

        <a class="pull-left btn btn-success  btn-sm" target="_blank" href="./excel_laporan_barang.php"><span class="fa fa-file-excel-o"></span> Export ke Excel</a>

        <a class='pull-right btn btn-primary btn-sm' href='?view=inventaris&act=tambah'>Tambahkan Data</a>
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
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data tidak Di Proses, terjadi kesalahan dengan data..
                          </div>";
          }
          ?>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Inventaris</th>
                <th>Jumlah Inventaris</th>
                <th>Harga/Barang</th>
                <th>Total Harga</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $tampil = mysqli_query($conn, "SELECT rb_barang.jumlahBarang,rb_barang.nmBarang,rb_inv_masuk.harga,sum(rb_inv_masuk.harga) as Harga FROM rb_barang 
            inner join rb_inv_masuk on rb_barang.idBarang=rb_inv_masuk.idBarang
            GROUP BY rb_barang.idBarang ASC");
              $no = 1;
              while ($r = mysqli_fetch_array($tampil)) {
                echo "<tr><td>$no</td>
                            
                              <td>$r[nmBarang]</td>
                              <td>$r[jumlahBarang]</td>
                              <td>" . buatRp($r['harga']) . "</td>
                              <td>" . buatRp($r['Harga']) . "</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=inventaris&act=edit&id=$r[idBarang]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=inventaris&hapus&id=$r[idBarang]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
                echo "</tr>";
                $no++;
              }
              if (isset($_GET['hapus'])) {
                mysqli_query($conn, "DELETE FROM rb_barang where idBarang='$_GET[id]'");
                echo "<script>document.location='?view=inventaris';</script>";
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
    $query = mysqli_query($conn, "UPDATE rb_barang SET nmBarang='$_POST[nmBarang]', 
										 jumlahBarang='$_POST[jumlahBarang]' where idBarang = '$_POST[id]'");
    if ($query) {
      echo "<script>document.location='?view=inventaris&sukses';</script>";
    } else {
      echo "<script>document.location='?view=inventaris&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn, "SELECT * FROM rb_barang where idBarang='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
  ?>
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Edit Data Barang</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form method="post" action="" class="form-horizontal">
            <input type="hidden" name="id" value="<?php echo $record['idBarang']; ?>">
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Nama Barang</label>
              <div class="col-sm-4">
                <input type="text" name="nmBarang" class="form-control" value="<?php echo $record['nmBarang']; ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Jumlah Barang</label>
              <div class="col-sm-6">
                <input type="text" name="jumlahBarang" class="form-control" value="<?php echo $record['jumlahBarang']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <input type="submit" name="update" value="Update" class="btn btn-success">
                <a href="?view=inventaris" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST['tambah'])) {
    $query = mysqli_query($conn, "INSERT INTO rb_barang(nmBarang,jumlahBarang) VALUES('$_POST[nmBarang]','$_POST[jumlahBarang]')");
    if ($query) {
      echo "<script>document.location='?view=inventaris&sukses';</script>";
    } else {
      echo "<script>document.location='?view=inventaris&gagal';</script>";
    }
  }
  ?>
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Tambah Data Barang </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form method="POST" action="" class="form-horizontal">
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Nama Barang</label>
              <div class="col-sm-4">
                <input type="text" name="nmBarang" class="form-control" id="" placeholder="Nama Barang" required>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Jumlah Barang</label>
              <div class="col-sm-6">
                <input type="text" name="jumlahBarang" class="form-control" id="" placeholder="jumlah Barang">
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
                <a href="?view=inventaris" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
}
  ?>