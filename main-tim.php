<?php if ($_GET[view] == 'home' or $_GET[view] == '') {
        echo "<div class='row'>";
        include "tim/home_siswa.php";
        echo "</div>";
  } elseif ($_GET[view] == 'keuangan_hosting') {
        echo "<div class='row'>";
        include "admin/keuangan_hosting.php";
        echo "</div>";
    } elseif ($_GET[view] == 'rencana_project') {

        echo "<div class='row'>";
        include "admin/master_rencana_project.php";
        echo "</div>";
   } elseif ($_GET[view] == 'absentim') {

            echo "<div class='row'>";
            include "tim/absensi_tims.php";
            echo "</div>";
} elseif ($_GET[view] == 'surat_masuk') {
        echo "<div class='row'>";
        include "admin/surat_masuk.php";
        echo "</div>";
  } elseif ($_GET[view] == 'konten') {

        echo "<div class='row'>";
        include "admin/master_konten.php";
        echo "</div>";
} elseif ($_GET[view] == 'surat_keluar') {

        echo "<div class='row'>";
        include "admin/surat_keluar.php";
        echo "</div>";
} elseif ($_GET[view] == 'inventaris') {

        echo "<div class='row'>";
        include "admin/master_inventaris.php";
        echo "</div>";
} elseif ($_GET[view] == 'inventarismasuks') {

        echo "<div class='row'>";
        include "admin/master_inventaris_masuk.php";
        echo "</div>";
} elseif ($_GET[view] == 'inventariskeluar') {

        echo "<div class='row'>";
        include "admin/master_inventaris_keluar.php";
        echo "</div>";
} elseif ($_GET[view] == 'tim') {

        echo "<div class='row'>";
        include "tim/master_siswa.php";
        echo "</div>";
} elseif ($_GET[view] == 'mitra') {
        echo "<div class='row'>";
        include "admin/mitra.php";
        echo "</div>";
} elseif ($_GET[view] == 'item') {

        echo "<div class='row'>";
        include "admin/item.php";
        echo "</div>";
} elseif ($_GET[view] == 'keuangan_project') {
        echo "<div class='row'>";
        include "admin/keuangan_project.php";
        echo "</div>";
} elseif ($_GET[view] == 'laptanggungan') {

        echo "<div class='row'>";
        include "tim/laptanggungan.php";
        echo "</div>";
}
