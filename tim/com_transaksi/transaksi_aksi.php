<?php
error_reporting(0);
include '../../config/conn.php';
$module = $_GET['module'];
$act    = $_GET['act'];	

  if ( $module = 'transaksi' AND $act =='simpan') { 

    if (empty($_POST['kredit'])) {
    mysqli_query($conn,"INSERT INTO transaksi(id_transaksi,
                                  id_nasabah,
                                  tanggal,
                                  debit,
                                  kredit,
                                  keterangan) VALUES('$_POST[id]',
                                                 '$_POST[id_nasabah]',
                                                 '$_POST[tanggal]',
                                                 '$_POST[debit]',
                                                 '0',
                                                 '$_POST[keterangan]')");
    }else{
      mysqli_query($conn,"INSERT INTO transaksi(id_transaksi,
                                  id_nasabah,
                                  tanggal,
                                  debit,
                                  kredit,
                                  keterangan) VALUES('$_POST[id]',
                                                 '$_POST[id_nasabah]',
                                                 '$_POST[tanggal]',
                                                 '0',
                                                 '$_POST[kredit]',
                                                 '$_POST[keterangan]')");

    }

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
