	<section class="content-header">
		<h1>Backup Database</h1>
		<ol class="breadcrumb">
			<li><a href="index.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
			<li class="active">Backup Database</li>
		</ol>
	</section>
	<font face="Comic Sans MS">
		<div class="form-group" role="main">
			<div class="">
				<div class="x_content" style="padding: 30px; text-align: center;  ">
					<div class="animated flipInY col-lg-12 col-md-3 col-sm-6 col-xs-12">
						<div class="tile-stats">
							<div class="icon"></div>
							<div class="form-group">
								<div class="col-xs-12">
									<div class="box">
										<!-- /.box-header -->
										<div class="box-body">
											<h2>Backup Database : </h2>
											<div class="clearfix"></div>
											<?php
											function &backup_tables($host, $user, $pass, $name, $tables = '*')
											{
												$data = "\n/*---------------------------------------------------------------" .
													"\n  SQL DB BACKUP " . date("d.m.Y H:i") . " " .
													"\n  HOST: {$host}" .
													"\n  DATABASE: {$name}" .
													"\n  TABLES: {$tables}" .
													"\n  ---------------------------------------------------------------*/\n";
												$link = mysql_connect($host, $user, $pass);
												mysql_select_db($name, $link);
												mysql_query("SET NAMES `utf8` COLLATE `utf8_general_ci`", $link); // Unicode

												if ($tables == '*') { //get all of the tables
													$tables = array();
													$result = mysql_query("SHOW TABLES");
													while ($row = mysql_fetch_row($result)) {
														$tables[] = $row[0];
													}
												} else {
													$tables = is_array($tables) ? $tables : explode(',', $tables);
												}

												foreach ($tables as $table) {
													$data .= "\n/*---------------------------------------------------------------" .
														"\n  TABLE: `{$table}`" .
														"\n  ---------------------------------------------------------------*/\n";
													$data .= "DROP TABLE IF EXISTS `{$table}`;\n";
													$res = mysql_query("SHOW CREATE TABLE `{$table}`", $link);
													$row = mysql_fetch_row($res);
													$data .= $row[1] . ";\n";
													$result = mysql_query("SELECT * FROM `{$table}`", $link);
													$num_rows = mysql_num_rows($result);
													if ($num_rows > 0) {
														$vals = array();
														$z = 0;
														for ($i = 0; $i < $num_rows; $i++) {
															$items = mysql_fetch_row($result);
															$vals[$z] = "(";
															for ($j = 0; $j < count($items); $j++) {
																if (isset($items[$j])) {
																	$vals[$z] .= "'" . mysql_real_escape_string($items[$j], $link) . "'";
																} else {
																	$vals[$z] .= "NULL";
																}
																if ($j < (count($items) - 1)) {
																	$vals[$z] .= ",";
																}
															}
															$vals[$z] .= ")";
															$z++;
														}
														$data .= "INSERT INTO `{$table}` VALUES ";
														$data .= "  " . implode(";\nINSERT INTO `{$table}` VALUES ", $vals) . ";\n";
													}
												}
												mysql_close($link);
												return $data;
											}

											$backup_file = 'db-backup-pembayaran-' . date('d-m-Y') . '.sql';

											// get backup
											$mybackup = backup_tables("localhost", "root", "", "spp", "*");

											// save to file
											$handle = fopen($backup_file, 'w+');
											fwrite($handle, $mybackup);
											fclose($handle);

											echo "<div class='message success'>
		<h5>Sukses bro!</h5>
		<b>Backup data telah berhasil, silahkan klik link download dibawah untuk menyimpan ke dalam PC local Anda.<br> perlu di ingat backup yang tercatat hanya sekali sehari, jadi jika melakukan perubahan setelah membackup hari itu maka disarankan untuk melakukan tombol backup di hari berikutnya </b></div>";
											echo "<a href='$backup_file'><button type='button' class='btn btn-success btn-sm btn-block'>Download Disini</button></a>";



											?>