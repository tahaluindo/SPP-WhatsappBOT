<section class="sidebar">
	<font face="Poppins">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo $foto; ?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?php echo $nama; ?></p>
				<a href="#"><i class="fa fa-circle text-success"></i>Tahun Anggaran : <?= $ta['nmTahunAjaran']; ?></a>
			</div>
		</div>
		<?php
		switch ($_GET['view']) {
				//menu master data
			case 'admin':
				$judul = "<span class='fa fa-users'></span> Manajemen Admin";
				$aktifA = 'active';
				$aktifA1 = 'active';
				break;
			case 'tahun':
				$judul = "<span class='fa fa-calendar'></span> Manajemen Tahun Ajaran";
				$aktifA = 'active';
				$aktifA2 = 'active';
				break;
			case 'kelas':
				$judul = "<span class='fa fa-tasks'></span> Manajemen Data Kelas";
				$aktifA = 'active';
				$aktifA3 = 'active';
				break;
			case 'siswa':
				$judul = "<span class='fa fa-users'></span> Manajemen Data Diri";
				$aktifA = 'active';
				$aktifA4 = 'active';
				break;
			case 'kelulusan':
				$judul = "<span class='fa fa-graduation-cap'></span> Kelulusan";
				$aktifA = 'active';
				$aktifA5 = 'active';
				break;
			case 'kenaikankelas':
				$judul = "<span class='fa  fa-cubes'></span> Proses Pindah Kelas dan Kenaikan Kelas";
				$aktifA = 'active';
				$aktifA6 = 'active';
				break;
			case 'pindahkelas':
				$judul = "<span class='fa fa-tasks'></span> Pindah Kelas";
				$aktifA = 'active';
				$aktifA6 = 'active';
				break;
				//menu kas
			case 'kasmas':
				$judul = "<span class='fa fa-money'></span>Kas Masuk";
				$aktifX = 'active';
				$aktifX1 = 'active';
				break;
			case 'kaskel':
				$judul = "<span class='fa fa-ils'></span> Kas Keluar";
				$aktifX = 'active';
				$aktifX2 = 'active';
				break;
				//menu keuangan
			case 'posbayar':
				$judul = "<span class='fa fa-money'></span> Pos Bayar";
				$aktifB = 'active';
				$aktifB1 = 'active';
				break;
			case 'jenisbayar':
				$judul = "<span class='fa fa-ils'></span> Jenis Pembayaran";
				$aktifB = 'active';
				$aktifB2 = 'active';
				break;
			case 'tarif':
				$judul = "<span class='fa fa-gg-circle'></span> Tarif Pembayaran";
				$aktifB = 'active';
				$aktifB2 = 'active';
				break;
			case 'jurnalumum':
				$judul = "<span class='fa fa-line-chart'></span> Jurnal Umum";
				$aktifm = 'active';
				$aktifm = 'active';
				break;
				//menu backup&restore
			case 'restore':
				$judul = "<span class='fa fa-upload'></span> Restore Database";
				$aktifZ = 'active';
				break;
			case 'backup':
				$judul = "<span class='fa fa-download'></span> Backup Database";
				$aktifZ = 'active';
				break;
				//menu tabungan
			case 'nasabah':
				$judul = "<span class='fa fa-users'></span> Nasabah";
				$aktifK = 'active';
				$aktifK1 = 'active';
			case 'transaksi1':
				$judul = "<span class='fa fa-money'></span> Transaksi";
				$aktifK = 'active';
				$aktifK2 = 'active';

			case 'pengaturan':
				$judul = "<span class='fa fa-wrench'></span> Pengaturan";
				$aktifK = 'active';
				$aktifK5 = 'active';

				//menu bhutangpiutang


			case 'laptransaksis':
				$judul = " ";
				$aktifK = 'active';
				break;
			case 'detail':
				$judul = "<span class='fa fa-money'></span> Laporan Transaksi Tabungan ";
				$aktif4 = 'active';
				break;
			case 'laptanggungan':
				$judul = "";
				$aktif5 = 'active';
				break;
			case 'lapbayar':
				$judul = "<span class='fa fa-money'></span> Laporan Pembayaran Bulanan ";
				$aktif6 = 'active';
				break;
			case 'lapkas':
				$judul = "<span class='fa fa-money'></span> Laporan Kas Kelas ";
				$aktif7 = 'active';
				break;
				//menu pembayaran
			case 'pembayaran':
				$judul = "<span class='fa fa-money'></span> Transaksi Pembayaran";
				$aktifC = 'active';
				break;
			case 'angsuran':
				$judul = "<span class='fa fa-money'></span> Angsuran Pembayaran";
				$aktifC = 'active';
				break;
			case 'bayarbulanan':
				$judul = "<span class='fa fa-money'></span> Pembayaran Bulanan";
				$aktifC = 'active';
				break;
				//menu laporan
			case 'lapsiswa':
				$judul = "<span class='fa fa-tasks'></span> Laporan Siswa Per Kelas";
				$aktifD = 'active';
				$aktifD1 = 'active';
				break;
			case 'lappembayaran':
				$judul = "<span class='fa fa-tasks'></span> Laporan Pembayaran Per Kelas";
				$aktifD = 'active';
				$aktifD2 = 'active';
				break;
			case 'lappembayaranperbulan':
				$judul = "<span class='fa fa-tasks'></span> Laporan Pembayaran Per Bulan";
				$aktifD = 'active';
				$aktifD3 = 'active';
				break;
			case 'lappembayaranperposbayar':
				$judul = "<span class='fa fa-tasks'></span> Laporan Pembayaran Per Pos Bayar";
				$aktifD = 'active';
				$aktifD5 = 'active';
				break;
			case 'laptagihansiswa':
				$judul = "<span class='fa fa-tasks'></span> Laporan Tagihan Siswa";
				$aktifD = 'active';
				$aktifD6 = 'active';
				break;
			case 'rekapitulasi':
				$judul = "<span class='fa fa-tasks'></span> Rekapitulasi Pembayaran";
				$aktifD = 'active';
				$aktifD4 = 'active';
				break;


				//menu home
			case 'home':
				$judul = "";
				$aktifz = 'active';
				break;
		}
		?>
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<li class="<?php echo $aktifz; ?>"><a href="index-siswa.php?view=home"><i class="fa fa-dashboard"></i> Dashboard</a></li>



		<!--	<li class="<?php echo $aktif; ?>"><a href="index-siswa.php?view=laptransaksis"><i class="fa fa-leanpub "></i><span>Cek Transaksi Tabungan</span></a></li>
	-->
			<li class="<?php echo $aktif; ?>"><a href="index-siswa.php?view=laptanggungan"><i class="fa fa-money"></i><span>Riwayat Gaji </span></a></li>






			<li><a href="logout.php"><i class="fa fa-reply-all"></i>Keluar</a></li>
</section>