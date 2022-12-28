<?php if ($_GET['act'] == '') { ?>
  <div class="col-xs-12">
    <div class="box box-warning">
      <div class="box-header with-border">

        <!-- <a class="pull-left btn btn-success btn-sm" target="_blank" href="./excel_laporan_item.php"><span class="fa fa-file-excel-o"></span> Export ke Excel</a>
		<span> -->
        <a class='pull-right btn btn-primary btn-sm' href='?view=item&act=tambah'>Tambahkan Data</a>
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
              <th>Nama Item</th>
              <th>Deskripsi</th>
              <th>Tipe</th>
              <th>Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $tampil = mysqli_query($conn, "SELECT * FROM item ORDER BY id ASC");
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
              echo "<tr><td>$no</td>
                              <td>$r[nmItem]</td>
                              <td>$r[rincian]</td>
                              <td>$r[tipe]</td>
                              <td>".buatRp($r['harga'])."</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=item&act=edit&id=$r[id]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=item&hapus&id=$r[id]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                              ";
              echo "</tr>";
              $no++;
            }
            if (isset($_GET['hapus'])) {
              mysqli_query($conn, "DELETE FROM item where id='$_GET[id]'");
              echo "<script>document.location='?view=item';</script>";
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

    $query = mysqli_query($conn, "UPDATE item SET nmItem='$_POST[nmItem]', 
										 rincian='$_POST[rincian]' ,tipe='$_POST[tipe]',harga='$_POST[harga]'
                      where id = '$_POST[id]'");
    if ($query) {
      echo "<script>document.location='?view=item&sukses';</script>";
    } else {
      echo "<script>document.location='?view=item&gagal';</script>";
    }
  }
  $edit = mysqli_query($conn, "SELECT * FROM item where id='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Edit Data Pokok</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="post" action="" class="form-horizontal">
          <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
          <div class="col-sm-6">
            <label for="" class="control-label">Nama Item</label>
            <input type="text" name="nmItem" class="form-control" value="<?php echo $record['nmItem']; ?>" required>
          </div>
         

          <div class="col-sm-6">
            <label for="" class=" control-label">Tipe</label>
            <input type="text" name="tipe" class="form-control" value="<?php echo $record['tipe']; ?>">
          </div>
          <div class="col-md-12">
            <label for="" class="control-label">Rincian Item</label>
            <div class="md-form amber-textarea active-amber-textarea">
              <textarea id="form19" style="resize:none;width:950px;height:190px;" class="md-textarea form-control ckeditor" name="rincian" rows="3"> <?php echo $record['rincian']; ?></textarea>

            </div>
          </div>
          <div class="col-sm-6">
            <label for="" class=" control-label">Harga</label>
            <input type="text" name="harga" class="form-control" value="<?php echo $record['harga']; ?>">
          </div>
        
          <div class="form-group">
          <label for="" class="col-sm-2 control-label"></label>
          <div class="col-sm-12">
            <input type="submit" name="update" value="Update" class="btn btn-success pull-right">
            <a href="?view=item" class="btn btn-default pull-left">Cancel</a>
          </div>
        </div>

      </div>
    </div>
    </form>
  </div>
 

   
    

<?php
} elseif ($_GET['act'] == 'tambah') {
  if (isset($_POST['tambah'])) {
    $query = mysqli_query($conn, "INSERT INTO item(nmItem,rincian,tipe,harga) 
    VALUES('$_POST[nmItem]','$_POST[rincian]','$_POST[tipe]','$_POST[harga]')");
    if ($query) {
      echo "<script>document.location='?view=item&sukses';</script>";
    } else {
      echo "<script>document.location='?view=item&gagal';</script>";
    }
  }
?>
  <div class="col-md-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title"> Tambah Data Pokok</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <form method="post" action="" class="form-horizontal">

          <div class="col-sm-6">
            <label for="" class="control-label">Nama item</label>
            <input type="text" name="nmItem" class="form-control" id="" placeholder="Nama item" required>
          </div>
          <div class="col-sm-6">
            <label for="" class=" control-label">Tipe</label>
            <input type="text" name="tipe" class="form-control" placeholder="Tipe item">
          </div>
          <div class="col-md-6">
            <label for="" class="control-label">Rincian Item</label>
            <div class="md-form amber-textarea active-amber-textarea">
              <textarea id="form19" style="resize:none;width:465px;height:100px;" class="md-textarea form-control" name="rincian" rows="3"></textarea>

            </div>
          </div>
         
          <div class="col-sm-6">
            <label for="" class=" control-label">Harga</label>
            <input type="text" name="harga" class="form-control" placeholder="Harga">
          </div>
          <div class="form-group">
          <label for="" class="col-sm-2 control-label"></label>
          <div class="col-sm-12">
            <input type="submit" name="tambah" value="Simpan" class="btn btn-success pull-right">
            <a href="?view=item" class="btn btn-default pull-left">Cancel</a>
          </div>
        </div>
      </div>
    </div>
</form>
  </div>
 

<?php
}
?>