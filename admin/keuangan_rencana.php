<?php if ($_GET[act] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Perencanaan </h3>
        <a class='pull-right btn btn-primary btn-sm' href='index.php?view=rencana&act=tambah'>Tambahkan Data</a>
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
        } elseif (isset($_GET['sukseshapus'])) {
          echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Berhasil!</strong> - Data Berhasil dihapus.....
                          </div>";
        } elseif (isset($_GET['gagalhapus'])) {
          echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data ini telah digunakan oleh data lain, sehingga tidak bisa dihapus!!
                          </div>";
        }
        ?>
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>POS Kegiatan</th>
              <th>Bulan</th>
              <th>Pagu Anggaran</th>
              <th>Realisasi</th>
              <th>Sisa Anggaran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $tampil = mysqli_query($conn, "SELECT rencana.*, jenis_pengeluaran.nmPengeluaran ,
            rencana.pagu,bulan.nmBulan
            FROM rencana
            INNER JOIN jenis_pengeluaran ON rencana.idPengeluaran=jenis_pengeluaran.idPengeluaran
            INNER JOIN bulan ON rencana.idBulan=bulan.idBulan   
            ORDER BY rencana.id ASC");
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
              echo "<tr><td>$no</td>
              <td>$r[nmPengeluaran]</td>
              <td>$r[nmBulan]</td>
              <td>" . buatRp($r[pagu]) . "</td>
              <td>" . buatRp($r[realisasi]) . "</td>
              <td>" . buatRp($r[pagu] - $r[realisasi]) . "</td>
              <td><center>
                            
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=rencana&hapus&id=$r[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
              echo "</tr>";
              $no++;
            }
            if (isset($_GET['hapus'])) {
              $query = mysqli_query($conn, "DELETE FROM rb_rencana where id='$_GET[id]'");
              if ($query) {
                echo "<script>document.location='index.php?view=rencana&sukseshapus';</script>";
              } else {
                echo "<script>document.location='index.php?view=rencana&gagalhapus';</script>";
              }
            }

            ?>
          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>

<?php
} elseif ($_GET[act] == 'tambah') {
  if (isset($_POST[tambah])) {
    $query = mysqli_query($conn, "INSERT INTO rencana(idPengeluaran,idBulan,pagu,realisasi) 
    VALUES('$_POST[idPengeluaran]','$_POST[idBulan]','$_POST[pagu]','$_POST[realisasi]')");
    if ($query) {
      echo "<script>document.location='index.php?view=rencana&sukses';</script>";
    } else {
      echo "<script>document.location='index.php?view=rencana&gagal';</script>";
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
            <label for="" class="col-sm-2 control-label">Nama </label>
            <div class="col-sm-4">
              <select name="idPengeluaran" class="form-control">
                <?php
                $sqk = mysqli_query($conn, "SELECT * FROM jenis_pengeluaran ORDER BY idPengeluaran ASC");
                while ($k = mysqli_fetch_array($sqk)) {
                  $selected = ($k['idPengeluaran'] == $record['idPengeluaran']) ? ' selected="selected"' : "";

                  echo '<option value="' . $k['idPengeluaran'] . '" ' . $selected . '>' . $k['nmPengeluaran'] . '</option>';
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Bulan</label>
            <div class="col-sm-4">
              <select name="idBulan" class="form-control">
                <?php
                $sqks = mysqli_query($conn, "SELECT * FROM bulan ");
                while ($ks = mysqli_fetch_array($sqks)) {
                  echo "<option value=" . $ks['idBulan'] . ">" . $ks['nmBulan'] . "</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Pagu</label>
            <div class="col-sm-4">
              <input type="text" name="pagu" class="form-control" id="" required>
            </div>
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Realisasi</label>
            <div class="col-sm-4">
              <input type="text" name="realisasi" class="form-control" id="" required>
            </div>
          </div>
          <div class="col-sm-10">
            <label for="" class=" control-label"></label>

            <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
            <a href="index.php?view=rencana" class="btn btn-default">Cancel</a>

          </div>
        </form>
      </div>
    </div>
  </div>
<?php
}
?>