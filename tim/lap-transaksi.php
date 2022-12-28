<?php if ($_GET[act] == '') { ?> <div class="col-xs-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"> Riwayat Pembayaran Bulanan Siswa </h3><br><br>
        <center>
          <p> Silahkan Filter Nama Anda di Kolom search untuk mengetahui riwayat transaksi anda </p>
        </center>
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
        }
        ?>mysqli_query($conn,"
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Siswa</th>
              <th>Bulan</th>
              <th>Nama Kelas</th>
              <th>Tanggal Bayar</th>
              <th>Jumlah Bayar</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $tampil = mysqli_query($conn,"SELECT * FROM view_laporan_bayar_bulanan ORDER BY idSiswa ASC");
            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
              echo "<tr><td>$no</td>
                              <td>$r[nmSiswa]</td>
                              <td>$r[nmBulan]</td>
                              <td>$r[nmKelas]</td>
							   <td>$r[tglBayar]</td>
							   <td> Rp. $r[jumlahBayar]</td>
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