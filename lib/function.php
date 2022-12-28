<?php
session_start();
function encrypt($str) {
    $kunci = '979a218e0632df2935317f98d47956c7';
    for ($i = 0; $i < strlen($str); $i++) {
        $karakter = substr($str, $i, 1);
        $kuncikarakter = substr($kunci, ($i % strlen($kunci))-1, 1);
        $karakter = chr(ord($karakter)+ord($kuncikarakter));
        $hasil .= $karakter;
        
    }
    return urlencode(base64_encode($hasil));
}
 
function decrypt($str) {
    $str = base64_decode(urldecode($str));
    $hasil = '';
    $kunci = '979a218e0632df2935317f98d47956c7';
    for ($i = 0; $i < strlen($str); $i++) {
        $karakter = substr($str, $i, 1);
        $kuncikarakter = substr($kunci, ($i % strlen($kunci))-1, 1);
        $karakter = chr(ord($karakter)-ord($kuncikarakter));
        $hasil .= $karakter;
        
    }
    return $hasil;
}

function login_validate() {
    $timeout = 30; 
    $_SESSION['expires_by'] = time() + $timeout;
}

function login_check() {
    $exp_time = $_SESSION['expires_by'];
    if (time() < $exp_time) {
        login_validate();
        return true; 
    } else {
        unset($_SESSION['expires_by']);
        return false; 
    }
}
?>