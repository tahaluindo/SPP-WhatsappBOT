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
			case 'siswa':
				$judul = "<span class='fa fa-users'></span> Manajemen Data Diri";
				$aktifA = 'active';
				$aktifA4 = 'active';
				break;
			case 'laptanggungan':
				$judul = "";
				$aktif5 = 'active';
				break;
            case 'konten':
				$judul = "<span class='fa fa-camera'></span> Data Konten";
				$aktifA = 'active';
				$aktifA11 = 'active';
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
              case 'rencana_project':
				$judul = "<span class='fa fa-thumbs-up'></span> Data Perencanaan Project";
				$aktifG = 'active';
				$aktifG2 = 'active';
				break;
            case 'mitra':
				$judul = "<span class='fa fa-folder-open'></span> Mitra";
				$aktifG = 'active';
				$aktifG1 = 'active';
				break;
            //menu inventaris
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

				//menu projcet
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
				$judul = "<span class='fa fa-chrome'></span> Manajemen Hosting";
				$aktifG = 'active';
				$aktifG4 = 'active';
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
			<li class="<?php echo $aktifHome; ?>"><a href="index-tim.php?view=home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li><a href="index-tim.php?view=absentim&tahun=<?= $ta['idTahunAjaran']; ?>"><i class="fa fa-bell"></i> Absensi </a></li>
          <?php if ($_SESSION[kls] == '3') { ?>
			<li class="<?php echo $aktifA11; ?>"><a href="index-tim.php?view=konten"><i class="fa fa-camera"></i> Data Rencana Konten</a></li>
           <?php } ?>
          <?php if ($_SESSION[kls] == '5') { ?>
          <li class="treeview <?php echo $aktifG; ?>">
					<a href="#">
						<i class="fa fa-folder-open"></i>
						<span>Master Project </span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>

					<ul class="treeview-menu">
          <li class="<?php echo $aktifG1; ?>"><a href="index-tim.php?view=mitra"><i class="fa fa-code-fork"></i> Mitra/Client</a></li>
          <li class="<?php echo $aktifG2; ?>"><a href="index-tim.php?view=rencana_project"><i class="fa fa-list-alt"></i> Data Rencana Project</a></li>
         </ul>
				</li>
                      <?php } ?>
			<?php if ($_SESSION[kls] == '4') { ?>
				<li class="treeview <?php echo $aktifM; ?>">
					<a href="#">
						<i class="fa fa-envelope"></i>
						<span>Master Surat </span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>

					<ul class="treeview-menu">
						<li class="<?php echo $aktifM1; ?>"><a href="index-tim.php?view=surat_masuk"><i class="fa fa-arrow-down"></i> Surat Masuk</a></li>
						<li class="<?php echo $aktifM2; ?>"><a href="index-tim.php?view=surat_keluar"><i class="fa fa-arrow-up"></i> Surat Keluar</a></li>

					</ul>
				</li>
				<li class="treeview <?php echo $aktifG; ?>">
					<a href="#">
						<i class="fa fa-folder-open"></i>
						<span>Master Project</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>

					<ul class="treeview-menu">
						<li class="<?php echo $aktifG3; ?>"><a href="index-tim.php?view=item"><i class="fa fa-align-center"></i> Data Item</a></li>
						<li class="<?php echo $aktifG1; ?>"><a href="index-tim.php?view=mitra"><i class="fa fa-code-fork"></i> Mitra/Client</a></li>
						<li class="<?php echo $aktifG2; ?>"><a href="index-tim.php?view=keuangan_project"><i class="fa fa-folder-open"></i> Data Project</a></li>
							<li class="<?php echo $aktifG4; ?>"><a href="index-tim.php?view=keuangan_hosting"><i class="fa fa-chrome"></i> Hosting</a></li>
                  </ul>
				</li>
          <li class="treeview <?php echo $aktifN; ?>">
					<a href="#">
						<i class="fa fa-briefcase"></i>
						<span>Master Inventaris</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>

					<ul class="treeview-menu">
						<li class="<?php echo $aktifN1; ?>"><a href="index-tim.php?view=inventaris"><i class="fa fa-briefcase"></i> Data Inventaris</a></li>
						<li class="<?php echo $aktifN4; ?>"><a href="index-tim.php?view=inventarismasuks"><i class="fa fa-arrow-down"></i> Inventaris Masuk</a></li>
						<li class="<?php echo $aktifN3; ?>"><a href="index-tim.php?view=inventariskeluar"><i class="fa fa-arrow-up"></i> Inventaris Keluar</a></li>

					</ul>
				</li>
			<?php } ?>
			<li class="<?php echo $aktif; ?>"><a href="index-tim.php?view=laptanggungan"><i class="fa fa-money"></i><span>Riwayat Gaji </span></a></li>
			<li><a href="logout.php"><i class="fa fa-reply-all"></i>Keluar</a></li>
</section>