<?php 
session_start();
  error_reporting(0);
  include "config/koneksi.php";
  include 'lib/function.php';
  function anti_injection($data)
{
  $filter  = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
  return $filter;
}
if (isset($_POST[login])){
 $user = anti_injection($_POST[a]);
 $pass= anti_injection($_POST[b]);
 $injeksi_username = mysqli_real_escape_string($conn, $username);
$injeksi_password = mysqli_real_escape_string($conn, $password);
 $siswa = mysqli_query($conn,"SELECT * FROM siswa WHERE username='$user' AND password='$pass' ");
 
 $hitungadmin = mysqli_num_rows($siswa);
 if ($hitungadmin >= 0){
	session_start();
    $r = mysqli_fetch_assoc($siswa);
    $_SESSION['id']     = $r['username'];
	$_SESSION['ids']     = $r['nisnSiswa'];
	$_SESSION['idsa']     = $r['idSiswa'];
    $_SESSION['nama']  = $r['nmSiswa'];
    $_SESSION['Islam']  = $r['islam'];
	$_SESSION['leveluser']   = $r['level'];
	$_SESSION['status']   = $r['statusSiswa'];
	$_SESSION['saldonya']   = $r['saldo'];
	$_SESSION['nisn'] = $r['nisnSiswa'];
	$_SESSION['nis'] = $r['nisSiswa'];
	$_SESSION['kls'] = $r['idKelas'];
	$_SESSION['lvl'] = $r['level'];

    echo "<script>document.location='index-siswa.php?view=home';</script>";
 }else{
    echo "<script>window.alert('Maaf, Anda Tidak Memiliki akses');
                                  window.location=('index-siswa.php?view=login')</script>";
 }
}
?>