<?php
if ($_GET['view'] == 'home' or $_GET['view'] == '') {
        echo "<div class='row'>";
        include "admin/home_admin_row.php";
        echo "</div>";
} elseif ($_GET['view'] == 'log') {

        echo "<div class='row'>";
        include "admin/log.php";
        echo "</div>";
} elseif ($_GET['view'] == 'bank') {

        echo "<div class='row'>";
        include "admin/master_bank.php";
        echo "</div>";
} elseif ($_GET['view'] == 'konten') {

        echo "<div class='row'>";
        include "admin/master_konten.php";
        echo "</div>";
} elseif ($_GET['view'] == 'rencana_project') {

        echo "<div class='row'>";
        include "admin/master_rencana_project.php";
        echo "</div>";
} elseif ($_GET['view'] == 'rekapabsen') {

        echo "<div class='row'>";
        include "admin/absensi_tim_rekap.php";
        echo "</div>";
} elseif ($_GET['view'] == 'absentim') {

        echo "<div class='row'>";
        include "tim/absensi_tim.php";
        echo "</div>";
} elseif ($_GET['view'] == 'surat_masuk') {

        echo "<div class='row'>";
        include "admin/surat_masuk.php";
        echo "</div>";
} elseif ($_GET['view'] == 'surat_keluar') {

        echo "<div class='row'>";
        include "admin/surat_keluar.php";
        echo "</div>";
} elseif ($_GET['view'] == 'pengaturan') {

        echo "<div class='row'>";
        include "admin/pengaturan_identitas.php";
        echo "</div>";
} elseif ($_GET['view'] == 'setor') {

        echo "<div class='row'>";
        include "admin/com_transaksi/setoran.php";
        echo "</div>";
} elseif ($_GET['view'] == 'programmer') {

        echo "<div class='row'>";
        include "admin/programmer.php";
        echo "</div>";
} elseif ($_GET['view'] == 'item') {

        echo "<div class='row'>";
        include "admin/item.php";
        echo "</div>";
} elseif ($_GET['view'] == 'inventaris') {

        echo "<div class='row'>";
        include "admin/master_inventaris.php";
        echo "</div>";
} elseif ($_GET['view'] == 'rencana') {

        echo "<div class='row'>";
        include "admin/keuangan_rencana.php";
        echo "</div>";
} elseif ($_GET['view'] == 'inventarismasuks') {

        echo "<div class='row'>";
        include "admin/master_inventaris_masuk.php";
        echo "</div>";
} elseif ($_GET['view'] == 'inventariskeluar') {

        echo "<div class='row'>";
        include "admin/master_inventaris_keluar.php";
        echo "</div>";
} elseif ($_GET['view'] == 'lapkas') {

        echo "<div class='row'>";
        include "admin/com_laporan/laporan-kas.php";
        echo "</div>";
} elseif ($_GET['view'] == 'kasmas') {

        echo "<div class='row'>";
        include "admin/com_kas/masuk.php";
        echo "</div>";
} elseif ($_GET['view'] == 'kaskel') {

        echo "<div class='row'>";
        include "admin/com_kas/keluar.php";
        echo "</div>";
} elseif ($_GET['view'] == 'tagihan1') {
        echo "<div class='row'>";
        include "admin/tagihan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'calendar') {
        echo "<div class='row'>";
        include "admin/calendar.php";
        echo "</div>";
} elseif ($_GET['view'] == 'mitra') {
        echo "<div class='row'>";
        include "admin/mitra.php";
        echo "</div>";
} elseif ($_GET['view'] == 'jenis_pengeluaran') {
        echo "<div class='row'>";
        include "admin/keuangan_jenis_pengeluaran.php";
        echo "</div>";
} elseif ($_GET['view'] == 'keuangan_project') {
        echo "<div class='row'>";
        include "admin/keuangan_project.php";
        echo "</div>";
} elseif ($_GET['view'] == 'keuangan_hosting') {
        echo "<div class='row'>";
        include "admin/keuangan_hosting.php";
        echo "</div>";
} elseif ($_GET['view'] == 'realisasi') {
        echo "<div class='row'>";
        include "admin/realisasi.php";
        echo "</div>";
} elseif ($_GET['view'] == 'jenis_penerimaan') {
        echo "<div class='row'>";
        include "admin/keuangan_jenis_penerimaan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'admin') {

        echo "<div class='row'>";
        include "admin/master_admin.php";
        echo "</div>";
} elseif ($_GET['view'] == 'tahun') {

        echo "<div class='row'>";
        include "admin/master_tahun.php";
        echo "</div>";
} elseif ($_GET['view'] == 'jabatan') {

        echo "<div class='row'>";
        include "admin/master_jabatan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'tim') {

        echo "<div class='row'>";
        include "admin/master_tim.php";
        echo "</div>";
} elseif ($_GET['view'] == 'kelulusan') {

        echo "<div class='row'>";
        include "admin/master_kelulusan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'mutasikas') {

        echo "<div class='row'>";
        include "admin/master_mutasi_kas.php";
        echo "</div>";
} elseif ($_GET['view'] == 'hutangtoko') {

        echo "<div class='row'>";
        include "admin/hutangtoko.php";
        echo "</div>";
} elseif ($_GET['view'] == 'detailtoko') {

        echo "<div class='row'>";
        include "admin/detailtoko.php";
        echo "</div>";
} elseif ($_GET['view'] == 'posbayar') {

        echo "<div class='row'>";
        include "admin/keuangan_posbayar.php";
        echo "</div>";
} elseif ($_GET['view'] == 'jenisbayar') {

        echo "<div class='row'>";
        include "admin/keuangan_jenisbayar.php";
        echo "</div>";
} elseif ($_GET['view'] == 'kontens' && $_GET['tipe'] == 'bulanan') {

        echo "<div class='row'>";
        include "admin/keuangan_konten_bulanan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'kontens' && $_GET['tipe'] == 'kondisional') {

        echo "<div class='row'>";
        include "admin/keuangan_konten_kondisional.php";
        echo "</div>";
} elseif ($_GET['view'] == 'tarif' && $_GET['tipe'] == 'bulanan') {

        echo "<div class='row'>";
        include "admin/keuangan_tarif_bulanan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'tarif' && $_GET['tipe'] == 'bebas') {

        echo "<div class='row'>";
        include "admin/keuangan_tarif_bebas.php";
        echo "</div>";
} elseif ($_GET['view'] == 'pembayaran') {

        echo "<div class='row'>";
        include "admin/keuangan_pembayaran.php";
        echo "</div>";
} elseif ($_GET['view'] == 'angsuran') {

        echo "<div class='row'>";
        include "admin/keuangan_pembayaran_bebas.php";
        echo "</div>";
} elseif ($_GET['view'] == 'bayarbulanan') {

        echo "<div class='row'>";
        include "admin/keuangan_pembayaran_bulanan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'jurnalumum') {

        echo "<div class='row'>";
        include "admin/keuangan_jurnalumum.php";
        echo "</div>";
} elseif ($_GET['view'] == 'jurnalumums') {

        echo "<div class='row'>";
        include "admin/keuangan_jurnalumums.php";
        echo "</div>";
} elseif ($_GET['view'] == 'jurnal') {

        echo "<div class='row'>";
        include "admin/keuangan_jurnal.php";
        echo "</div>";
} elseif ($_GET['view'] == 'lapsiswa') {

        echo "<div class='row'>";
        include "admin/laporan_siswa.php";
        echo "</div>";
} elseif ($_GET['view'] == 'pajak') {

        echo "<div class='row'>";
        include "admin/laporan_pembayaran_pajak.php";
        echo "</div>";
} elseif ($_GET['view'] == 'rekappengeluaranjenis') {

        echo "<div class='row'>";
        include "admin/laporan_rekappengeluaran_jenis.php";
        echo "</div>";
} elseif ($_GET['view'] == 'lappembayaranhari') {

        echo "<div class='row'>";
        include "admin/laporan_kondisi_keuangan_perhari.php";
        echo "</div>";
} elseif ($_GET['view'] == 'lappembayaranperbulan') {

        echo "<div class='row'>";
        include "admin/laporan_pembayaran_perbulan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'lappembayaranperposbayar') {

        echo "<div class='row'>";
        include "admin/laporan_pembayaran_perposbayar.php";
        echo "</div>";
} elseif ($_GET['view'] == 'laptagihansiswa') {

        echo "<div class='row'>";
        include "admin/laporan_tagihan_siswa.php";
        echo "</div>";
} elseif ($_GET['view'] == 'rekapitulasi') {

        echo "<div class='row'>";
        include "admin/laporan_rekapitulasi.php";
        echo "</div>";
} elseif ($_GET['view'] == 'rekappengeluaran') {

        echo "<div class='row'>";
        include "admin/laporan_rekappengeluaran.php";
        echo "</div>";
} elseif ($_GET['view'] == 'rekapkondisikeuangan') {

        echo "<div class='row'>";
        include "admin/laporan_kondisi_keuangan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'backup') {

        echo "<div class='row'>";
        include "admin/backup-datas.php";
        echo "</div>";
} elseif ($_GET['view'] == 'restore') {

        echo "<div class='row'>";
        include "admin/restore.php";
        echo "</div>";
} elseif ($_GET['view'] == 'kelasnya') {

        echo "<div class='row'>";
        include "admin/com_kelas/kelas.php";
        echo "</div>";
} elseif ($_GET['view'] == 'nasabah') {

        echo "<div class='row'>";
        include "admin/com_nasabah/nasabah.php";
        echo "</div>";
} elseif ($_GET['view'] == 'transaksi') {

        echo "<div class='row'>";
        include "admin/com_transaksi/transaksi.php";
        echo "</div>";
} elseif ($_GET['view'] == 'laporan-transaksi') {

        echo "<div class='row'>";
        include "admin/com_laporan/laporan-transaksi.php";
        echo "</div>";
} elseif ($_GET['view'] == 'pengaturant') {

        echo "<div class='row'>";
        include "admin/com_pengaturan/pengaturan.php";
        echo "</div>";
} elseif ($_GET['view'] == 'laptransaksinasabah') {

        echo "<div class='row'>";
        include "admin/com_laporan/laporan-nasabah.php";
        echo "</div>";
} elseif ($_GET['view'] == 'laptransaksi') {

        echo "<div class='row'>";
        include "admin/com_laporan/laporan-transaksi.php";
        echo "</div>";
} elseif ($_GET['view'] == 'whatsapp') {

        echo "<div class='row'>";
        include "admin/wa.php";
        echo "</div>";
}
