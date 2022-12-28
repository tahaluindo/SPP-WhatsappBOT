<style>
  .pink-textarea textarea.md-textarea:focus:not([readonly]) {
    border-bottom: 1px solid #f48fb1;
    box-shadow: 0 1px 0 0 #f48fb1;
  }

  .active-pink-textarea.md-form label.active {
    color: #f48fb1;
  }

  .active-pink-textarea.md-form textarea.md-textarea:focus:not([readonly])+label {
    color: #f48fb1;
  }


  .amber-textarea textarea.md-textarea:focus:not([readonly]) {
    border-bottom: 1px solid #ffa000;
    box-shadow: 0 1px 0 0 #ffa000;
  }

  .active-amber-textarea.md-form label.active {
    color: #ffa000;
  }

  .active-amber-textarea.md-form textarea.md-textarea:focus:not([readonly])+label {
    color: #ffa000;
  }


  .active-pink-textarea-2 textarea.md-textarea {
    border-bottom: 1px solid #f48fb1;
    box-shadow: 0 1px 0 0 #f48fb1;
  }

  .active-pink-textarea-2.md-form label.active {
    color: #f48fb1;
  }

  .active-pink-textarea-2.md-form label {
    color: #f48fb1;
  }

  .active-pink-textarea-2.md-form textarea.md-textarea:focus:not([readonly])+label {
    color: #f48fb1;
  }


  .active-amber-textarea-2 textarea.md-textarea {
    border-bottom: 1px solid #ffa000;
    box-shadow: 0 1px 0 0 #ffa000;
  }

  .active-amber-textarea-2.md-form label.active {
    color: #ffa000;
  }

  .active-amber-textarea-2.md-form label {
    color: #ffa000;
  }

  .active-amber-textarea-2.md-form textarea.md-textarea:focus:not([readonly])+label {
    color: #ffa000;
  }
</style>

<?php if ($_GET['act'] == '') {
  $query_selesai = mysqli_query($conn, "SELECT *  FROM project where status='Selesai'");
  $num_selesai = mysqli_num_rows($query_selesai);

  $query_proses = mysqli_query($conn, "SELECT *  FROM project where status='Proses'");
  $num_proses = mysqli_num_rows($query_proses);

  $query_pending = mysqli_query($conn, "SELECT *  FROM project where status='Pending'");
  $num_pending = mysqli_num_rows($query_pending);

  $query_batal = mysqli_query($conn, "SELECT *  FROM project where status='Batal'");
  $num_batal = mysqli_num_rows($query_batal);

?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">
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
          <input type="hidden" name="view" value="keuangan_project" />
          <table class="table table-striped">
            <tbody>
              <tr>
                <!-- <td>
                  <select id="kelas" name="mitra" class="form-control">
                    <option value="" selected> - Pilih Client - </option>
                    <?php
                    $sqk = mysqli_query($conn, "SELECT * FROM mitra ORDER BY id ASC");
                    while ($k = mysqli_fetch_array($sqk)) {
                      $selected = ($k['id'] == $kelas) ? ' selected="selected"' : "";
                      echo "<option value=" . $k['id'] . " " . $selected . ">" . $k['nmMitra'] . "</option>";
                    }
                    ?>
                  </select>
                </td>
                <td>
                  <select class="form-control" name="status">
                    <option value="">- Semua Status -</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Pending">Pending</option>
                    <option value="Proses">Proses</option>
                    <option value="Batal">Batal</option>

                  </select>
                </td>
                <td width="100">
                  <input type="submit" name="tampil" value="Tampilkan" class="btn btn-warning pull-right btn-sm">
                </td> -->
                <td>
                  <span class="pull-right">
                    <a class=" btn btn-success  btn-sm" target="_blank" href="./excel_laporan_project.php"><span class="fa fa-file-excel-o"></span> Export ke Excel</a>

                    <a class=' btn btn-primary btn-sm' href='?view=keuangan_project&act=tambah'><span class="fa fa-plus faa-bounce animated"></span> Tambahkan Data</a>

                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </form>
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active">
            <li class="active"><a href="#tab_1" data-toggle="tab">Selesai (<span><b><?php echo $num_selesai; ?> </b> </span>)</a></li>
            <li><a href="#tab_2" data-toggle="tab">Proses (<span><b><?php echo $num_proses; ?> </b> </span>)</a></li>
            <li><a href="#tab_3" data-toggle="tab">Pending (<span><b><?php echo $num_pending; ?> </b> </span>)</a></li>
            <li><a href="#tab_4" data-toggle="tab">Batal (<span><b><?php echo $num_batal; ?> </b> </span>)</a></li>
          </ul>

          <div class="tab-content">
            
            <!-- List Tagihan Bulanan -->
            <div class="tab-pane active" id="tab_1">
              <div class="box-body table-responsive">
                <table class="table table-bordered" style="white-space: nowrap;">
                  <thead>
                    <tr class="warning">
                      <th width="10px">ID Project</th>
                      <th width="180px">Nama Project</th>
                      <th width="180px">Nama Client</th>
                      <th colspan="3" align="center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_POST['ganti'])) {
                      $query = mysqli_query($conn, "UPDATE project SET  status='$_POST[link]'
                      where idProject = '$_POST[id]'");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_project&sukses';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_project&gagal';</script>";
                      }
                    }
                    $no = 1;
                    $tampils = mysqli_query($conn, "SELECT project.*, nmProject,nmMitra,status FROM project 
                    INNER JOIN mitra ON project.idClient=mitra.id
                    WHERE project.status='Selesai'
                                ORDER BY status ASC");
                    while ($r = mysqli_fetch_array($tampils)) {
                      if ($r['status'] == 'Pending') {
                        $a = 'Proses';
                        $icon = "fa-hourglass-end faa-ring animated";
                        $btn = "btn-warning ";
                        $alt = "Ganti Proses";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi proses, Apa anda yakin?')\"><span class='fa $icon' ></span> Pending</a>";
                      } elseif ($r['status'] == 'Proses') {
                        $a = 'Selesai';
                        $icon = "fa-spinner faa-spin animated";
                        $btn = "btn-info";
                        $alt = "Ganti Selesaikan";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi selesai, Apa anda yakin?')\"><span class='fa $icon'></span> Proses</a>";
                      } elseif ($r['status'] == 'Selesai') {
                        $a = 'Batal';
                        $icon = "fa-check faa-shake animated";
                        $btn = "btn-success";
                        $alt = "Ganti Batalkan";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi batal, Apa anda yakin?')\"><span class='fa $icon'></span> Selesai</a>";
                      } else {
                        $a = 'Pending';
                        $icon = "fa-close faa-ring animated";
                        $btn = "btn-danger";
                        $alt = "Ganti Pending";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi pending, Apa anda yakin?')\"><span class='fa $icon'></span> Batal</a>";
                      }
                      $harga = $r['harga'] * $r['kuantitas'];
                      echo "<tr>
                        <td>$r[idProject]</td>
                        <td >$r[nmProject]</td>
                        <td >$r[nmMitra]</td>
                        <td>$onoff</td>
                        <td>
                        <a class='btn btn-primary btn-xs' title='Input' href='?view=keuangan_project&act=invoice&id=$r[idProject]'><span class='fa fa-align-center'></span> Input Item </a>
                        <a class='btn btn-warning btn-xs' title='Bayar' href='?view=keuangan_project&act=bayar&id=$r[idProject]'><span class='fa fa-money'></span> Input Bayar</a>
                        <a class='btn btn-info btn-xs' title='Cetak Data' target='_blank' href='./cetak_invoice.php?id=$r[idProject]'><span class='glyphicon glyphicon-print'></span> Cetak Invoice</a>
                        <a class='btn btn-success btn-xs' title='Edit Data' href='?view=keuangan_project&act=edit&id=$r[idProject]'><span class='glyphicon glyphicon-edit'></span>Edit</a>
                        <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=keuangan_project&hapus&id=$r[idProject]' onclick=\"return confirm('Menghapus data project, juga menghapus data item di dalamnya, Apa anda yakin?')\"><span class='glyphicon glyphicon-remove'></span>Hapus</a>
                        </td>";
                      echo "</tr>";
                      $no++;
                    }
                    if (isset($_GET['hapus'])) {
                      $query = mysqli_query($conn, "DELETE FROM project where idProject='$_GET[id]'");
                      $querys = mysqli_query($conn, "DELETE FROM invoice where idProject='$_GET[id]'");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_project&sukseshapus';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_project&gagalhapus';</script>";
                      }
                    }

                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- End List Tagihan Bulanan -->
            <div class="tab-pane" id="tab_2">
              <!-- List Tagihan Lainnya (Bebas) -->
              <div class="box-body table-responsive">
                <table class="table table-bordered" style="white-space: nowrap;">
                  <thead>
                    <tr class="warning">
                      <th width="10px">ID Project</th>
                      <th width="180px">Nama Project</th>
                      <th width="180px">Nama Client</th>
                      <th colspan="3" align="center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_POST['ganti'])) {
                      $query = mysqli_query($conn, "UPDATE project SET  status='$_POST[link]'
                          where idProject = '$_POST[id]' ");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_project&sukses';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_project&gagal';</script>";
                      }
                    }
                    $no = 1;
                    $tampils = mysqli_query($conn, "SELECT project.*, nmProject,nmMitra,status FROM project 
                    INNER JOIN mitra ON project.idClient=mitra.id
                    WHERE project.status='Proses'
                                ORDER BY status ASC");
                    while ($r = mysqli_fetch_array($tampils)) {
                      if ($r['status'] == 'Pending') {
                        $a = 'Proses';
                        $icon = "fa-hourglass-end faa-ring animated";
                        $btn = "btn-warning ";
                        $alt = "Ganti Proses";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi proses, Apa anda yakin?')\"><span class='fa $icon' ></span> Pending</a>";
                      } elseif ($r['status'] == 'Proses') {
                        $a = 'Selesai';
                        $icon = "fa-spinner faa-spin animated";
                        $btn = "btn-info";
                        $alt = "Ganti Selesaikan";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi selesai, Apa anda yakin?')\"><span class='fa $icon'></span> Proses</a>";
                      } elseif ($r['status'] == 'Selesai') {
                        $a = 'Batal';
                        $icon = "fa-check faa-shake animated";
                        $btn = "btn-success";
                        $alt = "Ganti Batalkan";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi batal, Apa anda yakin?')\"><span class='fa $icon'></span> Selesai</a>";
                      } else {
                        $a = 'Pending';
                        $icon = "fa-close faa-ring animated";
                        $btn = "btn-danger";
                        $alt = "Ganti Pending";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi pending, Apa anda yakin?')\"><span class='fa $icon'></span> Batal</a>";
                      }
                      $harga = $r['harga'] * $r['kuantitas'];
                      echo "<tr>
                           <td>$r[idProject]</td>
                          <td >$r[nmProject]</td>
                          <td >$r[nmMitra]</td>
                          <td>$onoff</td>
                          <td>
                          <a class='btn btn-primary btn-xs' title='Input' href='?view=keuangan_project&act=invoice&id=$r[idProject]'><span class='fa fa-align-center'></span> Input Item </a>
                          <a class='btn btn-warning btn-xs' title='Bayar' href='?view=keuangan_project&act=bayar&id=$r[idProject]'><span class='fa fa-money'></span> Input Bayar</a>
                          <a class='btn btn-info btn-xs' title='Cetak Data' target='_blank' href='./cetak_invoice.php?id=$r[idProject]'><span class='glyphicon glyphicon-print'></span> Cetak Invoice</a>
                          <a class='btn btn-success btn-xs' title='Edit Data' href='?view=keuangan_project&act=edit&id=$r[idProject]'><span class='glyphicon glyphicon-edit'></span>Edit</a>
                          <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=keuangan_project&hapus&id=$r[idProject]' onclick=\"return confirm('Menghapus data project, juga menghapus data item di dalamnya, Apa anda yakin?')\"><span class='glyphicon glyphicon-remove'></span>Hapus</a>
                          </td>";
                      echo "</tr>";
                      $no++;
                    }
                    if (isset($_GET['hapus'])) {
                      $query = mysqli_query($conn, "DELETE FROM project where idProject='$_GET[id]'");
                      $querys = mysqli_query($conn, "DELETE FROM invoice where idProject='$_GET[id]'");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_project&sukseshapus';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_project&gagalhapus';</script>";
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="tab-pane" id="tab_3">
              <!-- List Tagihan Lainnya (Bebas) -->
              <div class="box-body table-responsive">
                <table class="table table-bordered" style="white-space: nowrap;">
                  <thead>
                    <tr class="warning">
                      <th width="10px">ID Project</th>
                      <th width="180px">Nama Project</th>
                      <th width="180px">Nama Client</th>
                      <th colspan="3" align="center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    if (isset($_POST['ganti'])) {

                      $query = mysqli_query($conn, "UPDATE project SET  status='$_POST[link]'
                       where idProject = '$_POST[id]' ");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_project&sukses';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_project&gagal';</script>";
                      }
                    }
                    $no = 1;
                    $tampils = mysqli_query($conn, "SELECT project.*, nmProject,nmMitra,status FROM project 
                    INNER JOIN mitra ON project.idClient=mitra.id
                    WHERE project.status='Pending'
                  ORDER BY status ASC");
                    while ($r = mysqli_fetch_array($tampils)) {
                      if ($r['status'] == 'Pending') {
                        $a = 'Proses';
                        $icon = "fa-hourglass-end faa-ring animated";
                        $btn = "btn-warning ";
                        $alt = "Ganti Proses";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi proses, Apa anda yakin?')\"><span class='fa $icon' ></span> Pending</a>";
                      } elseif ($r['status'] == 'Proses') {
                        $a = 'Selesai';
                        $icon = "fa-spinner faa-spin animated";
                        $btn = "btn-info";
                        $alt = "Ganti Selesaikan";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi selesai, Apa anda yakin?')\"><span class='fa $icon'></span> Proses</a>";
                      } elseif ($r['status'] == 'Selesai') {
                        $a = 'Batal';
                        $icon = "fa-check faa-shake animated";
                        $btn = "btn-success";
                        $alt = "Ganti Batalkan";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi batal, Apa anda yakin?')\"><span class='fa $icon'></span> Selesai</a>";
                      } else {
                        $a = 'Pending';
                        $icon = "fa-close faa-ring animated";
                        $btn = "btn-danger";
                        $alt = "Ganti Pending";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi pending, Apa anda yakin?')\"><span class='fa $icon'></span> Batal</a>";
                      }
                      $harga = $r['harga'] * $r['kuantitas'];
                      echo "<tr>
                              <td>$r[idProject]</td>
                              <td >$r[nmProject]</td>
                              <td >$r[nmMitra]</td>
                              <td>$onoff</td>
                              <td>
                              <a class='btn btn-primary btn-xs' title='Input' href='?view=keuangan_project&act=invoice&id=$r[idProject]'><span class='fa fa-align-center'></span> Input Item </a>
                              <a class='btn btn-warning btn-xs' title='Bayar' href='?view=keuangan_project&act=bayar&id=$r[idProject]'><span class='fa fa-money'></span> Input Bayar</a>
                              <a class='btn btn-info btn-xs' title='Cetak Data' target='_blank' href='./cetak_invoice.php?id=$r[idProject]'><span class='glyphicon glyphicon-print'></span> Cetak Invoice</a>
                              <a class='btn btn-success btn-xs' title='Edit Data' href='?view=keuangan_project&act=edit&id=$r[idProject]'><span class='glyphicon glyphicon-edit'></span>Edit</a>
                              <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=keuangan_project&hapus&id=$r[idProject]' onclick=\"return confirm('Menghapus data project, juga menghapus data item di dalamnya, Apa anda yakin?')\"><span class='glyphicon glyphicon-remove'></span>Hapus</a>
                              </td>";
                      echo "</tr>";
                      $no++;
                    }
                    if (isset($_GET['hapus'])) {
                      $query = mysqli_query($conn, "DELETE FROM project where idProject='$_GET[id]'");
                      $querys = mysqli_query($conn, "DELETE FROM invoice where idProject='$_GET[id]'");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_project&sukseshapus';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_project&gagalhapus';</script>";
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>


            <div class="tab-pane" id="tab_4">
              <!-- List Tagihan Lainnya (Bebas) -->
              <div class="box-body table-responsive">
                <table class="table table-bordered" style="white-space: nowrap;">
                  <thead>
                    <tr class="info">
                      <th width="10px">ID Project</th>
                      <th width="180px">Nama Project</th>
                      <th width="180px">Nama Client</th>
                      <th colspan="3" align="center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    if (isset($_POST['ganti'])) {

                      $query = mysqli_query($conn, "UPDATE project SET  status='$_POST[link]'
                       where idProject = '$_POST[id]' ");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_project&sukses';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_project&gagal';</script>";
                      }
                    }
                    $no = 1;
                    $tampils = mysqli_query($conn, "SELECT project.*, nmProject,nmMitra,status FROM project 
                    INNER JOIN mitra ON project.idClient=mitra.id
                    WHERE project.status='Batal'
                  ORDER BY status ASC");
                    while ($r = mysqli_fetch_array($tampils)) {
                      if ($r['status'] == 'Batal') {
                        $a = 'Pending';
                        $icon = "fa-close faa-ring animated";
                        $btn = "btn-danger ";
                        $alt = "Ganti Proses";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi pending, Apa anda yakin?')\"><span class='fa $icon' ></span> Batal</a>";
                      } elseif ($r['status'] == 'Proses') {
                        $a = 'Selesai';
                        $icon = "fa-spinner faa-spin animated";
                        $btn = "btn-info";
                        $alt = "Ganti Selesaikan";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi selesai, Apa anda yakin?')\"><span class='fa $icon'></span> Proses</a>";
                      } elseif ($r['status'] == 'Selesai') {
                        $a = 'Batal';
                        $icon = "fa-check faa-shake animated";
                        $btn = "btn-success";
                        $alt = "Ganti Batalkan";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi batal, Apa anda yakin?')\"><span class='fa $icon'></span> Selesai</a>";
                      } else {
                        $a = 'Proses';
                        $icon = "fa-close faa-ring animated";
                        $btn = "btn-danger";
                        $alt = "Ganti Proses";
                        $onoff = "<a class='btn $btn btn-xs' title='$alt' href='?view=keuangan_project&act=onoff&id=$r[idProject]&a=$a' onclick=\"return confirm('Mengganti status menjadi pending, Apa anda yakin?')\"><span class='fa $icon'></span> Batal</a>";
                      }
                      $harga = $r['harga'] * $r['kuantitas'];
                      echo "<tr>
                              <td>$r[idProject]</td>
                              <td >$r[nmProject]</td>
                              <td >$r[nmMitra]</td>
                              <td>$onoff</td>
                              <td>
                              <a class='btn btn-primary btn-xs' title='Input' href='?view=keuangan_project&act=invoice&id=$r[idProject]'><span class='fa fa-align-center'></span> Input Item </a>
                              <a class='btn btn-warning btn-xs' title='Bayar' href='?view=keuangan_project&act=bayar&id=$r[idProject]'><span class='fa fa-money'></span> Input Bayar</a>
                              <a class='btn btn-info btn-xs' title='Cetak Data' target='_blank' href='./cetak_invoice.php?id=$r[idProject]'><span class='glyphicon glyphicon-print'></span> Cetak Invoice</a>
                              <a class='btn btn-success btn-xs' title='Edit Data' href='?view=keuangan_project&act=edit&id=$r[idProject]'><span class='glyphicon glyphicon-edit'></span>Edit</a>
                              <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=keuangan_project&hapus&id=$r[idProject]' onclick=\"return confirm('Menghapus data project, juga menghapus data item di dalamnya, Apa anda yakin?')\"><span class='glyphicon glyphicon-remove'></span>Hapus</a>
                              </td>";
                      echo "</tr>";
                      $no++;
                    }
                    if (isset($_GET['hapus'])) {
                      $query = mysqli_query($conn, "DELETE FROM project where idProject='$_GET[id]'");
                      $querys = mysqli_query($conn, "DELETE FROM invoice where idProject='$_GET[id]'");
                      if ($query) {
                        echo "<script>document.location='?view=keuangan_project&sukseshapus';</script>";
                      } else {
                        echo "<script>document.location='?view=keuangan_project&gagalhapus';</script>";
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
          <br><br>
        <?php
      } elseif ($_GET['act'] == 'onoff') {
        $a = $_GET['a'];
        $query = mysqli_query($conn, "UPDATE project SET status='$a' where idProject = '$_GET[id]'");

        if ($query) {
          echo "<script>document.location='index.php?view=keuangan_project';</script>";
        } else {
          echo "<script>document.location='index.php?view=keuangan_project';</script>";
        }
      } elseif ($_GET['act'] == 'edit') {
        if (isset($_POST['update'])) {

          $query = mysqli_query($conn, "UPDATE project SET idPenerimaan='$_POST[idPenerimaan]', 
                        nmProject='$_POST[nmProject]' ,idClient='$_POST[idClient]'
                        ,detail='$_POST[detil]',mulai='$_POST[tgl1]',berakhir='$_POST[tgl2]', idProgrammer='$_POST[idProgrammer]'
										 where idProject='$_POST[id]'");
          if ($query) {
            echo "<script>document.location='?view=keuangan_project&sukses';</script>";
          } else {
            echo "<script>document.location='?view=keuangan_project&gagal';</script>";
          }
        }
        $edit = mysqli_query($conn, "SELECT * FROM project where idProject='$_GET[id]'");
        $record = mysqli_fetch_array($edit);
        ?>

          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"> Edit Data Project</h3>
              </div><!-- /.box-header -->

              <div class="box-body">
                <form method="post" action="" class="form-horizontal">

                  <input type="hidden" name="id" class="form-control" value="<?php echo $record['idProject']; ?>" required>

                  <div class="col-md-6">
                    <label for="" class=" control-label">Jenis Penerimaan</label>
                    <select id="kelas" name='idPenerimaan' class="form-control">
                      <option value="" selected> - Pilih Jenis Peneriman - </option>

                      <?php
                      $sqk = mysqli_query($conn, "SELECT * FROM jenis_penerimaan ORDER BY idPenerimaan ASC");
                      while ($k = mysqli_fetch_array($sqk)) {
                        $selected = ($k['idPenerimaan'] == $record['idPenerimaan']) ? ' selected="selected"' : "";
                        echo '<option value="' . $k['idPenerimaan'] . '" ' . $selected . '>' . $k['nmPenerimaan'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="" class="control-label">Client </label>
                    <select id="kelas" name='idClient' class="form-control">
                      <option value="" selected> - Pilih Client - </option>

                      <?php
                      $sqk = mysqli_query($conn, "SELECT * FROM mitra ORDER BY id ASC");
                      while ($k = mysqli_fetch_array($sqk)) {
                        $selected = ($k['id'] == $record['idClient']) ? ' selected="selected"' : "";

                        echo '<option value="' . $k['id'] . '" ' . $selected . '>' . $k['nmMitra'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="" class=" control-label">Nama</label>
                    <input type="text" name="nmProject" class="form-control" value="<?php echo $record['nmProject']; ?>" required>
                  </div>

                  <div class="col-md-6">
                    <label for="" class=" control-label">Tanggal Mulai Project</label>
                    <input type="text" name="tgl1" class="form-control pull-right date-picker" id="" value="<?php echo $record['mulai']; ?>" required>
                  </div>
                  <div class="col-md-6">
                    <label for="" class="control-label">Tanggal Selesai Project</label>
                    <input type="text" name="tgl2" class="form-control pull-right date-picker" id="" value="<?php echo $record['berakhir']; ?>" required>
                  </div>
                  <div class="col-md-6">
                    <label for="" class="control-label">Programmer </label>
                    <select id="kelas" name='idProgrammer' class="form-control">
                      <option value="" selected> - Pilih Programmer - </option>

                      <?php
                      $sqk = mysqli_query($conn, "SELECT * FROM programmer ORDER BY idProgrammer ASC");
                      while ($k = mysqli_fetch_array($sqk)) {
                        $selected = ($k['idProgrammer'] == $record['idProgrammer']) ? ' selected="selected"' : "";

                        echo '<option value="' . $k['idProgrammer'] . '" ' . $selected . '>' . $k['nmProgrammer'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>


                  <br>
                  <div class="col-md-12">
                    <label for="" class="control-label">Detail Project</label>
                    <div class="md-form amber-textarea active-amber-textarea">
                      <textarea id="form19" style="resize:none;width:950px;height:190px;" class="md-textarea form-control ckeditor" name="detil" rows="3"> <?php echo $record['detail']; ?></textarea>

                    </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label"></label>
                    <div class="col-sm-12">
                      <input type="submit" name="update" value="Update" class="btn btn-success pull-right">
                      <a href="?view=keuangan_project" class="btn btn-default pull-left">Cancel</a>
                    </div>
                  </div>
                </form>


              </div>

            </div>
          </div>
        <?php
      } elseif ($_GET['act'] == 'bayar') {
        if (isset($_POST['simpan'])) {
          $idPenerimaan = $_POST['idPenerimaan'];
          $caraBayar = $_POST['idBank'];
          $idProject = $_POST['idProject'];
          $penerimaan = $_POST['penerimaan'];
          $ket = $_POST['ket'];
          $tgl = $_POST['tgl'];

          $query = mysqli_query($conn, "INSERT INTO jurnal_umums(tgl,ket,idPenerimaan,penerimaan,idProject,caraBayar) VALUES('$tgl','$ket','$idPenerimaan','$penerimaan','$idProject','$caraBayar')");
          //update saldo bank
          $query_saldo = mysqli_query($conn, "SELECT * FROM bank WHERE id ='$caraBayar' ");
          $saldo = mysqli_fetch_array($query_saldo);
          $saldoo =  $saldo['saldo'] + $penerimaan;
          mysqli_query($conn, "UPDATE bank SET saldo = '$saldoo'
                                WHERE id = '$caraBayar' ");
          if ($query) {
            echo "<script>document.location='?view=keuangan_project&sukses';</script>";
          } else {
            echo "<script>document.location='?view=keuangan_project&gagal';</script>";
          }
        }

        $edits = mysqli_query($conn, "SELECT sum(penerimaan) as jumlah FROM jurnal_umums where idProject='$_GET[id]' ");
        $records = mysqli_fetch_array($edits);

        $edit = mysqli_query($conn, "SELECT * FROM project where idProject='$_GET[id]' ");
        $record = mysqli_fetch_array($edit);
        ?>
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"> Tambah Pembayaran Project : <b> <?php echo $record['nmProject']; ?></b></h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <form method="post" action="" class="form-horizontal">
                  <input type="hidden" name="idProject" value="<?php echo $record['idProject']; ?>">
                  <input type="hidden" name="idPenerimaan" value="<?php echo $record['idPenerimaan']; ?>">
                  <div class="box-header with-border">
                    <?php $tampil = mysqli_fetch_array(mysqli_query($conn, "SELECT sum(harga) as Harga, diskon as Diskon ,pajak as Pajak, kuantitas as Kuantitas FROM invoice 
                                      INNER JOIN item ON invoice.id=item.id
                                      INNER JOIN project ON invoice.idProject=project.idProject where
                                      project.idProject='$_GET[id]' "));
                    ?>
                    <a class='btn btn-danger btn-md'>Jumlah Tagihan : <?php echo buatRp($tampil['Harga'] * $tampil['Kuantitas'] - $tampil['Diskon'] - $tampil['Pajak'] - $records['jumlah']); ?></a>
                    <div class="col-md-3 pull-right">
                      <div class="input-group date">
                        <input type="text" name="tgl" class="form-control pull-right date-picker" value="<?php echo date('Y-m-d'); ?>" readonly>
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Nama Penerimaan</label>
                    <div class="col-sm-4">
                      <select id="kelas" name='ket' class="form-control">
                        <option value="" selected> - Pilih Jenis Peneriman - </option>
                        <?php
                        $sqk = mysqli_query($conn, "SELECT * FROM jenis_penerimaan ORDER BY idPenerimaan ASC");
                        while ($k = mysqli_fetch_array($sqk)) {
                          $selected = ($k['idPenerimaan'] == $record['idPenerimaan']) ? ' selected="selected"' : "";
                          echo '<option value="' . $k['nmPenerimaan'] . ' - ' . $record['nmProject'] . '" ' . $selected . '>' . $k['nmPenerimaan'] . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Cara Bayar</label>
                    <div class="col-sm-4">
                      <select name="idBank" class="form-control">
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
                    <label for="" class="col-sm-2 control-label">Jumlah Pembayaran</label>
                    <div class="col-sm-4">
                      <input type="text" name='penerimaan' id="uang" placeholder='Jumlah Pembayaran' class="form-control" onkeypress="return isNumber(event)" required />
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                      <input type="submit" name="simpan" value="Simpan" class="btn btn-success">
                      <a href="?view=keuangan_project" class="btn btn-default">Cancel</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 class="box-title"> Riwayat Pembayaran Project</h3>
                <!-- <a class='pull-right btn btn-primary btn-sm' href='index.php?view=jurnalumum&act=tambah'>Tambahkan Data</a> -->
              </div><!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">

                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Tanggal</th>

                        <th>Pembayaran</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($_SESSION['notif'] == 'gagal_nominal_transaksi') {
                        echo '<script>toastr["error"]("Nominal Pengeluaran melebihi Rencana Anggaran.","Gagal!")</script>';
                      }
                      unset($_SESSION['notif']);

                      $tampil = mysqli_query($conn, "SELECT
												jurnal_umums.*,
												project.nmProject
											FROM
												jurnal_umums
											INNER JOIN project ON jurnal_umums.idProject = project.idProject
                      where project.idProject='$_GET[id]'  ORDER BY jurnal_umums.tgl DESC ");
                      $no = 1;
                      while ($r = mysqli_fetch_array($tampil)) {
                        echo "<tr><td>$no</td>
                              <td>" . tgl_indo($r['tgl']) . "</td>
                              <td>" . buatRp($r['penerimaan']) . "</td>
							                 <td>$r[ket]</td>
                              <td><center>
                              <a class='btn btn-info btn-xs' title='Cetak Data' target='_blank' href='./cetak_kwitansi.php?id=$r[idProject]&ids=$r[id]'><span class='glyphicon glyphicon-print'></span> Cetak Kwitansi</a>
                              </center></td>";
                        echo "</tr>";
                        $no++;
                      }
                      if (isset($_GET['hapus'])) {
                        mysqli_query($conn, "DELETE FROM jurnal_umum where id='$_GET[id]'");
                        echo "<script>document.location='index.php?view=jurnalumum';</script>";
                      }
                      ?>
                    </tbody>
                  </table>
                  <div class="box-footer">
                    <a class="btn btn-danger" target="_blank" href="./cetak_kwitansi_semua.php?id=<?php echo $_GET['id']; ?>"><span class="glyphicon glyphicon-print"></span> Cetak Semua Kwitansi</a>
                  </div>
                </div><!-- /.box-body -->

              </div><!-- /.box -->
            </div>
          </div>
        <?php
      } elseif ($_GET['act'] == 'invoice') {
        if (isset($_POST['simpan'])) {

          $id = $_POST['id'];
          $nData = count($id);
          $idProject = $_POST['idProject'];
          $kuantitas = $_POST['kuantitas'];

          $diskon = $_POST['diskon'];
          $pajak = $_POST['pajak'];

          for ($i = 0; $i < $nData; $i++) {
            $ids = $id[$i];
            $cek = mysqli_query($conn, "SELECT * FROM invoice where idProject='$idProject' AND id='$ids'");
            $total = mysqli_num_rows($cek);
            if ($total >= 1) {
              $query = mysqli_query($conn, "UPDATE invoice SET kuantitas = '$kuantitas', diskon='$diskon', pajak='$pajak' where idProject='$idProject' AND id='$ids'");
            } else {
              $query = mysqli_query($conn, "INSERT INTO invoice(idProject,id,kuantitas,diskon,pajak) VALUES('$idProject','$ids','$kuantitas','$diskon','$pajak')");
            }
          }

          if ($query) {
            echo "<script>document.location='?view=keuangan_project&sukses';</script>";
          } else {
            echo "<script>document.location='?view=keuangan_project&gagal';</script>";
          }
        }
        $edit = mysqli_query($conn, "SELECT * FROM project where idProject='$_GET[id]'");
        $edits = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM project where idProject='$_GET[id]'"));
        $iti = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM invoice where idProject='$_GET[id]'"));

        ?>
          <div class="col-md-8">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"> Tambah Item Project : <b> <?php echo $edits['nmProject']; ?></b></h3>
              </div><!-- /.box-header -->

              <div class="box-body">


                <form method="post" action="" class="form-horizontal">
                  <?php
                  $no = 1;
                  while ($ft = mysqli_fetch_array($edit)) {
                  ?>
                    <input type="hidden" name="idProject" value="<?php echo $ft['idProject']; ?>">

                    <div class="col-sm-9">
                      <label for="" class=" control-label">Pilih Beberapa Item </label>


                      <div class="form-group">

                        <select id="demo1" class="form-control " multiple="multiple" name="id[]" style="width: 620px; height: 400px">
                          <?php

                          $sqk = mysqli_query($conn, "SELECT * FROM item ORDER BY id ASC");
                          while ($k = mysqli_fetch_array($sqk)) {
                            $selected = ($k['id'] ==  $iti['id']) ? ' selected="selected"' : "";

                            echo "<option value=" . $k['id'] . " " . $selected . ">" . $k['nmItem'] . " - " . buatRp($k['harga']) . "</option>";
                          }
                          ?>


                        </select>



                      </div>
                    </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box box-warning">
              <div class="box-header with-border">
                <h3 class="box-title"> </h3>
              </div><!-- /.box-header -->
              <div class="box-body">

                <div class="col-sm-12">
                  <label for="" class="control-label">Kuantitas</label>

                  <input type="text" name="kuantitas" placeholder="Kuantitas" class="form-control" required />


                </div>
                <div class="col-sm-12">
                  <label for="" class=" control-label">Diskon</label>

                  <input type="text" name="diskon" placeholder="Input Diskon" class="form-control" />


                </div>
                <div class="col-sm-12">
                  <label for="" class="control-label">Pajak</label>

                  <input type="text" name="pajak" placeholder="pajak" class="form-control" />


                </div>
              <?php $no++;
                  } ?>
              <div class="form-group">
                <label for="" class="col-sm-2 control-label"></label>
                <div class="col-sm-12">
                  <input type="submit" name="simpan" value="Simpan" class="btn btn-success pull-left">
                  <a href="?view=keuangan_project" class="btn btn-default pull-right">Cancel</a>
                </div>
              </div>

              </form>
              </div>
            </div>

          <?php
        } elseif ($_GET['act'] == 'editinvoice') {
          if (isset($_POST['simpan'])) {
            $id = $_POST['id'];
            $nData = count($id);
            $idProject = $_POST['idProject'];
            $kuantitas = $_POST['kuantitas'];
            $diskon = $_POST['diskon'];
            $pajak = $_POST['pajak'];
            $query = mysqli_query($conn, "UPDATE invoice SET kuantitas='$kuantitas',diskon='$diskon',pajak='$pajak' where idProject='$_GET[id]'");
            if ($query) {
              echo "<script>document.location='?view=keuangan_project&sukses';</script>";
            } else {
              echo "<script>document.location='?view=keuangan_project&gagal';</script>";
            }
          }
          $edit = mysqli_query($conn, "SELECT * FROM project where idProject='$_GET[id]'");
          $edits = mysqli_query($conn, "SELECT * FROM invoice where idProject='$_GET[id]'");

          ?>
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"> Edit Item Project </b></h3>
                </div><!-- /.box-header -->

                <div class="box-body">


                  <form method="post" action="" class="form-horizontal">
                    <?php
                    $no = 1;
                    while ($ft = mysqli_fetch_array($edits)) {
                    ?>
                      <input type="hidden" name="idProject" value="<?php echo $ft['idProject']; ?>">





                      <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Kuantitas</label>
                        <div class="col-sm-4">
                          <input type="text" name="kuantitas" value="<?php echo $ft['kuantitas']; ?>" class="form-control" required />

                        </div>
                      </div>
                      <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Diskon</label>
                        <div class="col-sm-4">
                          <input type="text" name="diskon" value="<?php echo $ft['diskon']; ?>" class="form-control" />

                        </div>
                      </div>
                      <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Pajak</label>
                        <div class="col-sm-4">
                          <input type="text" name="pajak" value="<?php echo $ft['pajak']; ?>" class="form-control" />

                        </div>
                      </div>
                    <?php $no++;
                    } ?>
                    <div class="form-group">
                      <label for="" class="col-sm-2 control-label"></label>
                      <div class="col-sm-10">
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-success">
                        <a href="?view=keuangan_project" class="btn btn-default">Cancel</a>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php
        } elseif ($_GET['act'] == 'tambah') {
          if (isset($_POST['tambah'])) {
            $query = mysqli_query($conn, "INSERT INTO project(idProject,idPenerimaan,nmProject,idClient,detail,mulai,berakhir,idProgrammer) 
            VALUES('$_POST[idProject]','$_POST[idPenerimaan]','$_POST[nmProject]','$_POST[idClient]',
            '$_POST[detil]','$_POST[tgl1]','$_POST[tgl2]','$_POST[idProgrammer]')");
            if ($query) {
              echo "<script>document.location='?view=keuangan_project&sukses';</script>";
            } else {
              echo "<script>document.location='?view=keuangan_project&gagal';</script>";
            }
          }
          ?>

            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"> Tambah Data Project </h3>
                </div><!-- /.box-header -->
                <div class="box-body">

                  <form method="POST" action="" class="form-horizontal" enctype="multipart/form-data" method="POST">

                    <?php
                    $query = mysqli_query($conn, "SELECT max(idProject) as maxId FROM project ");
                    $data = @mysqli_fetch_array($query);
                    $idMax = $data['maxId'];

                    $noUrut = (int) substr($idMax, 4, 4);
                    $noUrut++;
                    $char = "JKDT";
                    $newID = $char . sprintf("%04s", $noUrut);
                    ?>
                    <div class="form-group">
                      <div class="col-md-6">
                        <label for="" class="control-label">ID Project</label>
                        <input type="text" class="form-control" disabled value="<?php echo $newID; ?>" />
                        <input type="hidden" class="form-control" name="idProject" value="<?php echo $newID; ?>" />
                      </div>
                      <div class="col-md-6">

                        <label for="" class="control-label">Jenis Penerimaan</label>

                        <select id="kelas" name='idPenerimaan' class="form-control">
                          <option value="" selected> - Pilih Jenis Peneriman - </option>

                          <?php
                          $sqk = mysqli_query($conn, "SELECT * FROM jenis_penerimaan ORDER BY idPenerimaan ASC");
                          while ($k = mysqli_fetch_array($sqk)) {
                            echo "<option value=" . $k['idPenerimaan'] . ">" . $k['nmPenerimaan'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="" class="control-label">Client </label>

                        <select id="kelas" name='idClient' class="form-control">
                          <option value="" selected> - Pilih Client - </option>

                          <?php
                          $sqk = mysqli_query($conn, "SELECT * FROM mitra ORDER BY id ASC");
                          while ($k = mysqli_fetch_array($sqk)) {
                            echo "<option value=" . $k['id'] . ">" . $k['nmMitra'] . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="" class=" control-label">Nama Project</label>
                        <input type="text" name="nmProject" class="form-control" id="" placeholder="Nama Project" required>
                      </div>

                      <div class="col-md-6">
                        <label for="" class=" control-label">Tanggal Mulai Project</label>
                        <input type="date" name="tgl1" class="form-control" id="" value="<?php echo date('Y-m-d'); ?>" required>
                      </div>
                      <div class="col-md-6">
                        <label for="" class="control-label">Tanggal Selesai Project</label>
                        <input type="date" name="tgl2" class="form-control" id="" value="<?php echo date('Y-m-d'); ?>" required>
                      </div>
                      <div class="col-md-6">
                        <label for="" class="control-label">Programmer </label>
                        <select id="kelas" name='idProgrammer' class="form-control">
                          <option value="" selected> - Pilih Programmer - </option>

                          <?php
                          $sqk = mysqli_query($conn, "SELECT * FROM programmer ORDER BY idProgrammer ASC");
                          while ($k = mysqli_fetch_array($sqk)) {
                            $selected = ($k['idProgrammer'] == $record['idProgrammer']) ? ' selected="selected"' : "";

                            echo '<option value="' . $k['idProgrammer'] . '" ' . $selected . '>' . $k['nmProgrammer'] . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                      <br>
                      <div class="col-md-12">
                        <label for="" class="control-label">Detail Project</label>
                        <div class="md-form amber-textarea active-amber-textarea">
                          <textarea id="form19" style="resize:none;width:980px;height:190px;" class="md-textarea form-control" name="detil" rows="3"></textarea>

                        </div>
                      </div>


                    </div>



                    <div class="form-group">
                      <label for="" class="col-sm-2 control-label"></label>
                      <div class="col-sm-12">
                        <input type="submit" name="tambah" value="Simpan" class="btn btn-success pull-right">
                        <a href="?view=keuangan_project" class="btn btn-default pull-left">Cancel</a>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            <?php
          }
            ?>