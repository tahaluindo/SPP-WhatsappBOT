<?php
namespace Midtrans;
require_once(dirname(__FILE__) . '/vendor/autoload.php');
session_start();

error_reporting(0);
include "config/koneksi.php";

   $idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas"));
//Set Your server key
Config::$serverKey = "$idt[nipKaTU]";

// Uncomment for production environment
Config::$isProduction = false;

// Enable sanitization
Config::$isSanitized = true;

// Enable 3D-Secure
Config::$is3ds = true;



if (isset($_SESSION['idsa']) && isset($_POST['items']) && isset($_POST['pay']) && isset($_POST['total']) ) {
$val = $_POST['items'];

$id = $_POST['pay'];
$tot = $_POST['total'];
$n = count($val);
$ad = $id[0];


   $fi = mysqli_query($conn,"SELECT * FROM tagihan_bulanan
                                    INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan    
                                    INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa                                     
                                    WHERE idTagihanBulanan='$ad'");
    $ta = mysqli_fetch_array($fi);
    
   
    $date = date("YmdHis");
    $inv = 'INV'.$date;



for ($i=0; $i <$n; $i++) { 
    
   $da[] = [$id[$i]=>$val[$i]];
   
   $d = $id[$i];
  
   $fa = mysql_query( "SELECT * FROM tagihan_bulanan
                                    INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar 
                                    INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan    
                                    INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa                                     
                                    WHERE idTagihanBulanan='$d'");
  $ta = mysqli_fetch_array($fa);
  $item[] = ['id'=>$id[$i],
             'price'=>$val[$i],
             'quantity' => 1,
             'name' => 'Pembayaran '. $ta['nmJenisBayar'].'Bulan ' . $ta['nmBulan']
            ];
            
    $up = mysql_query( "UPDATE tagihan_bulanan SET inv='$inv' WHERE idTagihanBulanan='$d'");
    
}




    // Required
    $transaction_details = array(
        'order_id' => $inv,
        'gross_amount' => 94000,
        
    );
   
    $item_details = $item;

    // Optional
    $billing_address = array(
        'first_name'    => $ta['nmSiswa'],
        'address'       => $ta['alamatSiswa'],
        'phone'         => $ta['noHpOrtu'],
    );
    
    // Optional
    $shipping_address = array(
        'first_name'    => "Obet",
        'last_name'     => "Supriadi",
        'address'       => "Manggis 90",
        'city'          => "Jakarta",
        'postal_code'   => "16601",
        'phone'         => "08113366345",
        'country_code'  => 'IDN'
    );

    // Optional
    $customer_details = array(
        'first_name'    => $ta['nmSiswa'],
        'last_name'     => null,
        'email'         => $ta['username'],
        'phone'         => $ta['noHpOrtu'],
    );
   
    // Fill transaction details
    $transaction = array(
       
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'item_details' => $item_details,
       
       
    );

    $snapToken = Snap::getSnapToken($transaction);
    echo json_encode($snapToken);
}



?>