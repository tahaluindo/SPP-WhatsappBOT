<?php if ($_GET['act'] == '') { ?>
    <div class="col-xs-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"> Data Administrator </h3>
                <a class='pull-right btn btn-primary btn-sm' href='?view=admin&act=tambah'>Tambahkan Data Admin</a>
            </div><!-- /.box-header -->
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
                            <th style='width:30px'>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>No Telpon</th>
                            <th>Level</th>
                            <th>PIN</th>
                            <th>Last Login</th>
                            <th style='width:70px'>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tampil = mysqli_query($conn, "SELECT * FROM users ORDER BY level ASC");
                        $no = 1;
                        while ($r = mysqli_fetch_array($tampil)) {
                            echo "<tr><td>$no</td>
                              <td>$r[username]</td>
                              <td>$r[nama_lengkap]</td>
                              <td>$r[email]</td>
                              <td>$r[no_telp]</td>
                              <td>$r[level]</td>
                              <td>$r[pin]</td>
                              <td>$r[last_login]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='?view=admin&act=edit&id=$r[username]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='?view=admin&hapus=$r[username]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>";
                            echo "</tr>";
                            $no++;
                        }
                        if (isset($_GET['hapus'])) {
                            mysqli_query($conn, "DELETE FROM users where username='$_GET[hapus]' AND username != 'admin'");
                            echo "<script>document.location='?view=admin';</script>";
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
        $passs = md5($_POST['password']);
        if (trim($_POST['password']) == '') {
            $query = mysqli_query($conn, "UPDATE users SET nama_lengkap = '$_POST[nama_lengkap]',
                                         email = '$_POST[email]',
                                         no_telp = '$_POST[telp]',
                                         /*level = '$_POST[level]',*/
										 blokir='$_POST[blokir]' where username = '$_POST[username]'");
        } else {
            $query = mysqli_query($conn, "UPDATE users SET password='$passs', 
										 nama_lengkap = '$_POST[nama_lengkap]',
                                         email = '$_POST[email]',
                                         no_telp = '$_POST[telp]',
                                         /*level = '$_POST[level]',*/
										 blokir='$_POST[blokir]' 
                                          where username = '$_POST[username]'");
        }
        if ($query) {
            echo "<script>document.location='?view=admin';</script>";
        } else {
            echo "<script>document.location='?view=admin';</script>";
        }
    }
    $edit = mysqli_query($conn, "SELECT * FROM users where username='$_GET[id]'");
    $record = mysqli_fetch_array($edit);
?>
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"> Edit Data Pengguna </h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form method="post" action="" class="form-horizontal">
                    <input type="hidden" name="username" value="<?php echo $record['username']; ?>">
                    <table class="table">
                        <tr>
                            <td width="200">Username</td>
                            <td>
                                <div class="col-sm-4">
                                    <input type="text" name="username" value="<?php echo $record['username']; ?>" class="form-control" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="200">Password</td>
                            <td>
                                <div class="col-sm-4">
                                    <input type="password" name="password" class="form-control" placeholder="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="200">Nama Lengkap</td>
                            <td>
                                <div class="col-sm-5">
                                    <input type="text" name="nama_lengkap" value="<?php echo $record['nama_lengkap']; ?>" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="200">Email</td>
                            <td>
                                <div class="col-sm-5">
                                    <input type="text" name="email" value="<?php echo $record['email']; ?>" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="200">No. Telpon</td>
                            <td>
                                <div class="col-sm-3">
                                    <input type="text" name="telp" value="<?php echo $record['no_telp']; ?>" class="form-control">
                                </div>
                            </td>
                        </tr>

                        <td width="200">Level</td>
                        <td>
                            <div class="col-sm-4">
                                <select name="level" class="form-control">
                                    <option value="<?php echo $record['level']; ?>" selected><?php echo $record['level']; ?></option>
                                    <option value="admin">Admin</option>
                                    <option value="bendahara">Bendahara</option>
                                    <option value="koperasi">Koperasi</option>

                                </select>
                            </div>
                        </td>

                        <tr>
                            <td width="200">Blokir</td>
                            <td>
                                <div class="col-sm-4">
                                    <select name="blokir" class="form-control">
                                        <option value="<?php echo $record['blokir']; ?>" selected><?php echo $record['blokir']; ?></option>
                                        <option value="Y">Y</option>
                                        <option value="N">N</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <div class="col-sm-4">
                                    <input type="submit" name="update" value="Update" class="btn btn-success">
                                    <a href="?view=index" class="btn btn-default">Cancel</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

<?php
} elseif ($_GET['act'] == 'tambah') {
    if (isset($_POST['tambah'])) {
        $passs = md5($_POST['password']);
        $query = mysqli_query($conn, "INSERT INTO users(username,password,nama_lengkap,email,no_telp,level,idKelas) VALUES('$_POST[username]','$passs','$_POST[nama_lengkap]','$_POST[email]','$_POST[telp]','$_POST[level]','$_POST[kelas]')");
        if ($query) {
            echo "<script>document.location='?view=admin&sukses';</script>";
        } else {
            echo "<script>document.location='?view=admin&gagal';</script>";
        }
    }
?>
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"> Tambah Data Administrator </h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form method="POST" action="" class="form-horizontal">
                    <table class="table">
                        <tr>
                            <td width="200">Username</td>
                            <td>
                                <div class="col-sm-4">
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="200">Password</td>
                            <td>
                                <div class="col-sm-4">
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="200">Nama Lengkap</td>
                            <td>
                                <div class="col-sm-5">
                                    <input type="text" name="nama_lengkap" class="form-control" required>
                                </div>
                            </td>
                        </tr>
                        <td width="200">Level</td>
                        <td>
                            <div class="col-sm-4">
                                <select name="level" class="form-control">
                                    <option value="<?php echo $record['level']; ?>" selected><?php echo $record['level']; ?></option>
                                    <option value="admin">Admin</option>
                                    <option value="bendahara">Bendahara</option>
                                    <option value="koperasi">Koperasi</option>
                                </select>
                            </div>
                        </td>

                        <tr>
                            <td width="200">Kelas </td>
                            <td>
                                <div class="col-sm-4">
                                    <p>Khusus Untuk Level Bendahara</p>
                                    <select name="kelas" class="form-control">
                                        <option value="">- Pilih Pos Bayar -</option>
                                        <?php
                                        $sqk = mysqli_query($conn, "SELECT * FROM pos_bayar ORDER BY idPosBayar ASC");
                                        while ($k = mysqli_fetch_array($sqk)) {
                                            echo "<option value=" . $k['idPosBayar'] . ">" . $k['nmPosBayar'] . "</option>";
                                        }
                                        ?>

                                </div>

                            </td>

                        </tr>
                        <td width="200">Email</td>
                        <td>
                            <div class="col-sm-5">
                                <input type="text" name="email" class="form-control" required>
                            </div>
                        </td>
                        </tr>
                        <tr>
                            <td width="200">No. Telpon</td>
                            <td>
                                <div class="col-sm-3">
                                    <input type="text" name="telp" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>
                                <div class="col-sm-4">
                                    <input type="submit" name="tambah" value="Simpan" class="btn btn-success">
                                    <a href="?view=admin" class="btn btn-default">Cancel</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>