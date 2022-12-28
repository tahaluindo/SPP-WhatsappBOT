<?php
date_default_timezone_set('Asia/Jakarta');
$server = "localhost";
$username = "root";
$password = "root";
$database = "payment";

$conn = mysqli_connect($server, $username, $password, $database);


function cek_session_admin()
{
	$level = $_SESSION[level];
	if ($level != 'admin' and $cekakses <= '0') {
		echo "<script>document.location='index.php';</script>";
	}
}
