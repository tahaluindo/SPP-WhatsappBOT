<?php
// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include 'config/koneksi.php';
error_reporting(0);
include 'lib/function.php';
// menangkap data yang dikirim dari form login
function anti_injection($data)
{
  $filter  = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
  return $filter;
}

$username = anti_injection($_POST['a']);
$password = md5(anti_injection($_POST['b']));
$injeksi_username = mysqli_real_escape_string($conn, $username);
$injeksi_password = mysqli_real_escape_string($conn, $password);

// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($conn, "select * from users where username='$username' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);
$logins = mysqli_query($conn, "select * from siswa where username='$username' and password='$password'");
$ceks = mysqli_num_rows($logins);
$loginguru = mysqli_query($conn, "select * from rb_guru where nip='$username' and password='$_POST[b]'");
$cekguru = mysqli_num_rows($loginguru);
// cek apakah username dan password di temukan pada database
if ($cek > 0) {

  $data = mysqli_fetch_assoc($login);

  // cek jika user login sebagai admin
  if ($data['level'] == "admin") {

    // buat session login dan username
    $_SESSION['id'] = $username;
    $_SESSION['level'] = $data['level'];
    $_SESSION['namalengkap']  = $data['nama_lengkap'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['level']       = $data['level'];
    $_SESSION['pins']       = $data['pin'];
    $_SESSION['blokir']       = $data['blokir'];
    // alihkan ke halaman dashboard admin
    $waktu_sekarang = date('Y-m-d H:i:s');
    mysqli_query($conn, "UPDATE users SET last_login='$waktu_sekarang' WHERE username='$_SESSION[id]'");
   mysqli_query($conn, "INSERT INTO log  (username,kategori,action,waktu) VALUES('$data[nama_lengkap]','Login','Login','$waktu_sekarang')");
    header("location:index.php?view=home");

    // cek jika user login sebagai bendahara
  } else if ($data['level'] == "bendahara") {
    // buat session login dan username
    $_SESSION['id'] = $username;
    $_SESSION['level'] = $data['level'];
    $_SESSION['namalengkap']  = $data['nama_lengkap'];
    $_SESSION['level']       = $data['level'];
    $_SESSION['kelas']       = $data['idKelas'];
    $_SESSION['blokir']       = $data['blokir'];

    $waktu_sekarang = date('Y-m-d H:i:s');
    mysqli_query($conn, "UPDATE users SET last_login='$waktu_sekarang' WHERE username='$_SESSION[id]'");
    // alihkan ke halaman dashboard bendahara
    header("location:index-bendahara.php?view=home");

    // cek jika user login sebagai kepsek
  } else if ($data['level'] == "kepsek") {
    // buat session login dan username
    $_SESSION['id'] = $username;
    $_SESSION['level'] = $data['level'];
    $_SESSION['namalengkap']  = $data['nama_lengkap'];
    $_SESSION['level']       = $data['level'];
    $_SESSION['kelas']       = $data['idKelas'];
    $_SESSION['blokir']       = $data['blokir'];

    $waktu_sekarang = date('Y-m-d H:i:s');
    mysqli_query($conn, "INSERT INTO log (username,kategori,action,waktu) values ('$_SESSION[namalengkap]','Tambah','Login,'$waktu_sekarang')");
    mysqli_query($conn, "UPDATE users SET last_login='$waktu_sekarang' WHERE username='$_SESSION[id]'");
    // alihkan ke halaman dashboard kepsek
    header("location:index-kepsek.php?view=home");
  } else {
    // alihkan ke halaman login kembali
    header("location:index.php?pesan=gagal");
  }
} else if ($ceks > 0) {

  $datas = mysqli_fetch_assoc($logins);

  // cek jika user login sebagai siswa
  if ($datas['statusSiswa'] == "Aktif") {
    $_SESSION['id']     = $username;
    $_SESSION['ids']     = $datas['nisnSiswa'];
    $_SESSION['idsa']     = $datas['idSiswa'];
    $_SESSION['nama']  = $datas['nmSiswa'];
    $_SESSION['Islam']  = $datas['islam'];
    $_SESSION['leveluser']   = $datas['level'];
    $_SESSION['status']   = $datas['statusSiswa'];
    $_SESSION['saldonya']   = $datas['saldo'];
    $_SESSION['nis'] = $datas['nisSiswa'];
    $_SESSION['kls'] = $datas['idKelas'];
    $_SESSION['level'] = $datas['level'];
    $_SESSION['kode'] = $datas['kode_pelajaran'];
    // buat session login dan username

    // alihkan ke halaman dashboard admin
    header("location:index-tim.php?view=home");
  } else {
    header("location:index-tim.php?pesan=gagal");
  }
} else if ($cekguru > 0) {

  $dataguru = mysqli_fetch_assoc($loginguru);

  // cek jika user login sebagai guru
  if ($dataguru['id_status_keaktifan'] == "1") {


    $_SESSION['nips']     = $dataguru['nip'];
    $_SESSION['namalengkap']  = $dataguru['nama_guru'];
    $_SESSION['idkelas']  = $dataguru['idkelas'];
    $_SESSION['idg']   = $dataguru['id_agama'];
    $_SESSION['warga']   = $dataguru['statusSiswa'];
    $_SESSION['saldonya']   = $dataguru['kewarganegaraan'];

    // buat session login dan username

    // alihkan ke halaman dashboard admin
    header("location:index-guru.php?view=home");
  } else {
    header("location:index-guru.php?pesan=gagal");
  }
} else if ($cek or $cekguru or $ceks == '0') {

  echo "<script>document.location='login.php?gagal';</script>";
}
