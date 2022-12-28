<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Inventaris Masuk</h3>
        <a class='pull-right btn btn-primary btn-sm' href='?view=inventarismasuks&act=tambah'>Tambahkan Data</a>
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
                <th>Nama Barang</th>
                <th>Tanggal Masuk</th>
                <th>Jumlah</th>
                <th>Oleh</th>
                <th>Spek</th>
                <th>Harga</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $tampil = mysqli_query($conn, "SELECT rb_inv_masuk.*, rb_barang.nmBarang 
            FROM rb_inv_masuk
            INNER JOIN rb_barang ON rb_inv_masuk.idBarang=rb_barang.idBarang
            ORDER BY rb_inv_masuk.idBarang ASC");
              $no = 1;
              while ($r = mysqli_fetch_array($tampil)) {
                echo "<tr><td>$no</td>
                              <td>$r[nmBarang]</td>
                              <td>" . tgl_indo($r['tgl']) . "</td>
                              <td>$r[jumlahBarang]</td>
                              <td>$r[nmOrang]</td>
                              <td>$r[spek]</td>
                              <td>" . buatRp($r['harga']) . "</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=inventarismasuks&act=edit&id=$r[id]'><span class='glyphicon glyphicon-pencil'></span></a>
                              
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=inventarismasuks&hapus&id=$r[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
                echo "</tr>";
                $no++;
              }
              if (isset($_GET['hapus'])) {
                mysqli_query($conn, "DELETE FROM rb_inv_masuk where id='$_GET[id]'");
                echo "<script>document.location='?view=inventarismasuks';</script>";
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
    $harga = $_POST['jumlahBarang'] * $_POST['harga'];
    if ($query) {
      echo "<script>document.location='?view=inventarismasuks&sukses';</script>";
    } else {
      echo "<script>document.location='?view=inventarismasuks&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn, "SELECT * FROM rb_inv_masuk where id='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
  ?>
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Edit Data Barang Masuk</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form method="POST" action="" class="form-horizontal">
            <div class="col-md-6">
              <label for="" class=" control-label">Penginput</label>
              <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
              <input type="text" name="nmOrang" class="form-control" id="" value="<?php echo $record['nmOrang']; ?>">
            </div>
            <div class="col-md-6">
              <label for="" class=" control-label">Jumlah Barang Masuk</label>
              <input type="text" name="jumlahBarang" class="form-control" id="" value="<?php echo $record['jumlahBarang']; ?>">
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
            <div class="col-md-12">
              <label for="" class=" control-label">Harga</label>
              <input type="text" name="harga" class="form-control" id="" value="<?php echo $record['harga']; ?>">
            </div>
            <div class="col-md-6">
              <label for="" class=" control-label"></label>
              <input type="submit" name="edit" value="Simpan" class="btn btn-success">
              <a href="?view=inventarismasuks" class="btn btn-default">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>

  <?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST['tambah'])) {
    $harga = $_POST['jumlahBarang'] * $_POST['harga'];
    $query = mysqli_query($conn, "INSERT INTO rb_inv_masuk(idBarang,tgl,jumlahBarang,spek,harga,nmOrang) VALUES('$_POST[idBarang]','$_POST[tgl]','$_POST[jumlahBarang]','$_POST[spek]','$harga','$_POST[nmOrang]')");

    $query_saldo = mysqli_query($conn, "SELECT SUM(jumlahBarang) as jumlah_debit FROM rb_barang WHERE idBarang ='$_POST[idBarang]'   ");
    $saldo = mysqli_fetch_array($query_saldo);
    $saldoo = $saldo['jumlah_debit'] + $_POST['jumlahBarang'];
    mysqli_query($conn, "UPDATE rb_barang SET jumlahBarang = '$saldoo'
                                    WHERE idBarang = '$_POST[idBarang]'  ");

    if ($query) {
      echo "<script>document.location='?view=inventarismasuks&sukses';</script>";
    } else {
      echo "<script>document.location='?view=inventarismasuks&gagal';</script>";
    }
  }
  ?>
    <div class="col-md-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Tambah Data Barang Masuk</h3>
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
              <label for="" class=" control-label">Jumlah Barang Masuk</label>

              <input type="text" name="jumlahBarang" class="form-control" id="" placeholder="jumlah Barang">

            </div>
            <div class="col-md-6">
              <label for="" class=" control-label">Penginput</label>

              <input type="text" name="nmOrang" class="form-control" id="" placeholder="Nama Penginput">

            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Tanggal</label>
                <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input class="form-control md-3" required="" type="text" name="tgl" placeholder="Tanggal Masuk" value="<?= $tanggal_sekarang ?>">
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <label for="" class=" control-label">Spek</label>

              <input type="text" name="spek" class="form-control" id="" placeholder="Rincian Spek">

            </div>
            <div class="col-md-12">
              <label for="" class=" control-label">Harga</label>

              <input type="text" name="harga" class="form-control" id="" placeholder="Harga Per Barang">

            </div>
            <div class="col-md-6">
              <label for="" class=" control-label"></label>

              <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
              <a href="?view=inventarismasuks" class="btn btn-default">Cancel</a>

            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
}
  ?>