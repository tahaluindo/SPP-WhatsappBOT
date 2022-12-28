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
				$judul = "<span class='fa fa-calendar'></span> Manajemen Tahun Anggaran";
				$aktifA = 'active';
				$aktifA2 = 'active';
				break;
			case 'jabatan':
				$judul = "<span class='fa fa-tasks'></span> Manajemen Data Jabatan";
				$aktifA = 'active';
				$aktifA3 = 'active';
				break;
			case 'tim':
				$judul = "<span class='fa fa-users'></span> Manajemen Data TIM";
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
			case 'jenis_penerimaan':
				$judul = "<span class='fa fa-thumbs-up'></span> Jenis Penerimaan";
				$aktifA = 'active';
				$aktifA7 = 'active';
				break;
			case 'jenis_pengeluaran':
				$judul = "<span class='fa fa-thumbs-down'></span> Jenis Pengeluaran";
				$aktifA = 'active';
				$aktifA8 = 'active';
				break;
			case 'rencana':
				$judul = "<span class='fa fa-thumbs-up'></span> Data Perencanaan";
				$aktifA = 'active';
				$aktifA9 = 'active';
				break;
			case 'rencana_project':
				$judul = "<span class='fa fa-thumbs-up'></span> Data Perencanaan Project";
				$aktifA = 'active';
				$aktifA12 = 'active';
				break;
			case 'konten':
				$judul = "<span class='fa fa-camera'></span> Data Konten";
				$aktifA = 'active';
				$aktifA11 = 'active';
				break;
			case 'programmer':
				$judul = "<span class='fa fa-user-secret'></span> Data Programmer";
				$aktifA = 'active';
				$aktifA10 = 'active';
				break;
			case 'surat_masuk':
				$judul = "<span class='fa fa-briefcase'></span> Surat Masuk";
				$aktifM = 'active';
				$aktifM1 = 'active';
				break;
			case 'surat_keluar':
				$judul = "<span class='fa fa-arrow-up'></span> Surat Keluar";
				$aktifM = 'active';
				$aktifM2 = 'active';
				break;

			case 'inventaris':
				$judul = "<span class='fa fa-briefcase'></span> Manajemen Inventaris";
				$aktifN = 'active';
				$aktifN1 = 'active';
				break;
			case 'inventariskeluar':
				$judul = "<span class='fa fa-arrow-up'></span> Inventaris Keluar";
				$aktifN = 'active';
				$aktifN3 = 'active';
				break;
			case 'inventarismasuks':
				$judul = "<span class='fa fa-arrow-down'></span> Inventaris Masuk";
				$aktifN = 'active';
				$aktifN4 = 'active';
				break;
			case 'keuangan_project':
				$judul = "<span class='fa fa-folder-open'></span> Manajemen Project";
				$aktifG = 'active';
				$aktifG2 = 'active';
				break;
			case 'item':
				$judul = "<span class='fa fa-align-center'></span> Manajemen Item";
				$aktifG = 'active';
				$aktifG3 = 'active';
				break;
			case 'mitra':
				$judul = "<span class='fa fa-folder-open'></span> Mitra";
				$aktifG = 'active';
				$aktifG1 = 'active';
				break;
			case 'keuangan_hosting':
				$judul = "<span class='fa fa-chrome'></span> Manajemen Hosting dan Domain";
				$aktifG = 'active';
				$aktifG4 = 'active';
				break;
			case 'realisasi':
				$judul = "<span class='fa fa-money'></span> Realisasi";
				$aktifG = 'active';
				$aktifG5 = 'active';
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
			case 'bank':
				$judul = "<span class='fa fa-money'></span> Bank";
				$aktifB = 'active';
				$aktifB0 = 'active';
				break;
			case 'posbayar':
				$judul = "<span class='fa fa-money'></span> Pos Kas";
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
				$judul = "<span class='fa fa-line-chart'></span> Pengeluaran Kas";
				$aktifB = 'active';
				$aktifB4 = 'active';
				break;
			case 'jurnalumums':
				$judul = "<span class='fa fa-line-chart'></span> Penerimaan Kas";
				$aktifB = 'active';
				$aktifB3 = 'active';
				break;
			case 'pembayaran':
				$judul = "<span class='fa fa-money'></span> Transaksi Pembayaran";
				$aktifB = 'active';
				$aktifB5 = 'active';
				break;
			case 'hutangtoko':
				$judul = "<span class='fa fa-money'></span> Hutang ";
				$aktifB = 'active';
				$aktifB6 = 'active';
				break;
			case 'mutasikas':
				$judul = "<span class='fa fa-paper-plane'></span> Mutasi Kas Bank";
				$aktifB = 'active';
				$aktifB7 = 'active';
				break;
			case 'pajak':
				$judul = " Data Pajak";
				$aktifD = 'active';
				$aktifD11 = 'active';
				break;
				//menu backup&restore
			case 'restore':
				$judul = "";
				$aktifZ = 'active';
				break;
			case 'backup':
				$judul = "";
				$aktifZ = 'active';
				break;
			case 'tagihan1':
				$judul = "<span class='fa fa-download'></span> Tagihan";
				$aktifZ = 'active';
				break;
				//menu tabungan
			case 'nasabah':
				$judul = "<span class='fa fa-users'></span> Nasabah";
				$aktifK = 'active';
				$aktifK1 = 'active';
				break;
			case 'transaksi':
				$judul = "<span class='fa fa-money'></span> Transaksi";
				$aktifK = 'active';
				$aktifK2 = 'active';
				break;
			case 'laptransaksi':
				$judul = "<span class='fa fa-print'></span> Laporan Transaksi";
				$aktifK = 'active';
				$aktifK4 = 'active';
				break;
			case 'pengaturan':
				$judul = "<span class='fa fa-wrench'></span> Pengaturan";
				$aktifK = 'active';
				$aktifK5 = 'active';
				break;
				//menu absen

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
			case 'lapkas':
				$judul = "<span class='fa fa-tasks'></span> Laporan Kas Kelas";
				$aktifD = 'active';
				$aktifD7 = 'active';
				break;
			case 'rekapitulasi':
				$judul = "<span class='fa fa-tasks'></span> Rekapitulasi Gaji";
				$aktifD = 'active';
				$aktifD4 = 'active';
				break;
			case 'rekappengeluaran':
				$judul = "<span class='fa fa-tasks'></span> Rekapitulasi Pengeluaran";
				$aktifD = 'active';
				$aktifD8 = 'active';
				break;
			case 'rekappengeluaranjenis':
				$judul = "<span class='fa fa-tasks'></span> Rekapitulasi Pengeluaran Perjenis";
				$aktifD = 'active';
				$aktifD10 = 'active';
				break;
			case 'rekapkondisikeuangan':
				$judul = "<span class='fa fa-tasks'></span> Rekapitulasi Kondisi Keuangan";
				$aktifD = 'active';
				$aktifD9 = 'active';
				break;
			case 'rekapabsen':
				$judul = "<span class='fa fa-tasks'></span> Laporan Absensi";
				$aktifD = 'active';
				$aktifD12 = 'active';
				break;

			case 'log':
				$judul = "<span class='fa fa-tasks'></span> Log Aktivitas";
				$aktifw1 = 'active';
				break;
				//menu home
			default:
				$judul = "<span class='fa fa-dashboard'></span> Dashboard";
				$aktifHome = 'active';
		}
		?>
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">MAIN NAVIGATION</li>
			<li class="<?php echo $aktifHome; ?>"><a href="./"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<?php if ($_SESSION['level'] == 'admin') { ?>
				<li class="treeview <?php echo $aktifA; ?>">
					<a href="#">
						<i class="fa fa-book"></i>
						<span>Master Data</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="<?php echo $aktifA1; ?>"><a href="index.php?view=admin"><i class="fa fa-user"></i> Data Pengguna</a></li>
						<li class="<?php echo $aktifA2; ?>"><a href="index.php?view=tahun"><i class="fa fa-calendar"></i> Tahun Anggaran</a></li>
						<li class="<?php echo $aktifA3; ?>"><a href="index.php?view=jabatan"><i class="fa fa-male"></i> Jabatan</a></li>
						<li class="<?php echo $aktifA4; ?>"><a href="index.php?view=tim"><i class="fa fa-users"></i> TIM</a></li>
						<li class="<?php echo $aktifA10; ?>"><a href="index.php?view=programmer"><i class="fa fa-user-secret"></i>Programmer</a></li>
						<li class="<?php echo $aktifA7; ?>"><a href="index.php?view=jenis_penerimaan"><i class="fa fa-thumbs-up"></i> Jenis Penerimaan</a></li>
						<li class="<?php echo $aktifA8; ?>"><a href="index.php?view=jenis_pengeluaran"><i class="fa fa-thumbs-down"></i> Jenis Pengeluaran</a></li>
						<li class="<?php echo $aktifA9; ?>"><a href="index.php?view=rencana"><i class="fa fa-rocket"></i> Data Perencanaan</a></li>
						<li class="<?php echo $aktifA11; ?>"><a href="index.php?view=konten"><i class="fa fa-camera"></i> Data Rencana Konten</a></li>
						<li class="<?php echo $aktifA12; ?>"><a href="index.php?view=rencana_project"><i class="fa fa-list-alt"></i> Data Rencana Project</a></li>
					</ul>
				</li>

				<li class="treeview <?php echo $aktifG; ?>">
					<a href="#">
						<i class="fa fa-folder-open"></i>
						<span>Data Project</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="<?php echo $aktifG3; ?>"><a href="index.php?view=item"><i class="fa fa-align-center"></i> Item</a></li>
						<li class="<?php echo $aktifG1; ?>"><a href="index.php?view=mitra"><i class="fa fa-code-fork"></i> Mitra/Client</a></li>
						<li class="<?php echo $aktifG2; ?>"><a href="index.php?view=keuangan_project"><i class="fa fa-folder-open"></i> Project</a></li>
						<li class="<?php echo $aktifG4; ?>"><a href="index.php?view=keuangan_hosting"><i class="fa fa-chrome"></i> Hosting dan Domain</a></li>
						<li class="<?php echo $aktifG5; ?>"><a href="index.php?view=realisasi"><i class="fa fa-rocket"></i> Realisasi Project</a></li>
					</ul>
				</li>
				<li class="treeview <?php echo $aktifM; ?>">
					<a href="#">
						<i class="fa fa-envelope"></i>
						<span>Data Surat </span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="<?php echo $aktifM1; ?>"><a href="index.php?view=surat_masuk"><i class="fa fa-arrow-down"></i> Surat Masuk</a></li>
						<li class="<?php echo $aktifM2; ?>"><a href="index.php?view=surat_keluar"><i class="fa fa-arrow-up"></i> Surat Keluar</a></li>
					</ul>
				</li>
				<li class="treeview <?php echo $aktifN; ?>">
					<a href="#">
						<i class="fa fa-briefcase"></i>
						<span>Data Inventaris</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="<?php echo $aktifN1; ?>"><a href="index.php?view=inventaris"><i class="fa fa-briefcase"></i> Data Inventaris</a></li>
						<li class="<?php echo $aktifN4; ?>"><a href="index.php?view=inventarismasuks"><i class="fa fa-arrow-down"></i> Inventaris Masuk</a></li>
						<li class="<?php echo $aktifN3; ?>"><a href="index.php?view=inventariskeluar"><i class="fa fa-arrow-up"></i> Inventaris Keluar</a></li>
					</ul>
				</li>
				<li class="treeview <?php echo $aktifB; ?>">
					<a href="#">
						<i class="fa fa-credit-card"></i> <span>Data Keuangan</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="<?php echo $aktifB0; ?>"><a href="index.php?view=bank"><i class="fa fa-credit-card-alt"></i> Bank</a></li>
						<li class="<?php echo $aktifB7; ?>"><a href="index.php?view=mutasikas"><i class="fa fa-paper-plane"></i> Mutasi Kas Bank</a></li>
						<li class="<?php echo $aktifB1; ?>"><a href="index.php?view=posbayar"><i class="fa fa-credit-card-alt"></i> Pos </a></li>
						<li class="<?php echo $aktifB2; ?>"><a href="index.php?view=jenisbayar"><i class="fa fa-shekel"></i> Jenis Bayar</a></li>
						<li class="<?php echo $aktifB3; ?>"><a href="index.php?view=jurnalumums"><i class="fa fa-thumbs-up"></i> <span> Penerimaan Kas</span></a></li>
						<li class="<?php echo $aktifB4; ?>"><a href="index.php?view=jurnalumum"><i class="fa fa-thumbs-down"></i> <span> Pengeluaran Kas</span></a></li>
						<li class="<?php echo $aktifB5; ?>"><a href="index.php?view=pembayaran"><i class="fa fa-money"></i> <span>Pembayaran Gaji</span></a></li>
						<li class="<?php echo $aktifB6; ?>"><a href="index.php?view=hutangtoko"><i class="fa fa-balance-scale "></i> <span> Hutang Piutang</span></a></li>
					</ul>
				</li>
				<li class="treeview <?php echo $aktifD; ?>">
					<a href="#">
						<i class="fa fa-print"></i>
						<span>Data Laporan</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li class="<?php echo $aktifD12; ?>"><a href="?view=rekapabsen"><i class="fa fa-bookmark"></i> Rekap Absensi </a></li>
						<li class="<?php echo $aktifD11; ?>"><a href="?view=pajak"><i class="fa fa-bookmark"></i> Rekap Pajak </a></li>
						<li class="<?php echo $aktifD4; ?>"><a href="index.php?view=rekapitulasi"><i class="fa fa-bookmark"></i> <span>Rekapitulasi Gaji</span></a></li>
						<li class="<?php echo $aktifD10; ?>"><a href="index.php?view=rekappengeluaranjenis"><i class="fa fa-bookmark "></i> <span>Pengeluaran Perjenis</span></a></li>
						<li class="<?php echo $aktifD8; ?>"><a href="index.php?view=rekappengeluaran"><i class="fa fa-bookmark "></i> <span>Penerimaan & Pengeluaran</span></a></li>
						<li class="<?php echo $aktifD9; ?>"><a href="index.php?view=rekapkondisikeuangan"><i class="fa fa-bookmark text-blue"></i> <span>Kondisi Keuangan</span></a></li>
					</ul>
				</li>
				<li class="<?php echo $aktifK; ?>"><a href="index.php?view=pengaturan"><i class="fa fa-gears"></i> <span>Pengaturan Perusahaan</span></a></li>
				<li class="<?php echo $aktifw1; ?>"><a href="index.php?view=log"><i class="fa fa-send"></i>Log Aktifitas</a></li>
			<?php } ?>
			<li><a href="logout.php"><i class="fa fa-reply-all"></i>Keluar</a></li>
</section>