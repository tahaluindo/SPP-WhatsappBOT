<?php
include "../config/koneksi.php";

//mysqli_query($conn,"ALTER TABLE `nama_table` ADD `nama_field` INT(2) NOT NULL AFTER nama_field");

mysqli_query($conn,"DROP VIEW IF EXISTS `view_laporan_bayar_bulanan`");
mysqli_query($conn,"CREATE VIEW `view_laporan_bayar_bulanan` AS SELECT
tagihan_bulanan.idTagihanBulanan AS idTagihanBulanan,
tagihan_bulanan.idJenisBayar AS idJenisBayar,
tagihan_bulanan.idSiswa AS idSiswa,
tagihan_bulanan.idKelas AS idKelas,
tagihan_bulanan.idBulan AS idBulan,
tagihan_bulanan.jumlahBayar AS jumlahBayar,
tagihan_bulanan.tglBayar AS tglBayar,
tagihan_bulanan.tglUpdate AS tglUpdate,
tagihan_bulanan.statusBayar AS statusBayar,
jenis_bayar.idTahunAjaran AS idTahunAjaran,
jenis_bayar.nmJenisBayar AS nmJenisBayar,
tahun_ajaran.nmTahunAjaran AS nmTahunAjaran,
siswa.nisSiswa AS nisSiswa,
siswa.nmSiswa AS nmSiswa,
kelas_siswa.nmKelas AS nmKelas,
bulan.nmBulan AS nmBulan,
bulan.urutan AS urutan,
tagihan_bulanan.caraBayar
from (((((`tagihan_bulanan` join `jenis_bayar` on((`tagihan_bulanan`.`idJenisBayar` = `jenis_bayar`.`idJenisBayar`))) join `tahun_ajaran` on((`jenis_bayar`.`idTahunAjaran` = `tahun_ajaran`.`idTahunAjaran`))) join `siswa` on((`tagihan_bulanan`.`idSiswa` = `siswa`.`idSiswa`))) join `kelas_siswa` on((`siswa`.`idKelas` = `kelas_siswa`.`idKelas`))) join `bulan` on((`tagihan_bulanan`.`idBulan` = `bulan`.`idBulan`)))");

// arahkan ke dashboard
header('location:./?alert=updb');
