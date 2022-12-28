<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include "config/library.php";
include "config/fungsi_indotgl.php";
include "config/fungsi_seo.php";
if (isset($_SESSION['id'])) {
    if ($_SESSION['level'] == 'admin') {
        $iden = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users where username='$_SESSION[id]'"));
        $nama =  $iden['nama_lengkap'];
        $level = 'Administrator';
        $foto = 'dist/img/user.png';
    }

    $tgl_mulai = $_GET['tgl_mulai'];
    $tgl_akhir = $_GET['tgl_akhir'];


    $idKelas = $_GET['kelas'];
    if ($_GET['kelas'] != 'all') {
        $kls = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));
        $kelas = 'Kelas ' . $kls['nmKelas'];
    } else {
        $kelas = 'Semua Kelas';
    }
    $d = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kelas_siswa where idKelas='$_GET[kelas]'"));



    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=laporan_absen_" . date('dmyHis') . ".xls");
?>
    <?php
    $tgl_mulai = $_GET['tgl_mulai'];
    $tgl_akhir = $_GET['tgl_akhir'];



    $ta = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));



    ?>
    <table border="1">

        <h3 align='center'>Rekap Data Absensi TIM </b></h3>

        <h3></h3>

        <h4 class='box-title'>Dari Tanggal : <?php echo  tgl_indo($tgl_mulai); ?> Sampai <?php echo   tgl_indo($tgl_akhir); ?>

        </h4>


        <thead>
            <tr>
                <th rowspan='2'>No</th>

                <th rowspan='2'>Nama Siswa</th>

                <th rowspan='2'>Jabatan</th>

                <th colspan='6'>Keterangan</th>
                <th rowspan='2'>
                    <center>% Kehadiran</center>
                </th>
            </tr>
            <tr>
                <th>Total Waktu Kerja</th>
                <th>Hadir</th>
                <th>Terlambat</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpa</th>



            </tr>
        </thead>
        <tbody>
            <?php



            $tampil = mysqli_query($conn, "SELECT * FROM view_detil_siswa ORDER BY username");

            $no = 1;
            while ($r = mysqli_fetch_array($tampil)) {
                $total = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' "));
                $hadir = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' and nip='$r[username]' AND kode_kehadiran='H'"));
                $sakit = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' and nip='$r[username]' AND kode_kehadiran='S'"));
                $izin = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' and nip='$r[username]' AND kode_kehadiran='I'"));
                $alpa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' and nip='$r[username]' AND kode_kehadiran='A'"));
                $telat = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `rb_absensi_guru` where  DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' and nip='$r[username]' AND kode_kehadiran='T'"));
                $tambah = $hadir + $telat;
                $persen =  $tambah / ($total) * 100;
                echo "<tr bgcolor=$warna>
                <td align='center'>$no</td>
                <td>$r[nmSiswa]</td>
                <td align='center'>$r[ketKelas]</td>
                <td align=center>$total</td>
                <td align=center>$hadir</td>
                <td align=center>$telat</td>
                <td align=center>$sakit</td>
                <td align=center>$izin</td>
                <td align=center>$alpa</td>
                <td align=right>" . number_format($persen, 2) . " %</td>
               
               ";
                echo " 
    </tr>
    ";
                $no++;
            }

            echo " ";
            ?>

        </tbody>
    </table>
<?php
} else {
    include "login.php";
}
?>