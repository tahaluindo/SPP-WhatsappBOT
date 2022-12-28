<?php 

require_once 'Wapi.php';

function send($no,$cn)
{
    $n = '62' . ltrim($no, '0');
    
    $WASENDER = new WAPISENDER();
    $send = $WASENDER->SendMessage($cn,$n);
}

?>