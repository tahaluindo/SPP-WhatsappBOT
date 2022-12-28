<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
$sqlSiswa = mysqli_query($conn,"SELECT * FROM view_detil_siswa WHERE idKelas='$_GET[kelas]' AND statusSiswa='Aktif' ORDER BY nmSiswa ASC");


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_siswa_" . str_replace(" ", "_", $kls['nmKelas']) . "_" . date('dmyHis') . ".xls");
?>
<table border="1">
	<thead>
		<tr>
			<th>No.</th>
			<th>NIS</th>
			<th>NISN</th>
			<th>Nama Siswa</th>
			<th>Jenis Kelamin</th>
			<th>Kelas</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no = 1;
		while ($ds = mysqli_fetch_array($sqlSiswa)) {
			echo "<tr>
				<td>$no</td>
				<td>$ds[nisSiswa]</td>
				<td>$ds[nisnSiswa]</td>
				<td>$ds[nmSiswa]</td>
				<td>$ds[jkSiswa]</td>
				<td>$ds[nmKelas]</td>
			</tr>";
			$no++;
		}
		?>
	</tbody>
</table>