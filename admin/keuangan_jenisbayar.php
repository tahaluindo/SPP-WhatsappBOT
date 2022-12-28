<?php if ($_GET['act'] == '') {
  if (isset($_GET['tahun']) && $_GET['tahun'] != '') {
    $tampil = mysqli_query($conn, "SELECT * FROM view_detil_jenis_bayar WHERE idTahunAjaran='$_GET[tahun]' ORDER BY idJenisBayar ASC");
    $tahun = $_GET['tahun'];
  } elseif (isset($_GET['tahun']) && $_GET['tahun'] == '') {
    $tampil = mysqli_query($conn, "SELECT * FROM view_detil_jenis_bayar ORDER BY nmTahunAjaran DESC,idJenisBayar");
  } else {
    $sqlTahunAktif = mysqli_query($conn, "SELECT * FROM tahun_ajaran WHERE aktif='Y'");
    $tahunaktif = mysqli_fetch_array($sqlTahunAktif);
    $tahun = $tahunaktif['idTahunAjaran'];
    $tampil = mysqli_query($conn, "SELECT * FROM view_detil_jenis_bayar WHERE idTahunAjaran='$tahunaktif[idTahunAjaran]' ORDER BY idJenisBayar ASC");
  }
?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Jenis Pembayaran </h3>
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
        <form method="GET" action="" class="form-horizontal">
          <input type="hidden" name="view" value="jenisbayar" />
          <table class="table table-striped">
            <tbody>
              <tr>
                <td width="300px">
                  <select id="tahun" name="tahun" class="form-control">
                    <option value="" selected> Semua Tahun Ajaran </option>
                    <?php
                    $sqk = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY nmTahunAjaran ASC");
                    while ($k = mysqli_fetch_array($sqk)) {
                      $selected = ($k['idTahunAjaran'] == $tahun) ? ' selected="selected"' : "";
                      echo "<option value=" . $k['idTahunAjaran'] . " " . $selected . ">" . $k['nmTahunAjaran'] . "</option>";
                    }
                    ?>
                  </select>
                </td>
                <td width="100">
                  <input type="submit" name="tampil" value="Tampilkan" class="btn btn-success pull-right btn-sm">
                </td>
                <td>
                  <span class="pull-right">
                    <a class='pull-right btn btn-primary btn-sm' href='index.php?view=jenisbayar&act=tambah'>Tambahkan Data</a>
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
        <div class="table-responsive">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>POS</th>
                <th>Nama Pembayaran</th>
                <th>Tipe</th>
                <th>Tahun</th>
                <th>Tarif Pembayaran</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              while ($r = mysqli_fetch_array($tampil)) {
                echo "<tr><td>$no</td>
      <td>$r[nmPosBayar]</td>
      <td>$r[nmJenisBayar]</td>
      <td>$r[tipeBayar]</td>
      <td>$r[nmTahunAjaran]</td>";
              ?>
                <td>
                  <a data-toggle="tooltip" data-placement="top" title="Ubah" style="margin-right:5px" class="btn btn-primary btn-xs" href="index.php?view=tarif&jenis=<?php echo $r['idJenisBayar'] . "&tipe=" . $r['tipeBayar']; ?>">
                    Setting Tarif Pembayaran
                  </a>
                </td>
              <?php echo "
    <td><center>
    <a class='btn btn-success btn-xs' title='Edit Data' href='?view=jenisbayar&act=edit&id=$r[idJenisBayar]'><span class='glyphicon glyphicon-edit'></span></a>
    <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=jenisbayar&hapus&id=$r[idJenisBayar]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
    </center></td>";
                echo "</tr>";
                $no++;
              }
              if (isset($_GET['hapus'])) {
                $query = mysqli_query($conn, "DELETE FROM jenis_bayar where idJenisBayar='$_GET[id]'");
                if ($query) {
                  echo "<script>document.location='index.php?view=jenisbayar&sukseshapus';</script>";
                } else {
                  echo "<script>document.location='index.php?view=jenisbayar&gagalhapus';</script>";
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

    $query = mysqli_query($conn, "UPDATE jenis_bayar SET idPosBayar='$_POST[idPosBayar]', 
     idTahunAjaran='$_POST[idTahunAjaran]',nmJenisBayar='$_POST[nmJenisBayar]',
     tipeBayar='$_POST[tipeBayar]' where idJenisBayar = '$_POST[id]'");
    if ($query) {
      echo "<script>document.location='index.php?view=jenisbayar&sukses';</script>";
    } else {
      echo "<script>document.location='index.php?view=jenisbayar&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn, "SELECT * FROM view_detil_jenis_bayar where idJenisBayar='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
  ?>
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> Edit Data Jenis Pembayaran</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form method="post" action="" class="form-horizontal">
            <input type="hidden" name="id" value="<?php echo $record['idJenisBayar']; ?>" readonly>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">POS</label>
              <div class="col-sm-4">
                <select name="idPosBayar" class="form-control">
                  <?php
                  $sqlpos = mysqli_query($conn, "SELECT * FROM pos_bayar ORDER BY idPosBayar ASC");
                  while ($p = mysqli_fetch_array($sqlpos)) {
                    $selected = ($p['idPosBayar'] == $record['idPosBayar']) ? ' selected="selected"' : "";

                    echo '<option value="' . $p['idPosBayar'] . '" ' . $selected . '>' . $p['nmPosBayar'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
              <div class="col-sm-2">
                <input type="hidden" name="idTahunAjaran" value="<?php echo $record['idTahunAjaran']; ?>" class="form-control">
                <input type="text" name="nmTahunAjaran" value="<?php echo $record['nmTahunAjaran']; ?>" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Nama Pembayaran</label>
              <div class="col-sm-6">
                <input type="text" name="nmJenisBayar" value="<?php echo $record['nmJenisBayar']; ?>" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Tipe Pembayaran</label>
              <div class="col-sm-2">
                <input type="text" name="tipeBayar" value="<?php echo $record['tipeBayar']; ?>" class="form-control" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <input type="submit" name="update" value="Update" class="btn btn-success">
                <a href="index.php?view=jenisbayar" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  <?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST['tambah'])) {
    $query = mysqli_query($conn, "INSERT INTO jenis_bayar(idPosBayar,idTahunAjaran,nmJenisBayar,tipeBayar) VALUES('$_POST[idPosBayar]','$_POST[idTahunAjaran]','$_POST[nmJenisBayar]','$_POST[tipeBayar]')");
    if ($query) {
      echo "<script>document.location='index.php?view=jenisbayar&sukses';</script>";
    } else {
      echo "<script>document.location='index.php?view=jenisbayar&gagal';</script>";
    }
  }
  ?>
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> Tambah Data Jenis Pembayaran</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form method="POST" action="" class="form-horizontal">
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">POS</label>
              <div class="col-sm-4">
                <select name="idPosBayar" class="form-control">
                  <?php
                  $sqlpos = mysqli_query($conn, "SELECT * FROM pos_bayar ORDER BY idPosBayar ASC");
                  while ($p = mysqli_fetch_array($sqlpos)) {
                    echo "<option value=" . $p['idPosBayar'] . ">" . $p['nmPosBayar'] . "</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Tahun</label>
              <div class="col-sm-4">
                <select name="idTahunAjaran" class="form-control">
                  <?php
                  $sqltahun = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran ASC");
                  while ($t = mysqli_fetch_array($sqltahun)) {

                    $selected = ($t['aktif'] == 'Y') ? ' selected="selected"' : "";
                    echo "<option value=" . $t['idTahunAjaran'] . " " . $selected . ">" . $t['nmTahunAjaran'] . "</option>";
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Nama Pembayaran</label>
              <div class="col-sm-6">
                <input type="text" name="nmJenisBayar" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Nama Pembayaran</label>
              <div class="col-sm-4">
                <select class="form-control" name="tipeBayar">
                  <option value="bulanan">bulanan</option>
                  <option value="bebas" selected>bebas</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-2 control-label"></label>
              <div class="col-sm-10">
                <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
                <a href="index.php?view=jenisbayar" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
}
  ?>