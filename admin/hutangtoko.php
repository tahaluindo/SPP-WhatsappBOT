<?php
include "../config/rupiah.php";
include 'config/rupiah.php';

$query_saldos = mysqli_query($conn, "SELECT SUM(sisa) as jumlah_debit FROM hutangtoko where piutangke='null'");
$rows = mysqli_fetch_array($query_saldos);
$saldo_keseluruhans = $rows['jumlah_debit'];

$query_saldo = mysqli_query($conn, "SELECT SUM(sisa) as jumlah_debit FROM hutangtoko where hutangke='Juragan It Web'");
$row = mysqli_fetch_array($query_saldo);
$saldo_keseluruhan = $row['jumlah_debit'];

$query = mysqli_query($conn, "SELECT max(id_hutangtoko) as maxKode FROM hutangtoko");
$data = mysqli_fetch_array($query);
$id_hutangtoko = $data['maxKode'];

$nourut = (int) substr($id_hutangtoko, 3, 3);
$nourut++;

$kode = "HT";
$kodehutangtoko = $kode . sprintf("%03s", $nourut);
$kodes = "P";
$kodehutangtokos = $kodes . sprintf("%03s", $nourut);


?>

<!-- Content Header (Page header) -->


<section class="content">
  <div class="col-xs-12">
    <div class="box box-danger box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"> </h3>
        <center><b>
            <h3>Total Hutang : Rp. <?php echo rupiah($saldo_keseluruhan); ?>,-
          </b></h3>
        </center>
        <!-- form start -->
        <form class="form-horizontal" method="POST">

          <input type="hidden" name="hutangke" value="Juragan It Web"></input>

          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-4 control-label">Nama</label>
              <div class="col-sm-6">
                <input type="text" name="ket" class="form-control" placeholder="Nama">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Nominal</label>

            <div class="col-sm-6">
              <input type="number" name="nominal" class="form-control" placeholder="Nominal">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label">Akun Bank</label>
            <div class="col-sm-6">
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
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-6">
              <button type="submit" name="save" class="btn btn-success pull-center">Simpan</button>
            </div>
          </div>
      </div>

      </form>
    </div>
  </div>


  <?php

  include "../config/koneksi.php";

  if (isset($_POST['save'])) {

    $tgl = date("Y-m-d");
    $pengeluaran = $_POST['nominal'];
    $caraBayar = $_POST['idBank'];
    $save = mysqli_query($conn, "INSERT INTO hutangtoko VALUES('$kodehutangtoko','$_POST[hutangke]','$tgl','$_POST[ket]','$_POST[nominal]','$_POST[nominal]','$caraBayar')");
    $save = mysqli_query($conn, "INSERT INTO jurnal_umum (idPengeluaran,tgl,ket,pengeluaran,caraBayar)VALUES('14','$tgl','$_POST[ket]','$_POST[nominal]',' $caraBayar')");
    $save = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Tambah','Hutang','$waktu_sekarang')");

    $query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
    $saldo = mysqli_fetch_array($query_saldo);
    $saldoo =  $saldo['saldo'] - $pengeluaran;
    $save =  mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
                                    WHERE id = '$caraBayar'  ");
    if ($save) {
      echo "<script language=javascript>
        window.location='?view=hutangtoko';
        </script>";
      exit;
    } else {
      echo "gagal";
    }
  }
  ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Data Hutang Piutang </h3>
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
                          <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Data ini tidak memiliki akun bank, sehingga tidak bisa dihapus!!
                          </div>";
        }
        ?>
        <!-- /.box-header -->
        <div class="table-responsive">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Kode</th>
                <th>Hutang Ke</th>
                <th>Tanggal</th>
                <th>Nama Peminjam</th>
                <th>Nominal Hutang</th>
                <th>Sisa Hutang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = mysqli_query($conn, "SELECT * FROM hutangtoko order by tanggal desc");
              while ($data = mysqli_fetch_array($query)) {
                $nominal = $data['nominal'];
                $sisa = $data['sisa'];
              ?>
                <tr>
                  <td><?php echo $data['id_hutangtoko']; ?></td>
                  <td><?php echo $data['hutangke']; ?></td>
                  <td><?php echo tgl_indo($data['tanggal']); ?></td>
                  <td><?php echo $data['ket']; ?></td>
                  <td><?php echo "Rp. " . number_format($nominal, 0, "", '.') . ",-" ?></td>
                  <td><?php echo "Rp. " . number_format($sisa, 0, "", '.') . ",-" ?></td>
                  <td>
                    <a href="?view=detailtoko&id_hutangtoko=<?php echo $data['id_hutangtoko']; ?>"><button type="submit" class="btn btn-primary" title="Lihat Angsuran">Angsuran</button></a>
                    <a class="btn btn-danger btn-md" title="Delete Data" href="?view=hutangtoko&hapus&id=<?php echo $data['id_hutangtoko']; ?>" onclick="return confirm('Apa anda yakin untuk hapus Data ini?')"><span class="glyphicon glyphicon-remove"></span></a>
                  </td>
                </tr>
              <?php
              }
              if (isset($_GET['hapus'])) {

                //Membaca Data Jurnal Yang akan dihapus
                $jurnal = mysqli_query($conn, "SELECT * FROM hutangtoko WHERE id_hutangtoko='$_GET[id]'");
                $jur = mysqli_fetch_array($jurnal);
                $saldo_jurnal = $jur['nominal'];
                $caraBayar = $jur['caraBayar'];
                //Membaca Saldo Bank
                $query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
                $saldo = mysqli_fetch_array($query_saldo);
                $saldoo =  $saldo['saldo'] + $saldo_jurnal;
                $oke = mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
								WHERE id = '$caraBayar'  ");
                if ($jur['caraBayar'] == '') {
                  echo "<script>document.location='index.php?view=hutangtoko&gagalhapus';</script>";
                } else {
                  mysqli_query($conn, "DELETE FROM hutangtoko where id_hutangtoko='$_GET[id]'");
                  $query = mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Hapus','Hutang','$waktu_sekarang')");
                  echo "<script>document.location='index.php?view=hutangtoko&sukseshapus';</script>";
                }
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
  <!-- /.row -->

</section>