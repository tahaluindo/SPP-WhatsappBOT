<?php

namespace Midtrans;
require_once(dirname(__FILE__) . '/vendor/autoload.php');
include "config/koneksi.php";
include "config/rupiah.php";

include "config/fungsi_indotgl.php";
Config::$isProduction = false;
   $idt = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM identitas"));
 
$link = $idt['link_one_sender'];
$links = $idt['token'];
//Set Your server key
$now = date('m');
$headers = array();
$headers[] =  $idt[token];
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
Config::$serverKey = "$idt[nipKaTU]";


	$da = file_get_contents('php://input');
	$result = json_decode($da);
	$fa = json_encode($result);
	

$notif = new \Midtrans\Notification();
 
$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$pdf_url = $notif->va_numbers;


$pr = $notif->gross_amount;
$fraud = $notif->fraud_status;
$str = "-";


if( strpos( $pr, $str ) !== false) {
    $hrg = $pr;
}
else
{
    $hr = explode(".",$pr);
    $hrg = $hr[0];
}



if ($transaction == 'capture') {
    echo "<p>Transaksi berhasil.</p>";
    echo "<p>Status transaksi untuk order id $response->order_id: " .
        "$response->transaction_status</p>";

    echo "<h3>Detail transaksi:</h3>";
    echo "<pre>";
    var_dump($response);
    echo "</pre>";
}
  if ($type == 'credit_card'){
    if($fraud == 'challenge'){
      // TODO set payment status in merchant's database to 'Challenge by FDS'
      // TODO merchant should decide whether this transaction is authorized or not in MAP
      echo "Transaction order_id: " . $order_id ." is challenged by FDS";
      }
      else {
      // TODO set payment status in merchant's database to 'Success'
      echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
      
      $up = mysqli_query($conn,"UPDATE tagihan_bulanan SET statusBayar='2'  WHERE inv='$order_id'");
      $up = mysqli_query($conn,"UPDATE tagihan_bebas SET statusBayar='2'  WHERE ref='$order_id'");
      
      
      }
    }
  
else if ($transaction == 'settlement'){
  // TODO set payment status in merchant's database to 'Settlement'
  echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
  
      $be = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tagihan_bebas WHERE ref='$order_id'"));
      
      $or = explode("-",$order_id);
    
      $tg = date("Y-m-d");
      $nw = date("Y-m-d H:i:s");
      $ta = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tahun_ajaran where status='Y'"));
      $thn = $ta['idTahunAjaran'];
      
      // tagihan bebas
      if($be)
      {
              
              $fee = 'Bayar Bebas';
              $da = [$be['idTagihanBebas'],$be['idSiswa'],$be['totalTagihan']];
              $ids = $be['idSiswa'];
              
              
              $siswa = mysqli_fetch_array(mysqli_query($conn,"SELECT siswa.*, kelas_siswa.nmKelas FROM siswa 
                                  
                                    LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas 
                                    WHERE siswa.idSiswa='$da[1]'"));
                                    
              $inisial = "SP".$siswa['nisnSiswa'].date('dmy');
              
              
            
                    
            $fi = mysqli_fetch_array(mysqli_query($conn,"SELECT SUM(jumlahBayar) AS Total FROM tagihan_bebas_bayar WHERE idTagihanBebas='$da[0]'"));
            $sm = empty($fi['Total']) ? 0 : $fi['Total'];
            
            $ns = (int) $sm;
            $tot = (int) $da[2];
            $num = (int) $hrg;
            $sis = $tot-($num+$ns);
            
            if($sis == 0)
            {
                $bs = mysqli_query($conn,"UPDATE tagihan_bebas SET statusBayar='1' WHERE ref='$order_id'");
            }
            
            
             $na = mysqli_query($conn,"SELECT * FROM tagihan_bebas
                                                INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                              WHERE ref='$order_id' ");
                                                
            $an = mysqli_fetch_array($na); 
             
             $pos = $an['nmJenisBayar'];
            
           
            
            $query = mysqli_query($conn,"INSERT INTO tagihan_bebas_bayar
                    (idTagihanBebas,tglBayar,jumlahBayar,ketBayar,caraBayar) VALUES 
                    ('$da[0]','$nw','$hrg','Transfer Bank Midtrans','Transfer')");
      }
      else
      {
          $de = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tagihan_bulanan WHERE inv='$order_id'"));
          $ids = $de['idSiswa'] ;
          $fee = 'Bayar Bulanan';
          $da = explode("-",$order_id);

            $bul = mysqli_query($conn,"UPDATE tagihan_bulanan SET statusBayar='1', tglBayar = '$nw', tglUpdate = '$nw' ,caraBayar = 'Transfer Midtrans' WHERE inv='$order_id'");
            
            $na = mysqli_query($conn,"SELECT * FROM tagihan_bulanan
                                    INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                      INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                    INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                   WHERE inv='$order_id'");
                                    
            $an = mysqli_fetch_array($na);
            
          
             $pos = $an['nmJenisBayar']. " Bulan " . $an['nmBulan'];
      }
       
        $sis = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM siswa INNER JOIN kelas_siswa ON siswa.idKelas = kelas_siswa.idKelas WHERE idSiswa='$ids'"));
        
    $nam = $sis['nmSiswa']; $kls = $sis['nmKelas']; $jml = rupiah($hrg); $no = $sis['noHpOrtu']; $nos = $sis['noHpSis']; $tgl = tgl_indo($tg);
      $ps = 'Terima Kasih, Pembayaran Sekolah Jenis '.$pos.' a/n *'.$nam.'*, Kelas '.$kls.' telah *SUKSES* kami terima tgl '.$tgl.' sejumlah *Rp '.$jml.'* ';
         $psa = 'Terima Kasih, Pembayaran Sekolah Jenis '.$pos.' anak anda a/n *'.$nam.'*, Kelas '.$kls.' telah *SUKSES* kami terima tgl '.$tgl.' sejumlah *Rp '.$jml.'* ';
      	$phone1 = $nos;						
						$ch1 = curl_init();					
						curl_setopt($ch1, CURLOPT_URL, $idt[link_one_sender]);
						curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch1, CURLOPT_POST, 1);      
						curl_setopt($ch1, CURLOPT_POSTFIELDS, "phone=$phone1&message=$ps&type=text");												
						curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);					
						$result1 = curl_exec($ch1);
						if (curl_errno($ch1)) {
							echo 'Error:' . curl_error($ch1);
						}
						curl_close($ch1);

						var_dump($result1);
						$phone = $no;						
							$ch = curl_init();					
							curl_setopt($ch, CURLOPT_URL,  $idt[link_one_sender]);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POST, 1);      
							curl_setopt($ch, CURLOPT_POSTFIELDS, "phone=$phone&message=$psa&type=text");												
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);					
							$result = curl_exec($ch);
							if (curl_errno($ch)) {
								echo 'Error:' . curl_error($ch);
							}
							curl_close($ch);

   
  }
  else if($transaction == 'pending'){
  // TODO set payment status in merchant's database to 'Pending'
  echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
    $bes = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tagihan_bebas WHERE ref='$order_id'"));
  
     if($bes)
      {
  
              $na = mysqli_query($conn,"SELECT * FROM tagihan_bebas
                                                INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                              WHERE ref='$order_id' ");
                                                
            $an = mysqli_fetch_array($na); 
             
             $pos = $an['nmJenisBayar'];
             
              $fee = 'Bayar Bebas';
              $da = [$bes['idTagihanBebas'],$bes['idSiswa'],$bes['totalTagihan']];
              $idss = $bes['idSiswa'];
              $up = mysqli_query($conn,"UPDATE tagihan_bebas SET statusBayar='2' WHERE ref='$order_id'");
      }
      else
      {       
           $na = mysqli_query($conn,"SELECT * FROM tagihan_bulanan
                                    INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                      INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                    INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                   WHERE inv='$order_id'");
                                    
            $an = mysqli_fetch_array($na);
            
          
             $pos = $an['nmJenisBayar']. " Bulan " . $an['nmBulan'];
             
           $de = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tagihan_bulanan WHERE inv='$order_id'"));
          $idss = $de['idSiswa'] ;
          $fee = 'Bayar Bulanan';
     $up = mysqli_query($conn,"UPDATE tagihan_bulanan SET statusBayar='2' WHERE inv='$order_id'");
   
         }
   $siss = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM siswa INNER JOIN kelas_siswa ON siswa.idKelas = kelas_siswa.idKelas WHERE idSiswa='$idss'"));
        
    $nams = $siss['nmSiswa']; $klss = $siss['nmKelas']; $jml = rupiah($hrg); $no = $siss['noHpOrtu'];  $nos = $siss['noHpSis']; $tgl = tgl_indo($tg);
      $pss = 'Silahkan *SELESAIKAN* Pembayaran Sekolah *'.$pos.'* siswa a/n *'.$nams.'*, Kelas '.$klss.' sejumlah *Rp '.$jml.'* cek Email anda untuk melihat intruksi pembayaran dan kode pembayaran   ';
      $psa = 'Silahkan *SELESAIKAN* Pembayaran Sekolah *'.$pos.'* anak anda a/n *'.$nams.'*, Kelas '.$klss.' sejumlah *Rp '.$jml.'* cek Email anda untuk melihat intruksi pembayaran dan kode pembayaran   ';
     
     	$phone1 = $nos;						
						$ch1 = curl_init();					
						curl_setopt($ch1, CURLOPT_URL, $idt[link_one_sender]);
						curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch1, CURLOPT_POST, 1);      
						curl_setopt($ch1, CURLOPT_POSTFIELDS, "phone=$phone1&message=$pss&type=text");												
						curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);					
						$result1 = curl_exec($ch1);
						if (curl_errno($ch1)) {
							echo 'Error:' . curl_error($ch1);
						}
						curl_close($ch1);

						var_dump($result1);
	$phone = $no;						
							$ch = curl_init();					
							curl_setopt($ch, CURLOPT_URL,  $idt[link_one_sender]);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POST, 1);      
							curl_setopt($ch, CURLOPT_POSTFIELDS, "phone=$phone&message=$psa&type=text");												
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);					
							$result = curl_exec($ch);
							if (curl_errno($ch)) {
								echo 'Error:' . curl_error($ch);
							}
							curl_close($ch);
  }
  
  else if ($transaction == 'deny') {
  // TODO set payment status in merchant's database to 'Denied'
  
  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
  }
  else if ($transaction == 'expire') {
  // TODO set payment status in merchant's database to 'expire'
  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
    $up = mysqli_query($conn,"UPDATE tagihan_bulanan SET statusBayar='0'  WHERE inv='$order_id'");
   
   $up = mysqli_query($conn,"UPDATE tagihan_bebas SET statusBayar='0' WHERE ref='$order_id'");
  
  
  
  }
  else if ($transaction == 'cancel') {
  // TODO set payment status in merchant's database to 'Denied'
  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
  
   $bess = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tagihan_bebas WHERE ref='$order_id'"));
  
     if($bess)
      {
  
              $na = mysqli_query($conn,"SELECT * FROM tagihan_bebas
                                                INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                              WHERE ref='$order_id' ");
                                                
            $an = mysqli_fetch_array($na); 
             
             $poss = $an['nmJenisBayar'];
             
              $fee = 'Bayar Bebas';
              $da = [$bes['idTagihanBebas'],$bes['idSiswa'],$bes['totalTagihan']];
              $idsss = $bes['idSiswa'];
               $up = mysqli_query($conn,"UPDATE tagihan_bebas SET statusBayar='0' WHERE ref='$order_id'");
      }
      else
      {       
           $na = mysqli_query($conn,"SELECT * FROM tagihan_bulanan
                                    INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                      INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                    INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                   WHERE inv='$order_id'");
                                    
            $an = mysqli_fetch_array($na);
            
          
             $poss = $an['nmJenisBayar']. " Bulan " . $an['nmBulan'];
             
           $de = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM tagihan_bulanan WHERE inv='$order_id'"));
          $idsss = $de['idSiswa'] ;
          $fee = 'Bayar Bulanan';
    $up = mysqli_query($conn,"UPDATE tagihan_bulanan SET statusBayar='0'  WHERE inv='$order_id'");
   
         }
        

   
            $sis = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM siswa INNER JOIN kelas_siswa ON siswa.idKelas = kelas_siswa.idKelas WHERE idSiswa='$idsss'"));
        
    $nams = $sis['nmSiswa']; $klss = $sis['nmKelas']; $jmls = rupiah($hrg); $no = $sis['noHpOrtu']; $nos = $sis['noHpSis']; $tgl = tgl_indo($tg);
      $pss = 'Maaf transaksi Pembayaran Sekolah *'.$poss.'* a/n '.$nams.', Kelas '.$klss.' *DIBATALKAN* oleh sistem , silahkan melakukan transaksi ulang di akun anda*  ';
      $psa = 'Maaf transaksi Pembayaran Sekolah *'.$poss.'* anak anda a/n '.$nams.', Kelas '.$klss.' *DIBATALKAN* oleh sistem , silahkan melakukan transaksi ulang di akun anda*  ';
    
     	$phone1 = $nos;						
						$ch1 = curl_init();					
						curl_setopt($ch1, CURLOPT_URL, $idt[link_one_sender]);
						curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch1, CURLOPT_POST, 1);      
						curl_setopt($ch1, CURLOPT_POSTFIELDS, "phone=$phone1&message=$pss&type=text");												
						curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers);					
						$result1 = curl_exec($ch1);
						if (curl_errno($ch1)) {
							echo 'Error:' . curl_error($ch1);
						}
						curl_close($ch1);

						var_dump($result1);
	$phone = $no;						
							$ch = curl_init();					
							curl_setopt($ch, CURLOPT_URL,  $idt[link_one_sender]);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POST, 1);      
							curl_setopt($ch, CURLOPT_POSTFIELDS, "phone=$phone&message=$psa&type=text");												
							curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);					
							$result = curl_exec($ch);
							if (curl_errno($ch)) {
								echo 'Error:' . curl_error($ch);
							}
							curl_close($ch);
     
}
