<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">

        <a class="pull-left btn btn-success btn-sm" target="_blank" href="./excel_laporan_mitra.php"><span class="fa fa-file-excel-o"></span> Export ke Excel</a>
        <span>
          <a class='pull-right btn btn-primary btn-sm' href='?view=mitra&act=tambah'>Tambahkan Data</a>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class='alert alert-warning alert-dismissible fade in' role='alert'>
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>×</span></button> <strong>Perhatian!</strong> - Data yang muncul adalah data client yang sudah memiliki project, untuk melihat data keseluruhan client silahkan export via excel..
        </div>
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
                <th>Nama Mitra</th>
                <th>Link Mitra</th>
                <th>Alamat</th>
                <th>Nomor</th>
                <th>Email</th>
                <th>Jumlah Project</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $tampil = mysqli_query($conn, " SELECT project.idProject, COUNT(project.idProject) AS jumlah,nmProject,id,nmMitra,linkMitra,alamat,nomor ,email
            FROM mitra 
            JOIN project ON mitra.id=project.idClient
           	GROUP BY id ASC");
              $no = 1;
              while ($r = mysqli_fetch_array($tampil)) {
                echo "<tr><td>$no</td>
                              <td>$r[nmMitra]</td>
                              <td><a class='btn btn-primary btn-xs' title='Bayar' href='$r[linkMitra]' target='_blank'><span class='fa fa-code-fork'></span> Kunjungi</a>
                              </td>
                              <td>$r[alamat]</td>
                              <td>$r[nomor] </td>
                              <td>$r[email] </td>
                              <td>$r[jumlah] </td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=mitra&act=edit&id=$r[id]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=mitra&hapus&id=$r[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                              ";
                echo "</tr>";
                $no++;
              }
              if (isset($_GET['hapus'])) {
                mysqli_query($conn, "DELETE FROM mitra where id='$_GET[id]'");
                echo "<script>document.location='?view=mitra';</script>";
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

    $query = mysqli_query($conn, "UPDATE mitra SET nmMitra='$_POST[nmMitra]', 
										 linkMitra='$_POST[linkMitra]' ,alamat='$_POST[alamat]',kota='$_POST[kota]'
                     ,provinsi='$_POST[provinsi]',negara='$_POST[negara]',nmOrang='$_POST[nmOrang]',nomor='$_POST[nomor]',email='$_POST[email]'  where id = '$_POST[id]'");
    if ($query) {
      echo "<script>document.location='?view=mitra&sukses';</script>";
    } else {
      echo "<script>document.location='?view=mitra&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn, "SELECT * FROM mitra where id='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
  ?>
    <div class="col-md-8">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Edit Data Pokok</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form method="post" action="" class="form-horizontal">
            <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
            <div class="col-sm-6">
              <label for="" class="control-label">Nama Mitra</label>
              <input type="text" name="nmMitra" class="form-control" value="<?php echo $record['nmMitra']; ?>" required>
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Link Mitra</label>
              <input type="text" name="linkMitra" class="form-control" value="<?php echo $record['linkMitra']; ?>">
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Alamat</label>
              <input type="text" name="alamat" class="form-control" value="<?php echo $record['alamat']; ?>">
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Kota</label>
              <input type="text" name="kota" class="form-control" value="<?php echo $record['kota']; ?>">
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Provinsi</label>
              <input type="text" name="provinsi" class="form-control" value="<?php echo $record['provinsi']; ?>">
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Negara</label>
              <input type="text" name="negara" class="form-control" value="<?php echo $record['negara']; ?>">
            </div>



        </div>
      </div>

    </div>
    <div class="col-md-4">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Data Pemilik</h3>
        </div><!-- /.box-header -->
        <div class="box-body">


          <div class="col-sm-12">
            <label for="" class="control-label">Nama Pemilik</label>
            <input type="text" name="nmOrang" class="form-control" value="<?php echo $record['nmOrang']; ?>" required>
          </div>

          <div class="col-sm-12">
            <label for="" class=" control-label">Nomor WhatsApp</label>
            <input type="number" name="nomor" class="form-control" value="<?php echo $record['nomor']; ?>">
          </div>
          <div class="col-sm-12">
            <label for="" class=" control-label">Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo $record['email']; ?>">
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label"></label>
            <div class="col-sm-12">
              <input type="submit" name="update" value="Update" class="btn btn-success pull-right">
              <a href="?view=mitra" class="btn btn-default pull-left">Cancel</a>
            </div>
          </div>
          </form>
        </div>
      </div>

    </div>

  <?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST['tambah'])) {
    $query = mysqli_query($conn, "INSERT INTO mitra(nmMitra,linkMitra,alamat,kota,provinsi,negara,nmOrang,nomor,email) 
    VALUES('$_POST[nmMitra]','$_POST[linkMitra]','$_POST[alamat]','$_POST[kota]','$_POST[provinsi]','$_POST[negara]'
    ,'$_POST[nmOrang]','$_POST[nomor]','$_POST[email]')");
    if ($query) {
      echo "<script>document.location='?view=mitra&sukses';</script>";
    } else {
      echo "<script>document.location='?view=mitra&gagal';</script>";
    }
  }
  ?>
    <div class="col-md-8">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Tambah Data Pokok</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form method="post" action="" class="form-horizontal">

            <div class="col-sm-6">
              <label for="" class="control-label">Nama Mitra</label>
              <input type="text" name="nmMitra" class="form-control" id="" placeholder="Nama Mitra" required>
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Link Mitra</label>
              <input type="text" name="linkMitra" class="form-control" id="" placeholder="Link Mitra">
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Alamat</label>
              <input type="text" name="alamat" class="form-control" placeholder="Alamat Mitra">
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Kota</label>
              <input type="text" name="kota" class="form-control" placeholder="Kota Mitra">
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Provinsi</label>
              <input type="text" name="provinsi" class="form-control" placeholder="Provinsi Mitra">
            </div>
            <div class="col-sm-6">
              <label for="" class=" control-label">Negara</label>
              <input type="text" name="negara" class="form-control" placeholder="Negara Mitra">
            </div>
        </div>
      </div>

    </div>
    <div class="col-md-4">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"> Data Pemilik</h3>
        </div><!-- /.box-header -->
        <div class="box-body">


          <div class="col-sm-12">
            <label for="" class="control-label">Nama Pemilik</label>
            <input type="text" name="nmOrang" class="form-control" placeholder="Nama Pemilik" required>
          </div>

          <div class="col-sm-12">
            <label for="" class=" control-label">Nomor WhatsApp</label>
            <input type="number" name="nomor" class="form-control" placeholder="Nomor Whatsapp Mitra">
          </div>
          <div class="col-sm-12">
            <label for="" class=" control-label">Email</label>
            <input type="text" name="email" class="form-control" placeholder="Email Mitra">
          </div>
          <div class="form-group">
            <label for="" class="col-sm-2 control-label"></label>
            <div class="col-sm-12">
              <input type="submit" name="tambah" value="Simpan" class="btn btn-success pull-right">
              <a href="?view=mitra" class="btn btn-default pull-left">Cancel</a>
            </div>
          </div>

          </form>
        </div>
      </div>

    </div>

  <?php
}
  ?>