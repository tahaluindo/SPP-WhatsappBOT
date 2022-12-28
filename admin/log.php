<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">

        <!-- <a class="pull-left btn btn-success btn-sm" target="_blank" href="./excel_laporan_mitra.php"><span class="fa fa-file-excel-o"></span> Export ke Excel</a>
		<span>
        <a class='pull-right btn btn-primary btn-sm' href='?view=mitra&act=tambah'>Tambahkan Data</a> -->
      </div><!-- /.box-header -->
      <div class="box-body">
        <!-- <div class='alert alert-warning alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Perhatian!</strong> - Data yang muncul adalah data client yang sudah memiliki project, untuk melihat data keseluruhan client silahkan export via excel..
                          </div> -->
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
                <th>Nama User</th>
                <th>Aksi</th>
                <th>Menu</th>
                <th>Waktu</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $tampil = mysqli_query($conn, " SELECT * FROM log order by id DESC");
              $no = 1;
              while ($r = mysqli_fetch_array($tampil)) {
                if ($r['kategori'] == 'Tambah') {
                  $icon = "fa fa-plus";
                  $btn = "btn-info ";
                  $onoff = "<a class='btn $btn btn-xs' title='$alt' href='#'> <i  class='$icon'></i> Tambah Data</a>";
                } elseif ($r['kategori'] == 'Edit') {
                  $icon = "fa fa-pencil";
                  $btn = "btn-warning ";
                  $onoff = "<a class='btn $btn btn-xs' title='$alt' href='#'> <i  class='$icon'></i> Edit Data</a>";
                  } elseif ($r['kategori'] == 'Login') {
                  $icon = "fa fa-sign-in";
                  $btn = "btn-success ";
                  $onoff = "<a class='btn $btn btn-xs' title='$alt' href='#'> <i  class='$icon'></i> Login</a>";
                } else {
                  $icon = "fa fa-trash";
                  $btn = "btn-danger ";
                  $onoff = "<a class='btn $btn btn-xs' title='$alt' href='#'> <i  class='$icon'></i> Hapus Data</a>";
                }

                echo "<tr><td>$no</td>
                              <td>$r[username]</td>
                             
                              <td>$onoff</td>
                              <td>$r[action]</td>
                              <td>$r[waktu] </td>
                              ";
                echo "</tr>";
                $no++;
              }


              ?>
            </tbody>
          </table>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>


  <?php
}
  ?>