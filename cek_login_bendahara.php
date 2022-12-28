<?php 
session_start();
  error_reporting(0);
  include "config/koneksi.php";
  include 'lib/function.php';
// menangkap data yang dikirim dari form login
function anti_injection($data)
{
  $filter  = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
  return $filter;
}
if (isset($_POST[login])){
 $user = anti_injection($_POST[a]);
 $pass=md5(anti_injection($_POST[b]));
 $injeksi_username = mysqli_real_escape_string($conn, $username);
$injeksi_password = mysqli_real_escape_string($conn, $password);
 $admin = mysqli_query($conn,"SELECT * FROM users WHERE username='$user' AND password='$pass' AND blokir='N' AND level='bendahara' ");
 
 $hitungadmin = mysqli_num_rows($admin);
 if ($hitungadmin >= 1){
	session_start();
    $r = mysqli_fetch_array($admin);
    $_SESSION[id]     		= $r[username];
    $_SESSION[namalengkap]  = $r[nama_lengkap];
    $_SESSION[level]    	= $r[level];
	  $_SESSION[kelas]    	= $r[idKelas];
	  $_SESSION[poss]    	= $r[pos_bayar];
    
    echo "<script>document.location='index-bendahara.php?view=home';</script>";
 }else{
    echo "<script>window.alert('Maaf, Anda Tidak Memiliki akses');
                                  window.location=('index-bendahara.php?view=login')</script>";
 }
}
