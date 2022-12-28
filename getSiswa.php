<?php
include "config/koneksi.php";

$kelas = $_POST['kelas'];
$siswa = mysqli_query($conn,"SELECT * FROM siswa WHERE idKelas='$kelas' ORDER BY nmSiswa ASC");
echo "<option value='semua'>- Semua Siswa -</option>";
while($ds = mysqli_fetch_array($siswa)){
	echo "<option value='$ds[idSiswa]'>$ds[nisSiswa] - $ds[nmSiswa]</option>";
}
