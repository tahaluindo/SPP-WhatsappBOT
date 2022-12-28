<?php
error_reporting(0);
include '../../config/conn.php';
$module = $_GET['module'];
$act    = $_GET['act'];	

  if ( $module = 'nasabah' AND $act =='simpan') { 
    mysqli_query($conn,"INSERT INTO nasabah(id_nasabah,
                                  no_rekening,
                                  nama,
                                  alamat,
                                  id_kelas,
                                  tempat_lahir,
                                  tanggal_lahir,
                                  orang_tua,
                                  status) VALUES('$_POST[id]',
                                                 '$_POST[no_rekening]',
                                                 '$_POST[nama]',
                                                 '$_POST[alamat]',
                                                 '$_POST[kelas]',
                                                 '$_POST[tempat_lahir]',
                                                 '$_POST[tanggal_lahir]',
                                                 '$_POST[orang_tua]',
                                                 '$_POST[status]')");

    echo "<script language='javascript'>document.location='../../?module=".$module."';</script>";
  }elseif ($module = 'nasabah' AND $act =='edit') {
  	$password   = md5($_POST[password]);
    if (empty($_POST['password'])) {
    mysqli_query($conn,"UPDATE pegawai SET nama = '$_POST[nama]',
                                    alamat = '$_POST[alamat]',
                                    no_telp = '$_POST[telephone]',
                                    username = '$_POST[username]',
                                    level = '$_POST[level]',
                                    status = '$_POST[status]' 
                                    WHERE id_pegawai = '$_POST[id]'");

    }else{
    mysqli_query($conn,"UPDATE pegawai SET nama = '$_POST[nama]',
                                    alamat = '$_POST[alamat]',
                                    no_telp = '$_POST[telephone]',
                                    username = '$_POST[username]',
                                    password = '$_POST[password]',
                                    level = '$_POST[level]',
                                    status = '$_POST[status]' 
                                    WHERE id_pegawai = '$_POST[id]'");  
    }  
    echo "<script language='javascript'>
        document.location='../../?module=".$module."';
        </script>";
  }
