<?php
include "../../config/koneksi.php";
$bebas_id = $_POST['bebas_id'];
for ($i = 0; $i < count($bebas_id); $i++) {
  $TB = mysqli_fetch_array(mysqli_query($conn, "SELECT tagihan_bebas.*,
                                                            jenis_bayar.idPosBayar,
                                                            jenis_bayar.idTahunAjaran,
                                                            pos_bayar.nmPosbayar,
															                              jenis_bayar.nmJenisBayar,
                                                            tahun_ajaran.nmTahunAjaran
                                                    FROM tagihan_bebas 
                                                    LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                    WHERE idTagihanBebas='$bebas_id[$i]'"));


?>

  <input class="form-control" name="id_tagihan_bebas[]" type="hidden" value="<?= $TB['idTagihanBebas'] ?>">
  <div class="form-group">
    <label>Nama Pembayaran</label>
    <input class="form-control" readonly="" name="nama_pos_bayar[]" type="text" value="<?= $TB['nmJenisBayar'] . ' - T.A ' . $TB['nmTahunAjaran'] . ' - ' . $TB['totalTagihan'] ?>  ">
  </div>
  <div class="form-group">
    <label>Cara Bayar *</label>
    <select name="caraBayar[]" class="form-control select-sm">';
      <?php $sqks = mysqli_query($conn, "SELECT * FROM bank ");
      while ($ks = mysqli_fetch_array($sqks)) {
        $selected = ($ks['id'] == $record['akun']) ? ' selected="selected"' : "";
        echo '<option value="' . $ks['id'] . '" ' . $selected . '>' . $ks['nmBank'] . ' - ' . $ks['atasNama'] . '</option>';
      }
      echo '</select>';
      ?>
  </div>
  <td>
    <label>Keterangan *</label>
    <select class="form-control" name="ketBayar[]" required>
      <option value="Lunas">Lunas</option>
      <option value="Angsuran 1">Angsuran 1</option>
      <option value="Angsuran 2">Angsuran 2</option>
      <option value="Angsuran 3">Angsuran 3</option>
      <option value="Angsuran 4">Angsuran 4</option>
      <option value="Angsuran 5">Angsuran 5</option>
    </select>
  </td>
  <div class="row">
    <div class="col-md-12">
      <label>Jumlah Bayar *</label>
      <input type="text" required="" name="nominal_bayar[]" id="nominal_bayar" class="form-control" placeholder="Jumlah Bayar">
    </div>

  </div>
  <hr>
<?php
}
?>