<?php
	$host="localhost";
	$user="root";
	$pass="";
	$database="db_tabungan";
	$conn=new mysqli($host,$user,$pass,$database);
	if (mysqli_connect_errno()) {
	  trigger_error('Koneksi ke database gagal: '  . mysqli_connect_error(), E_USER_ERROR); 
	}
