<?php
namespace Midtrans;
require_once(dirname(__FILE__) . '/vendor/autoload.php');
session_start();

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


if (isset($_SESSION['idsa']) && isset($_POST['item']) && isset($_POST['pa']) && isset($_POST['tot']) ) {
$val = $_POST['item'];

$id = $_POST['pa'];
$tot = $_POST['tot'];
$th = $_POST['th'];
$n = count($val);
$ad = $id[0];

 $date = date("YmdHis");
    $inv = 'REF'.$date;

for ($i=0; $i <$n; $i++) { 
    
   $da[] = [$id[$i]=>$val[$i]];
   
   $d = $id[$i];
   
   $fa = mysql_query( "SELECT * FROM tagihan_bebas
                                                INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                
                                                INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
                                                WHERE idTagihanBebas='$d' ");
                                                
   $ba = mysqli_fetch_array($fa);
   
 
  $item[] = ['id'=>$id[$i],
         'price'=>$val[$i],
             
             'quantity' => 1,
             'name' => $ba['nmJenisBayar']
            ];
            
$up = mysqli_query($conn,"UPDATE tagihan_bebas SET ref='$inv' WHERE idTagihanBebas='$d'");
}


   $fa = mysql_query( "SELECT * FROM tagihan_bebas
                                                INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                
                                                INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
                                                WHERE idTagihanBebas='$ad' ");
    $ta = mysqli_fetch_array($fa);
    
   

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
        // 'enabled_payments' => $enable_payments,
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'item_details' => $item_details,
        
    );

    $snapToken = Snap::getSnapToken($transaction);
    echo json_encode($snapToken);
}
