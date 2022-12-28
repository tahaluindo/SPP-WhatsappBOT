<br> <br> <br> <br>
<h2> Jika Ingin Melihat Riwayat Transaksi Silahkan Isi Search Dengan Id Nasabah Anda </h2>
<div class="col-md-3 col-sm-12 col-xs-12" style="margin-left: 0px;">

  <h2>ID Nasabah Anda : <?php echo $_SESSION['id']; ?> </h2>
  <h2>Saldo : Rp.<?php echo rupiah($_SESSION['saldonya']); ?></h2>
</div>
<div class="divider-dashed"></div>
<div class="x_content">
  <table id="datatable" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th width="50">No</th>
        <th>ID Nasabah</th>
        <th>Id Transaksi</th>
        <th>Tanggal</th>
        <th>Debit</th>
        <th>Kredit</th>
        <th>Keterangan</th>

      </tr>
    </thead>
    <tbody>

      <?php
      $no = 0;
      $query = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id_nasabah DESC");
      while ($row = mysqli_fetch_array($query)) {
        $no++;

      ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $row['id_nasabah']; ?></td>
          <td><?php echo $row['id_transaksi']; ?></td>
          <td><?php echo $row['tanggal']; ?></td>
          <td><?php echo $row['debit']; ?></td>
          <td><?php echo $row['kredit']; ?></td>
          <td><?php echo ($row['keterangan']); ?></td>


        </tr>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</div>
</div>
</div>
</div>
</div>