<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Inventaris Keluar</h3>
        <a class='pull-right btn btn-primary btn-sm' href='?view=inventariskeluar&act=tambah'>Tambahkan Data</a>
      </div><!-- /.box-header -->
      <?php
      if (isset($_GET['sukses'])) {
        echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil Di Proses,..
                          </div>";
      } elseif (isset($_GET['gagal'])) {
        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>×</span></button> <strong>Gagal</strong> - Jumlah Keluar melebihi Jumlah Barang!!!
          </div>";
      }
      ?>
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Tanggal Keluar</th>
              <th>Jumlah</th>
              <th>Peminjam</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $tampil = mysqli_query($conn, "SELECT rb_inv_keluar.*, rb_barang.nmBarang 
            FROM rb_inv_keluar
            INNER JOIN rb_barang ON rb_inv_keluar.idBarang=rb_barang.idBarang
            ORDER BY rb_inv_keluar.idBarang ASC");
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
              echo "<tr><td>$no</td>
                              <td>$r[nmBarang]</td>
                              <td>" . tgl_indo($r['tgl']) . "</td>
                              <td>$r[jumlahBarang]</td>
                              <td>$r[nmOrang]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=inventariskeluar&act=edit&id=$r[id]' ><span class='glyphicon glyphicon-pencil'></span></a>
                              
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=inventariskeluar&hapus&id=$r[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
              echo "</tr>";
              $no++;
            }
            if (isset($_GET['hapus'])) {
              mysqli_query($conn, "DELETE FROM rb_inv_keluar where id='$_GET[id]'");
              echo "<script>document.location='?view=inventariskeluar';</script>";
            }

            ?>
          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>
<?php
} elseif ($_GET['act'] == 'edit') {
  if (isset($_POST['edit'])) {
    $query = mysqli_query($conn, "UPDATE  rb_inv_keluar SET tgl='$_POST[tgl]',spek='$_POST[spek]',nmOrang='$_POST[nmOrang]' where id = '$_POST[id]'");
    if ($query) {
      echo "<script>document.location='?view=inventariskeluar&sukses';</script>";
    } else {
      echo "<script>document.location='?view=inventariskeluar&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn, "SELECT * FROM rb_inv_keluar where id='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Edit Data Barang Keluar</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="POST" action="" class="form-horizontal">
          <div class="col-md-6">
            <label for="" class=" control-label">Penginput</label>
            <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
            <input type="text" name="nmOrang" class="form-control" id="" value="<?php echo $record['nmOrang']; ?>">
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Tanggal</label>
              <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control md-3" required="" type="text" name="tgl" placeholder="Tanggal Masuk" value="<?php echo $record['tgl']; ?>">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <label for="" class=" control-label">Spek</label>
            <input type="text" name="spek" class="form-control" id="" value="<?php echo $record['spek']; ?>">
          </div>
          <div class="col-md-6">
            <label for="" class=" control-label"></label>

            <input type="submit" name="edit" value="Simpan" class="btn btn-success">
            <a href="?view=inventariskeluar" class="btn btn-default">Cancel</a>

          </div>
        </form>
      </div>
    </div>
  </div>

<?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST['tambah'])) {
    $query_saldos = mysqli_query($conn, "SELECT SUM(jumlahBarang) as jumlah_debits FROM rb_barang WHERE idBarang ='$_POST[idBarang]'   ");
    $saldos = mysqli_fetch_array($query_saldos);
    $saldoos = $saldos['jumlah_debits'];
    if ($_POST['jumlahBarang'] > $saldoos) {
      echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>×</span></button> <strong>Gagal</strong> - Jumlah Keluar melebihi Jumlah Barang!!!
      </div>";
    } else {
      $query = mysqli_query($conn, "INSERT INTO rb_inv_keluar(idBarang,tgl,jumlahBarang,nmOrang) VALUES('$_POST[idBarang]','$_POST[tgl]','$_POST[jumlahBarang]','$_POST[nmOrang]')");
      $query_saldo = mysqli_query($conn, "SELECT SUM(jumlahBarang) as jumlah_debit FROM rb_barang WHERE idBarang ='$_POST[idBarang]'   ");
      $saldo = mysqli_fetch_array($query_saldo);
      $saldoo = $saldo['jumlah_debit'] - $_POST['jumlahBarang'];
      mysqli_query($conn, "UPDATE rb_barang SET jumlahBarang = '$saldoo'
                                      WHERE idBarang = '$_POST[idBarang]'  ");
    }
    if ($query) {
      echo "<script>document.location='?view=inventariskeluar&sukses';</script>";
    } else {
      echo "<script>document.location='?view=inventariskeluar&gagal';</script>";
    }
  }
?>
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Tambah Data Barang Keluar</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="POST" action="" class="form-horizontal">
          <div class="col-md-6">
            <label for="" class=" control-label">Nama Barang</label>
            <select name="idBarang" class="form-control">
              <?php
              $sqk = mysqli_query($conn, "SELECT * FROM rb_barang ORDER BY idBarang ASC");
              while ($k = mysqli_fetch_array($sqk)) {
                $selected = ($k['idBarang'] == $record['idBarang']) ? ' selected="selected"' : "";
                echo '<option value="' . $k['idBarang'] . '" ' . $selected . '>' . $k['nmBarang'] . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="" class=" control-label">Jumlah Barang</label>
            <input type="text" name="jumlahBarang" class="form-control" id="" placeholder="jumlah Barang">
          </div>
          <div class="col-md-6">
            <label for="" class=" control-label">Peminjam</label>
            <input type="text" name="nmOrang" class="form-control" id="" placeholder="Nama Peminjam">
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Tanggal</label>
              <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control md-3" required="" type="text" name="tgl" placeholder="Tanggal Prestasi" value="<?= $tanggal_sekarang ?>">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <label for="" class=" control-label"></label>
            <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
            <a href="?view=inventariskeluar" class="btn btn-default">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
}
?>