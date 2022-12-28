<?php


$query = mysqli_query($conn, "SELECT max(id_angsurantoko) as maxKode FROM angsurantoko");
$data = mysqli_fetch_array($query);
$id_angsurantoko = $data['maxKode'];

$nourut = (int) substr($id_angsurantoko, 3, 3);
$nourut++;

$kode = "AP";
$kodeangsurantoko = $kode . sprintf("%03s", $nourut);
?>

<?php
$sql = mysqli_query($conn, "SELECT * FROM hutangtoko where id_hutangtoko='$_GET[id_hutangtoko]'; ");
$data = mysqli_fetch_array($sql);
$nominal = $data['nominal'];

$sql2 = mysqli_query($conn, "SELECT sum(angsuran) as jumlah FROM angsurantoko WHERE id_hutangtoko='$_GET[id_hutangtoko]';");
$data2 = mysqli_fetch_array($sql2);
$sisa = $data['nominal'] - $data2['jumlah'];
mysqli_query($conn, "UPDATE hutangtoko SET sisa='$sisa' where id_hutangtoko='$_GET[id_hutangtoko]';");
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Data Angsuran
    <small>Dari Peminjam</small>
  </h1>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Angsuran</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <form method="POST">
              <div class="col-xs-2">
                <input type="hidden" name="id_angsurantoko" class="form-control" value="<?php echo $kodeangsurantoko; ?>">
                <input type="hidden" name="id_hutangtoko" class="form-control" value="<?php echo $_GET['id_hutangtoko'] ?>">
                <label>Masukkan Angsuran</label>
              </div>
              <div class="col-xs-3">
                <input type="text" name="angsuran" class="form-control" placeholder="Angsuran">
              </div>
              <div class="col-xs-3">
                <input type="text" name="ket" class="form-control" placeholder="Keterangan">
              </div>
              <div class="col-xs-3">
                <select name="idBank" class="form-control" required>
                  <?php
                  $sqks = mysqli_query($conn, "SELECT * FROM bank ");
                  while ($ks = mysqli_fetch_array($sqks)) {
                    $selected = ($ks['id'] == $record['akun']) ? ' selected="selected"' : "";
                    echo '<option value="' . $ks['id'] . ' " ' . $selected . '>' . $ks['nmBank'] . ' - ' . $ks['atasNama'] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-xs-1">
                <button type="submit" name="save" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>

  <?php


  if (isset($_POST['save'])) {

    $tgl = date("Y-m-d");
    $caraBayar = $_POST['idBank'];
    $penerimaan = $_POST['angsuran'];
    $save = mysqli_query($conn, "INSERT INTO angsurantoko (id_angsurantoko,id_hutangtoko,tanggal,angsuran,carabayar) VALUES('$kodeangsurantoko','$_POST[id_hutangtoko]','$tgl','$_POST[angsuran]','$caraBayar')");
    $save = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) VALUES ('$_SESSION[namalengkap]','Tambah','Angsuran Hutang','$waktu_sekarang')");
    $save = mysqli_query($conn, "INSERT INTO jurnal_umums(idPenerimaan,tgl,ket,penerimaan,caraBayar) VALUES('5','$tgl','$_POST[ket]','$_POST[angsuran]','$caraBayar')");
    //update saldo bank
    $query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
    $saldo = mysqli_fetch_array($query_saldo);
    $saldoo =  $saldo['saldo'] + $penerimaan;
    mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
                                  WHERE id = '$caraBayar' ");

    if ($save) {
      echo "<script language=javascript>
        window.location='?view=detailtoko&id_hutangtoko=" . $_POST['id_hutangtoko'] . "';
        </script>";
      exit;
    } else {
      echo "gagal";
    }
  }
  ?>

  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-body">
          <div class="row">
            <div class="col-xs-1">
              <label>Hutang Ke</label>
            </div>
            <div class="col-xs-2">
              <input type="text" value="<?php echo $data['hutangke'] ?>" class="form-control" readonly>
            </div>
            <div class="col-xs-6">
            </div>
            <div class="col-xs-1">
              <label>Nominal</label>
            </div>
            <div class="col-xs-2">
              <input type="text" value="<?php echo "Rp. " . number_format($nominal, 0, "", '.') . ",-" ?>" name="notelp" class="form-control" readonly>
            </div>
          </div><br>
          <div class="row">
            <div class="col-xs-1">
              <label>Keterangan</label>
            </div>
            <div class="col-xs-2">
              <input type="text" value="<?php echo $data['ket'] ?>" class="form-control" readonly>
            </div>
            <div class="col-xs-6">
            </div>
            <div class="col-xs-1">
              <label>Sisa</label>
            </div>
            <div class="col-xs-2">
              <input type="text" value="<?php echo "Rp. " . number_format($sisa, 0, "", '.') . ",-" ?>" name="notelp" class="form-control" readonly>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example2" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Angsuran</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $query = mysqli_query($conn, "SELECT * FROM angsurantoko WHERE id_hutangtoko='$_GET[id_hutangtoko]' order by tanggal desc");
              while ($data = mysqli_fetch_array($query)) {
                $angsuran = $data['angsuran'];
              ?>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo tgl_indo($data['tanggal']); ?></td>
                  <td><?php echo "Rp. " . number_format($angsuran, 0, "", '.') . ",-" ?></td>
                  <td> <a class="btn btn-danger btn-md" title="Delete Data" href="?view=detailtoko&hapus&id=<?php echo $data['id_angsurantoko']; ?>" onclick="return confirm('Apa anda yakin untuk hapus Data ini?')"><span class="glyphicon glyphicon-remove"></span> Hapus</a>
                  </td>
                </tr>
              <?php $no++;
              }
              if (isset($_GET['hapus'])) {
                //Membaca Data Jurnal Yang akan dihapus
                $jurnal = mysqli_query($conn, "SELECT * FROM jurnal_umums WHERE id='$_GET[id]'");
                $jur = mysqli_fetch_array($jurnal);
                $saldo_jurnal = $jur['penerimaan'];
                $caraBayar = $jur['idBank'];
                //Membaca Saldo Bank
                $query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
                $saldo = mysqli_fetch_array($query_saldo);
                $saldoo =  $saldo['saldo'] + $saldo_jurnal;
                $oke = mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
								WHERE id = '$caraBayar'  ");

                mysqli_query($conn, "DELETE FROM angsurantoko where id_angsurantoko='$_GET[id]'");
                // mysqli_query($conn, "DELETE FROM jurnal_umums where id_angsurantoko='$_GET[id]'");
                $query = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Hapus','Angsuran Hutang','$waktu_sekarang')");
                echo "<script>document.location='index.php?view=hutangtoko';</script>";
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>

      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>

</section>