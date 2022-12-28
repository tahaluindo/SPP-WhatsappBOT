<?php 
include "config/koneksi.php";

$tahun1 = $_POST['tahun1'];
$jenisBayar = mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idTahunAjaran='$tahun1' ORDER BY idJenisBayar ASC");
echo "<option value='all'>- Semua Jenis Bayar -</option>";
while($jb = mysqli_fetch_array($jenisBayar)){
	echo "<option value='$jb[idJenisBayar]'>$jb[nmJenisBayar]</option>";
}
