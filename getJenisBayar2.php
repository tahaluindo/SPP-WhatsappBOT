<?php 
include "config/koneksi.php";

$tahun2 = $_POST['tahun2'];
$jenisBayar = mysqli_query($conn,"SELECT * FROM jenis_bayar WHERE idTahunAjaran='$tahun2' ORDER BY idJenisBayar ASC");
echo "<option value='all'>- Semua Jenis Bayar -</option>";
while($jb = mysqli_fetch_array($jenisBayar)){
	echo "<option value='$jb[idJenisBayar]'>$jb[nmJenisBayar]</option>";
}
